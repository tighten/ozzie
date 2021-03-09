<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;
use Illuminate\Support\Facades\Cache;

class PullRequestController extends GithubIssueController
{
    public function show(string $vendor, string $name, int $id)
    {
        return inertia(
            'PullRequest/Show',
            Cache::rememberForever(
                "{$vendor}-{$name}-pull-request-{$id}",
                function () use ($vendor, $name, $id) {
                    $project = Project::fromVendorAndName($vendor, $name)->firstOrFail();
                    return [
                        'project' => new ProjectResource($project),
                        'issue' =>  $project->pullRequest($id),
                        'body' => $this->parseMarkdown($project->pullRequest($id)['body']),
                    ];
                }
            )
        );
    }
}
