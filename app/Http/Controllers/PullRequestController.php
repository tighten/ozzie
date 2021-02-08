<?php

namespace App\Http\Controllers;

use App\Project;

class PullRequestController extends Controller
{
    public function show(string $namespace, string $projectName, int $pullRequestNumber)
    {
        $project = Project::where('namespace', $namespace)->where('name', $projectName)->firstOrFail();

        return inertia('PullRequest/Show', [
            'project' => $project,
            'pullRequest' => $project->pull_requests->where('number', $pullRequestNumber)->first(),
        ]);
    }
}
