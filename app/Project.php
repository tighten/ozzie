<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

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

    /**
     * Query Github for issues
     * @return void
     */
    protected function hydrateIssues(): void
    {
        $this->issues = $this->github->projectIssues($this->namespace, $this->name);
    }

    /**
     * Query Github for pull requests
     * @return void
     */
    protected function hydratePrs(): void
    {
        $this->prs = $this->github->projectPrs($this->namespace, $this->name);
    }

    /**
     * Issues
     * @return Collection
     */
    public function issues(): Collection
    {
        return $this->issues;
    }

    /**
     * Pull requests
     * @return Collection
     */
    public function prs(): Collection
    {
        return $this->prs;
    }

    /**
     * __get magic method
     * @param  string $key
     */
    public function __get($key)
    {
        if (in_array($key, ['name', 'namespace', 'maintainers'])) {
            return $this->$key;
        }

        throw new Exception('No such property ' . $key);
    }

    /**
     * Old pull requests
     * @return Collection
     */
    public function oldPrs(): Collection
    {
        return $this->prs->filter(function ($pr) {
            $date = Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $pr['created_at']);
            return $date->diff(new DateTime)->days > 30;
        });
    }

    /**
     * Old issues
     * @return collection
     */
    public function oldIssues(): Collection
    {
        return $this->issues->filter(function ($issue) {
            $date = Carbon::createFromFormat('Y-m-d\TG:i:s\Z', $issue['created_at']);
            return $date->diff(new DateTime)->days > 30;
        });
    }

    /**
     * Project debt score
     * @return float
     */
    public function debtScore(): float
    {
        return array_sum([
            $this->oldIssues()->count() * 5,
            $this->issues()->count() * 1,
            $this->oldPrs()->count() * 25,
            $this->prs()->count() * 13,
        ]) / 100;
    }
}
