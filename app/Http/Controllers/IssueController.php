<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;
use Illuminate\Support\Facades\Cache;

class IssueController extends GithubIssueController
{
    public function show(string $vendor, string $name, int $id)
    {
        return inertia(
            'Issue/Show',
            Cache::rememberForever(
                "{$vendor}-{$name}-issue-{$id}",
                function () use ($vendor, $name, $id) {
                    $project = Project::fromVendorAndName($vendor, $name)->firstOrFail();
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
