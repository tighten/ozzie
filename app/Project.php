<?php

namespace App;

use DateTime;
use Exception;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Cache;

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

		public function getDebtScoreHistory()
		{

				return Cache::remember('debt_score_history_' . $this->name, 60 * 60, function () {
					$list = [];
					$now = Carbon::now();
					$period = new CarbonPeriod($now->parse()->subDays(7)->format('Y-m-d'), $now->format('Y-m-d'));
					foreach ($period as $key => $date) {
						$snapshot = Snapshot::where('name', $this->name)->where('snapshot_date', $date->format('Y-m-d'))->orderBy('snapshot_date')->first();
						$list[] = $snapshot->debt_score ?? 0;
					}
					return $list;
				});
		}
}
