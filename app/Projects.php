<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Projects
{
    public function all()
    {
        return Cache::remember('projects', 60 * 60, function () {
            return $this->load()->sortBy('name')->map(function ($project) {
                return new Project(
                    $project->namespace,
                    $project->name,
                    $project->maintainers
                );
            });
        });
    }

    public function load()
    {
        return collect(
            json_decode(
                file_get_contents(
                    $this->path()
                )
            )
        );
    }

    public function write($projects)
    {
        file_put_contents(
            base_path('projects.json'),
            $projects
        );
    }

    public function path()
    {
        return Storage::disk('root')->exists('projects.json') ? base_path('projects.json') : base_path('projects.json.dist');
    }
}
