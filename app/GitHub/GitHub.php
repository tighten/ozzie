<?php

namespace App\GitHub;

use App\GitHub\Dto\IssueData;
use App\GitHub\Dto\PrData;
use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;

class GitHub
{
    public function projectIssues($namespace, $name)
    {
        return collect(GitHubClient::issues()->all($namespace, $name))
            ->map(function ($issue) {
                return new IssueData($issue);
            })->reject(function (IssueData $issue) {
                return ! is_null($issue->pull_request);
            });
    }

    public function projectPrs($namespace, $name)
    {
        return collect(GitHubClient::pullRequests()->all($namespace, $name))
            ->map(function ($pr) {
                return new PrData($pr);
            });
    }
}
