<?php

namespace App\GitHub;

use App\GitHub\Dto\Issue;
use App\GitHub\Dto\Pr;
use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;

class GitHub
{
    public function projectIssues($namespace, $name)
    {
        return collect(GitHubClient::issues()->all($namespace, $name))
            ->map(function ($issue) {
                return new Issue($issue);
            })->reject(function (Issue $issue) {
                return ! is_null($issue->pull_request);
            });
    }

    public function projectPrs($namespace, $name)
    {
        return collect(GitHubClient::pullRequests()->all($namespace, $name))
            ->map(function ($pr) {
                return new Pr($pr);
            });
    }
}
