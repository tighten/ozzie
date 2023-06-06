<?php

namespace App\Console\Commands;

use App\Cache\CachedProjectList;
use App\GitHub\Organization;
use App\Models\Project;
use App\Remotes\Packagist\Search;
use Illuminate\Console\Command;

class FetchGitHubProjects extends Command
{
    protected $signature = 'projects:fetch
                            {--archived : Include repos marked as archived}
                            {--fork : Include repos that are forks of another repo}
                            {--all : Include all public repos (shorthand for --archived --fork)}';

    protected $description = "Fetches the organization's GitHub repositories. By default, repos are only added if they are:
    - public
    - not archived
    - not a fork";

    protected $projects;

    protected $added = 0;

    public function handle(): int
    {
        $orgName = config('app.organization');
        $org = new Organization($orgName);

        $this->info("Fetching GitHub repositories for {$orgName}...");

        // Get current projects in the database for later lookup
        $this->projects = Project::all()
            ->map(function ($project) {
                return "{$project->namespace}/{$project->name}";
            });

        // Fetch org repos from GitHub and filter out archive/forks
        $this->filterRepos($org->repositories())
            ->tap(function ($repos) {
                $this->info("Found {$repos->count()} repositories. Adding to projects table...");
            })
            ->each(function ($repo) {
                if (! $this->projects->contains($repo->full_name)) {
                    $this->line("  Adding {$repo->full_name}...");

                    $this->added++;

                    $project = Project::create([
                        'namespace' => $repo->namespace,
                        'name' => $repo->name,
                        'packagist_name' => null,
                        'issues' => [],
                        'pull_requests' => [],
                    ]);

                    // Find its Packagist listing, if applicable
                    $packagistSearch = Search::forPackageByRepo($project);

                    $project->packagist_name = $packagistSearch->packagistName;
                    $project->save();
                }
            });

        $this->info("Done! Added {$this->added} projects to the database.");

        // Clear frontend cache
        cache()->clear();

        // Rebuild cache of projects
        app(CachedProjectList::class)();

        return 0;
    }

    public function filterRepos($repos)
    {
        if ($this->option('all')) {
            return $repos;
        }

        return $repos->reject(function ($repo) {
            foreach (['archived', 'fork'] as $attribute) {
                if (! $this->option($attribute) && $repo->{$attribute} === true) {
                    return true;
                }
            }
        });
    }
}
