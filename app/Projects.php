<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class Projects
{
    public function all()
    {
        $projects = Cache::remember('projects', 60 * 60, function () {
            return $this->load()->sortBy('name')->map(function ($project) {
                return new Project(
                    $project->namespace,
                    $project->name,
                    $project->maintainers
                );
            });
        });

        return $projects;
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

    public function path()
    {
        return base_path('projects.json');
    }
}
