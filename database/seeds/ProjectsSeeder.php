<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        $projectsJson = file_get_contents(Storage::disk('root')->exists('projects.json') ? base_path('projects.json') : base_path('projects.json.dist'));

        collect(json_decode($projectsJson, true))
            ->each(function($project) {
                Project::create([
                    'namespace' => $project['namespace'],
                    'name' => $project['name'],
                    'maintainers' => $project['maintainers'],
                    'issues_count' => 0,
                    'pull_requests_count' => 0,
                    'issues' => [],
                    'pull_requests' => [],
                ]);
            });
    }
}
