<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;

class IssueController extends Controller
{
    public function show(string $namespace, string $name, int $id)
    {
        $project = Project::fromNamespaceAndName($namespace, $name)->firstOrFail();

        return inertia('Issue/Show', [
            'project' => new ProjectResource($project),
            'issue' => $project->issues->where('number', $id)->first(),
        ]);
    }
}
