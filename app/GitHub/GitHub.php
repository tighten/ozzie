<?php

namespace App\GitHub;

use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;

class GitHub
{
    public function projectIssues($namespace, $name)
    {
        return collect(GitHubClient::issues()->all($namespace, $name))->reject(function ($issue) {
            return isset($issue['pull_request']);
        });
    }

    public function projectPrs($namespace, $name)
    {
        return collect(GitHubClient::pullRequests()->all($namespace, $name));
    }
}
