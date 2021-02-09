<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;

class PullRequestController extends Controller
{
    public function show(string $projectNamespace, string $projectName, int $pullRequestNumber)
    {
        $project = Project::fromNamespaceAndName($projectNamespace, $projectName)->firstOrFail();

        return inertia('PullRequest/Show', [
            'project' => new ProjectResource($project),
            'pullRequest' => $project->pull_requests->where('number', $pullRequestNumber)->first(),
        ]);
    }
}
