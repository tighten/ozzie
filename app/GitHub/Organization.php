<?php

namespace App\GitHub;

use App\GitHub\Dto\Repo;
use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;

class Organization
{
    public $orgName;

    public function __construct($orgName)
    {
        $this->orgName = $orgName;
    }

    public function repositories()
    {
        $repos = collect();
        $page = 1;

        do {
            $results = GitHubClient::repositories()->org(
                $this->orgName,
                [
                    'page' => $page,
                    'per_page' => 100,
                ]
            );

            $repos = $repos->merge($results);

            $page = $results ? $page + 1 : null;
        } while ($page);

        return $repos->map(function ($repo) {
            return new Repo($repo);
        });
    }
}
