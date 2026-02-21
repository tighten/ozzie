<?php

namespace App\Cache;

use App\GitHub\ParseMarkdown;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class CachedIssue
{
    public function __invoke(string $vendor, string $name, string $type, int $id)
    {
        return Cache::rememberForever(
            "{$vendor}-{$name}-{$type}-{$id}",
            function () use ($vendor, $name, $type, $id) {
                $project = new ProjectResource(Project::fromVendorAndName($vendor, $name)->firstOrFail());

                return [
                    'project' => $project->jsonSerialize(),
                    'issue' => $project->$type($id),
                    'body' => app(ParseMarkdown::class)($project->$type($id)['body'] ? $project->$type($id)['body'] : ''),
                ];
            }
        );
    }
}
