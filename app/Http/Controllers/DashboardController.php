<?php

namespace App\Http\Controllers;

use App\Project;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function show()
    {
        /* At the moment I don't trust our GitHub package to be caching correctly. */
        $projects = Cache::remember('projects', 60, function () {
            $projects = collect(json_decode(file_get_contents(base_path('projects.json'))));

            return $projects->map(function ($project) {
                return new Project($project->namespace, $project->name, $project->maintainer);
            });
        });

        return view('dashboard')->with('projects', $projects);
    }
}
