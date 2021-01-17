<?php

namespace App\GitHub;

use App\GitHub\Dto\Issue;
use App\GitHub\Dto\PullRequest;
use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;

class Repository
{
    public $name;
    public $namespace;

    public function __construct($namespace, $name)
    {
       $this->namespace = $namespace;
       $this->name = $name;
    }

    public function issues()
    {
        return collect(GitHubClient::issues()->all($this->namespace, $this->name))
            ->map(function ($issue) {
                return new Issue($issue);
            })->reject(function (Issue $issue) {
                return ! is_null($issue->pull_request);
            });
    }

    public function pullRequests()
    {
        return collect(GitHubClient::pullRequests()->all($this->namespace, $this->name))
            ->map(function ($pullRequest) {
                return new PullRequest($pullRequest);
            });
    }
}
