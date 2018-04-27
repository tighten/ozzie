<?php

namespace App\Http\Controllers;

use App\Project;
use Carbon\Carbon;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function show()
    {
        try {
            $projects = Cache::remember('projects', 60, function () {
                $projects = collect(json_decode(file_get_contents(base_path('projects.json'))))->sortBy('name');

                return $projects->map(function ($project) {
                    return new Project($project->namespace, $project->name, $project->maintainers);
                });
            });

            return view('dashboard')->with('projects', $projects);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            abort(404);
        }
    }
}
