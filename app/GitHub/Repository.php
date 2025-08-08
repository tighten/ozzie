<?php

namespace App\GitHub;

use App\GitHub\Dto\Issue;
use App\GitHub\Dto\PullRequest;
use App\Models\FetchResult;
use App\Models\Project;
use Exception;
use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;

class Repository
{
    public $name;

    public $namespace;

    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->namespace = $project->namespace;
        $this->name = $project->name;
    }

    public function isArchived()
    {
        try {
            return GitHubClient::repo()->show($this->namespace, $this->name)['archived'];
        } catch (Exception $th) {
            return false;
        }
    }

    public function issues()
    {
        try {
            return collect(GitHubClient::issues()->all($this->namespace, $this->name))
                ->tap(fn () => FetchResult::githubSuccess($this->project))
                ->map(function ($issue) {
                    return new Issue($issue);
                })->reject(function (Issue $issue) {
                    return ! is_null($issue->pull_request);
                });
        } catch (Exception $th) {
            FetchResult::githubFail($this->project);

            return collect();
        }
    }

    public function pullRequests()
    {
        try {
            return collect(GitHubClient::pullRequests()->all($this->namespace, $this->name))
                ->map(function ($pullRequest) {
                    return new PullRequest($pullRequest);
                });
        } catch (Exception $th) {
            return collect();
        }
    }
}
