<?php

namespace App\Console\Commands;

use App\GitHub\Repository;
use App\Project;
use App\Remotes\Packagist\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class FetchProjectStats extends Command
{
    protected $signature = 'stats:fetch';

    protected $description = "Fetch each project's stats from GitHub and store in the projects table.";

    public function handle()
    {
        cache()->clear();

        $projects = Project::all();

        $this->createProgressBar($projects->count());

        foreach ($projects as $project) {
            $this->fetchOneProject($project);
        }

        $this->bar->finish();

        return 0;
    }

    public function fetchOneProject(Project $project)
    {
        $this->updateProgressBar($project->name);

        // Fetch GitHub project issues and pull requests
        $githubProject = new Repository($project->namespace, $project->name);
        $issues = $this->filterIssues($githubProject->issues());
        $pullRequests = $this->filterPullRequests($githubProject->pullRequests());

        $project->issues_count = $issues->count();
        $project->pull_requests_count = $pullRequests->count();

        $project->issues = $issues;
        $project->pull_requests = $pullRequests;

        // Fetch download counts (if applicable)
        $packagist = Package::fromProject($project);
        $project->downloads_total = $packagist->totalDownloads;
        $project->downloads_last_30_days = $packagist->monthlyDownloads;

        $project->save();
    }

    public function filterIssues($issues)
    {
        return $issues->reject(function ($issue) {
            return collect($issue->labels)->contains('name', 'in progress');
        });
    }

    public function filterPullRequests($pullRequests)
    {
        return $pullRequests->reject(function ($pullRequest) {
            return $pullRequest->draft || collect($pullRequest->labels)->contains('name', 'in progress');
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
