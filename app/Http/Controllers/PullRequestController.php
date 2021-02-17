<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;
use Illuminate\Support\Facades\Cache;

class PullRequestController extends GithubIssueController
{
    public function show(string $namespace, string $name, int $id)
    {
        return inertia(
            'PullRequest/Show',
            Cache::rememberForever(
                "{$namespace}-{$name}-pull-request-{$id}",
                function () use ($namespace, $name, $id) {
                    $project = Project::fromNamespaceAndName($namespace, $name)->firstOrFail();
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
