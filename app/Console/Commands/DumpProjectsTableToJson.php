<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DumpProjectsTableToJson extends Command
{
    protected $signature = 'projects:json {--all}';

    protected $description = 'Dump the list of visible projects from MySQL to projects.json.dist, ordered by name. By default, any project marked as hidden is not exported; use the --all flag to dump all projects.';

    public function handle(): void
    {
        $query = Project::query()->orderBy('name');

        if ($this->option('all')) {
            $projects = $query->get();
        } else {
            $projects = $query->notHidden()->get();
        }

        $this->line("Dumping {$projects->count()} projects to projects.json.dist");

        $projectInfo = $projects->map(function ($project) {
            return [
                'name' => $project->name,
                'namespace' => $project->namespace,
                'packagist_name' => $project->packagist_name,
                'maintainers' => $project->maintainers->pluck('github_username'),
            ];
        })->toArray();

        Storage::disk('root')->put('projects.json.dist', json_encode($projectInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info('Done!');
    }
}
