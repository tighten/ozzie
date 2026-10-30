<?php

namespace App\Console\Commands;

use App\Cache\CachedProjectList;
use App\Enums\PackageRegistry;
use App\GitHub\Repository;
use App\Models\Project;
use App\Remotes\Npm\Package as NpmPackage;
use App\Remotes\PackageRegistryDetector;
use App\Remotes\Packagist\Package as PackagistPackage;
use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('stats:fetch')]
#[Description("Fetch each project's stats from GitHub and store in the projects table.")]
class FetchProjectStats extends Command
{
    protected $bar;

    public function __construct(protected PackageRegistryDetector $detector)
    {
        parent::__construct();
    }

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
        $this->fetchDownloads($project);

        $project->save();
    }

    public function fetchDownloads(Project $project): void
    {
        if (! $project->package_registry->isDetermined()) {
            $this->detectRegistry($project);
        }

        if (! $project->package_registry->publishesPackage()) {
            return;
        }

        $package = match (true) {
            $project->package_registry === PackageRegistry::Packagist && filled($project->packagist_name) => PackagistPackage::fromProject($project),
            $project->package_registry === PackageRegistry::Npm && filled($project->npm_name) => NpmPackage::fromProject($project),
            default => null,
        };

        if (is_null($package)) {
            $this->warn("Skipping downloads for {$project->name}: it's marked as a {$project->package_registry->label()} package but has no package name.");

            return;
        }

        if ($package->requestOk) {
            $project->downloads_total = $package->totalDownloads;
            $project->downloads_last_30_days = $package->monthlyDownloads;

            return;
        }

        // The registry says the name we're holding doesn't exist there, so our
        // record is stale. Work out where this project actually lives (if
        // anywhere) instead of failing the same way again tomorrow.
        if ($package->packageMissing) {
            $this->warn("{$project->name} was not found on {$project->package_registry->label()}; re-detecting.");

            $this->detectRegistry($project, redetect: true);
        }
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

    protected function detectRegistry(Project $project, bool $redetect = false): void
    {
        $registry = $redetect
            ? $this->detector->redetect($project)
            : $this->detector->detect($project);

        if (is_null($registry)) {
            $this->warn("Could not determine which package registry {$project->name} belongs to.");

            return;
        }

        $this->line("... {$project->name} package registry: {$registry->label()}");
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
