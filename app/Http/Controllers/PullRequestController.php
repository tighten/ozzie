<?php

namespace App\Http\Controllers;

use App\Project;

class PullRequestController extends Controller
{
    public function show(string $projectNamespace, string $projectName, int $pullRequestNumber)
    {
        $project = Project::fromNamespaceAndName($projectNamespace, $projectName)->firstOrFail();

        // TODO abstract some standard code for hydrating the project object for javascript
        //   e.g. use Laravel / Inertia JSON factories...??
        return inertia('PullRequest/Show', [
            'project' => $project,
            'pullRequest' => $project->pull_requests->where('number', $pullRequestNumber)->first(),
        ]);
    }
}
