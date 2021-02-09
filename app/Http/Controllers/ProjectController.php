<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;
use Illuminate\Support\Carbon;

class ProjectController extends Controller
{
    public function index()
    {
        return inertia('Projects/Index', [
            'projects' => Project::all()
                ->transform(fn($project) => new ProjectResource($project))
                ->sortByDesc(fn($project) => $project->resource->debtScore())
                ->values(),
            'hacktoberfest' => Carbon::now()->isSameMonth(Carbon::parse('October')),
        ]);
    }

    public function show(string $projectNamespace, string $projectName)
    {
        return inertia('Projects/Show', [
            'project' => new ProjectResource(
                Project::fromNamespaceAndName($projectNamespace, $projectName)->firstOrFail()
            ),
        ]);
    }
}
