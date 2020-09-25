<?php

namespace App\Console\Commands;

use App\GitHub\GitHub;
use App\Project;
use Illuminate\Console\Command;

class FetchProjectStats extends Command
{
    protected $signature = 'stats:fetch';

    protected $description = "Fetch each project's stats from GitHub and store in the projects table.";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            $githubProject = new GitHub($project->namespace, $project->name);
            $issues = $this->getFilteredIssues($githubProject->projectIssues());
            $pullRequests = $this->getFilteredPullRequests($githubProject->projectPullRequests());

            $project->issues_count = $issues->count();
            $project->pull_requests_count = $pullRequests->count();
            $project->issues = $issues;
            $project->pull_requests = $pullRequests;

            $project->save();
        }

        return 0;
    }

    public function getFilteredIssues($issues)
    {
        return $issues->reject(function ($issue) {
            return ! empty($issue->labels)
                && collect($issue->labels)->contains('name', 'in progress');
        });
    }

    public function getFilteredPullRequests($pullRequests)
    {
        return $pullRequests->reject(function ($pullRequest) {
            return $pullRequest->draft || (
                    ! empty($pullRequest->labels)
                    && collect($pullRequest->labels)->contains('name', 'in progress')
                );
        });
    }
}
