<?php

namespace App\Http\Controllers;

use App\Project;

class PullRequestController extends Controller
{
    public function show(string $namespace, string $projectName, int $pullRequestNumber)
    {
        $project = Project::where('namespace', $namespace)->where('name', $projectName)->firstOrFail();

        // TODO abstract some standard code for hydrating the project object for javascript
        //   e.g. use Laravel / Inertia JSON factories...??
        return inertia('PullRequest/Show', [
            'project' => $project,
            'pullRequest' => $project->pull_requests->where('number', $pullRequestNumber)->first(),
        ]);
    }
}
