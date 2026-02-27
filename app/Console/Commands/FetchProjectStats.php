<?php

namespace App\Console\Commands;

use App\Cache\CachedProjectList;
use App\GitHub\Repository;
use App\Models\Project;
use App\Remotes\Packagist\Package;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FetchProjectStats extends Command
{
    protected $signature = 'stats:fetch';

    protected $description = "Fetch each project's stats from GitHub and store in the projects table.";

    protected $bar;

    public function handle(): int
    {
        $projects = Project::where('is_hidden', false)->get();

        $this->createProgressBar($projects->count());

        foreach ($projects as $project) {
            $this->fetchOneProject($project);
        }

        $this->bar->finish();
        $this->newLine();

        // Clear frontend cache
        cache()->clear();

        // Rebuild cache of projects
        app(CachedProjectList::class)();

        return 0;
    }

    public function fetchOneProject(Project $project)
    {
        $this->updateProgressBar($project->name);

        $githubProject = new Repository($project);

        try {
            $repoExists = $githubProject->exists();
        } catch (Exception $e) {
            $this->warn("Skipping {$project->name}: {$e->getMessage()}");

            return;
        }

        if (! $repoExists) {
            $this->warn("Hiding {$project->name}: repo not found on GitHub.");
            $project->update(['is_hidden' => true]);

            return;
        }

        if ($githubProject->isArchived()) {
            $this->warn("Hiding {$project->name}: repo is archived on GitHub.");
            $project->update(['is_hidden' => true]);

            return;
        }

        // Fetch GitHub project issues and pull requests
        $issues = $this->filterIssues($githubProject->issues());
        $pullRequests = $this->filterPullRequests($githubProject->pullRequests());

        $project->issues_count = $issues->count();
        $project->pull_requests_count = $pullRequests->count();

        // We call ->values() here to re-key the collection after filtering
        $project->issues = $issues->values();
        $project->pull_requests = $pullRequests->values();

        // Fetch download counts (if applicable)
        if ($project->packagist_name) {
            $packagist = Package::fromProject($project);

            if ($packagist->requestOk) {
                $project->downloads_total = $packagist->totalDownloads;
                $project->downloads_last_30_days = $packagist->monthlyDownloads;
            }
        }

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
        $this->info("Fetching stats for {$count} ".Str::plural('project', $count));
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
