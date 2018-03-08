<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use Exception;

class Project
{
    protected $prs;
    protected $issues;
    protected $namespace;
    protected $name;
    protected $maintainer;
    protected $github;

    public function __construct($namespace, $name, $maintainer)
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->maintainer = $maintainer;

        $this->github = app('mygithub');

        $this->hydratePrs();
        $this->hydrateIssues();
    }

    protected function hydrateIssues()
    {
        $this->issues = $this->github->projectIssues($this->namespace, $this->name);
    }

    protected function hydratePrs()
    {
        $this->prs = $this->github->projectPrs($this->namespace, $this->name);
    }

    public function issues()
    {
        return $this->issues;
    }

    public function prs()
    {
        return $this->prs;
    }

    public function __get($key)
    {
        if (in_array($key, ['name', 'namespace', 'maintainer'])) {
            return $this->$key;
        }

        throw new Exception('No such property ' . $key);
    }

    public function oldPrs()
    {
        return $this->prs->filter(function ($pr) {
            $date = Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $pr['created_at']);
            return $date->diff(new DateTime)->days > 30;
        });
    }

    public function oldIssues()
    {
        return $this->issues->filter(function ($issue) {
            $date = Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $issue['created_at']);
            return $date->diff(new DateTime)->days > 30;
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
}
