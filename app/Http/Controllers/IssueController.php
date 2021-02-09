<?php

namespace App\Http\Controllers;

use App\Project;

class IssueController extends Controller
{
    public function show(string $projectNamespace, string $projectName, int $issueNumber)
    {
        $project = Project::fromNamespaceAndName($projectNamespace, $projectName)->firstOrFail();

        // TODO abstract some standard code for hydrating the project object for javascript
        //   e.g. use Laravel / Inertia JSON factories...??
        return inertia('Issue/Show', [
            'project' => $project,
            'issue' => $project->issues->where('number', $issueNumber)->first(),
        ]);
    }
}
