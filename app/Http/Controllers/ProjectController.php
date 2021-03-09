<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index()
    {
        return inertia(
            'Projects/Index',
            Cache::rememberForever(
                'projects',
                function () {
                    return [
                        'projects' => Project::all()
                            ->transform(fn($project) => new ProjectResource($project))
                            ->sortByDesc(fn($project) => $project->resource->debtScore())
                            ->values(),
                        'hacktoberfest' => Carbon::now()->isSameMonth(Carbon::parse('October')),
                        'organization' => config('app.organization'),
                    ];
                }
            )
        );
    }

    public function show(string $vendor, string $name)
    {
        ray(['vendor' => $vendor, 'name' => $name]);
        return inertia(
            'Projects/Show',
            Cache::rememberForever(
                "{$vendor}-{$name}",
                function () use ($vendor, $name) {
                    $project = Project::fromVendorAndName($vendor, $name)->firstOrFail();
                    return ['project' => new ProjectResource($project)];
                }
            )
        );
    }
}
