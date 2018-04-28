<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function show()
    {
        $projects = Cache::remember('projects', 60, function () {
            $projects = collect(json_decode(file_get_contents(base_path('projects.json'))))->sortBy('name');

            return $projects->map(function ($project) {
                return new Project($project->namespace, $project->name, $project->maintainers);
            });
        });

        return view('dashboard')->with('projects', $projects);
    }
}
