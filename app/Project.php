<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

use DateTime;
use Exception;

class Project
{
    protected $prs;
    protected $issues;
    protected $namespace;
    protected $name;
    protected $maintainers;
    protected $github;

    public function __construct($namespace, $name, $maintainers)
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->maintainers = $maintainers;

        $this->github = app('mygithub');

        $this->hydratePrs();
        $this->hydrateIssues();
    }

    public function issues()
    {
        return $this->issues->reject(function ($issue) {
            return ! empty($issue->labels)
                && collect($issue->labels)->contains('name', 'in progress');
        });
    }

    public function prs()
    {
        return $this->prs->reject(function ($pr) {
            return $pr->draft || (
                    ! empty($pr->labels)
                    && collect($pr->labels)->contains('name', 'in progress')
                );
        });
    }

    public function __get($key)
    {
        if (in_array($key, ['name', 'namespace', 'maintainers'])) {
            return $this->$key;
        }

        throw new Exception('No such property ' . $key);
    }

    public function hacktoberfestIssues()
    {
        return $this->issues->filter(function ($issue) {
            return ! empty($issue->labels)
                && collect($issue->labels)->contains('name', 'hacktoberfest');
        });
    }

    public function oldPrs()
    {
        return $this->prs()->filter(function ($pr) {
            return $pr->created_at->diff(new DateTime)->days > 30;
        });
    }

    public function oldIssues()
    {
        return $this->issues()->filter(function ($issue) {
            return $issue->created_at->diff(new DateTime)->days > 30;
        });
    }

    public function debtScore()
    {
        return array_sum([
            $this->oldIssues()->count() * 5,
            $this->issues()->count() * 1,
            $this->oldPrs()->count() * 25,
            $this->prs()->count() * 13,
        ]) / 100;
    }

    public function url()
    {
        return 'https://github.com/' . $this->namespace . '/' . $this->name;
    }

    protected function hydrateIssues()
    {
        $this->issues = $this->github->projectIssues($this->namespace, $this->name);
    }

    protected function hydratePrs()
    {
        $this->prs = $this->github->projectPrs($this->namespace, $this->name);
    }

		public function packagistUrl()
		{
				return 'https://packagist.org/packages/tightenco/' . $this->name . '.json';
		}

		public function downloadsTotal()
		{
				return $this->packagistDownloads('total');
		}

		public function downloadsMonthly()
		{
				return $this->packagistDownloads('monthly');
		}

		public function packagistDownloads($period)
		{
				return Cache::remember('downloads_' . $period . '_' . $this->name, 60 * 60 * 24, function () use ($period) {
					$response = Http::get($this->packagistUrl());
					if ($response->ok()) {
						$json = $response->json();
						return $json['package']['downloads'][$period] ?? 0;
					}
					return 0;
				});
		}
}
