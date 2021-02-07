<?php

namespace App\Http\Controllers;

use App\Project;

class IssueController extends Controller
{
    public function show(string $namespace, string $projectName, int $issueNumber)
    {
        $project = Project::where('namespace', $namespace)->where('name', $projectName)->firstOrFail();
        return inertia('Issue/Show', [
            'project' => $project,
            'issue' => $project->issues->where('number', $issueNumber)->first()
        ]);
    }
}
