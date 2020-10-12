<?php

namespace App\Console\Commands;

use App\GitHub\GitHub;
use App\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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

        $this->createProgressBar($projects->count());

        foreach ($projects as $project) {
            $this->updateProgressBar($project->name);

            $githubProject = new GitHub($project->namespace, $project->name);
            $issues = $this->getFilteredIssues($githubProject->projectIssues());
            $pullRequests = $this->getFilteredPullRequests($githubProject->projectPullRequests());

            $project->issues_count = $issues->count();
            $project->pull_requests_count = $pullRequests->count();
            $project->issues = $issues;
            $project->pull_requests = $pullRequests;

            $project->save();
        }

        $this->bar->finish();

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

    protected function createProgressBar($count)
    {
        $this->info("Fetching stats for {$count} " . Str::plural('project', $count));
        $this->bar = $this->output->createProgressBar($count);
    }

    protected function updateProgressBar($current)
    {
        $this->bar->advance();

        // Display current task context above the progress bar
        $this->bar->clear();
        $this->line("... {$current}");
        $this->bar->display();
    }
}
