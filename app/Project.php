<?php

namespace App;

use Exception;

class Project
{
    protected $prs = [];
    protected $issues = [];
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

        $this->prs = $this->getPrs();
        $this->issues = $this->getIssues();
    }

    protected function getIssues()
    {
        return $this->github->projectIssues($this->namespace, $this->name);
    }

    protected function getPrs()
    {
        return $this->github->projectPrs($this->namespace, $this->name);
    }

    public function __get($key)
    {
        if (in_array($key, ['name', 'namespace', 'maintainer', 'issues', 'prs'])) {
            return $this->$key;
        }

        throw new Exception('No such property ' . $key);
    }
}
