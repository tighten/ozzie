<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;

class PullRequestController extends Controller
{
    public function show(string $namespace, string $name, int $id)
    {
        $project = Project::fromNamespaceAndName($namespace, $name)->firstOrFail();

        return inertia('PullRequest/Show', [
            'project' => new ProjectResource($project),
            'pullRequest' => $project->pull_requests->where('number', $id)->first(),
        ]);
    }
}
