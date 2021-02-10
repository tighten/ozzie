<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;

class IssueController extends Controller
{
    public function show(string $projectNamespace, string $projectName, int $issueNumber)
    {
        $project = Project::fromNamespaceAndName($projectNamespace, $projectName)->firstOrFail();

        return inertia('Issue/Show', [
            'project' => new ProjectResource($project),
            'issue' => $project->issues->where('number', $issueNumber)->first(),
        ]);
    }
}
