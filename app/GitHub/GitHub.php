<?php

namespace App\GitHub;

use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;

class GitHub
{
    public function projectIssues($namespace, $name)
    {
        return GitHubClient::issues()->all($namespace, $name);
    }

    public function projectPrs($namespace, $name)
    {
        return GitHubClient::issues()->all($namespace, $name);
    }
}
