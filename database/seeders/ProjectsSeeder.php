<?php

namespace Database\Seeders;

use App\Enums\PackageRegistry;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $projectsJson = file_get_contents(
            Storage::disk('root')->exists('projects.json')
                ? base_path('projects.json')
                : base_path('projects.json.dist')
        );

        collect(json_decode($projectsJson, true))
            ->each(function ($project) {
                $project = Project::updateOrCreate([
                    'namespace' => $project['namespace'],
                    'name' => $project['name'],
                ], [
                    'packagist_name' => $project['packagist_name'] ?? null,
                    'npm_name' => $project['npm_name'] ?? null,
                    'package_registry' => PackageRegistry::tryFrom($project['package_registry'] ?? '')
                        ?? (filled($project['packagist_name'] ?? null) ? PackageRegistry::Packagist : PackageRegistry::Unknown),
                ]);

                if ($project->wasRecentlyCreated) {
                    $project->update([
                        'issues_count' => 0,
                        'pull_requests_count' => 0,
                        'issues' => [],
                        'pull_requests' => [],
                    ]);
                }
            });
    }
}
