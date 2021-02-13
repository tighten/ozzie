<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;

class IssueController extends Controller
{
    public function show(string $projectNamespace, string $name, int $issueNumber)
    {
        $project = Project::fromNamespaceAndName($projectNamespace, $name)->firstOrFail();

        return inertia('Issue/Show', [
            'project' => new ProjectResource($project),
            'issue' => $project->issues->where('number', $issueNumber)->first(),
        ]);
    }
}
