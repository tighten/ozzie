<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;
use Illuminate\Support\Facades\Cache;

class IssueController extends GithubIssueController
{
    public function show(string $namespace, string $name, int $id)
    {
        return inertia(
            'Issue/Show',
            Cache::rememberForever(
                "{$namespace}-{$name}-issue-{$id}",
                function () use ($namespace, $name, $id) {
                    $project = Project::fromNamespaceAndName($namespace, $name)->firstOrFail();
                    return [
                       'project' => new ProjectResource($project),
                       'issue' =>  $project->issue($id),
                       'body' => $this->parseMarkdown($project->issue($id)['body']),
                    ];
                }
            )
        );
    }
}
