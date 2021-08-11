<?php

namespace App\Cache;

use App\GitHub\ParseMarkdown;
use Illuminate\Support\Facades\Cache;

class CachedIssue
{
    public function __invoke(string $vendor, string $name, string $type, int $id)
    {
        return Cache::rememberForever(
            "{$vendor}-{$name}-{$type}-{$id}",
            function () use ($vendor, $name, $type, $id) {
                $project = app(CachedProjectResource::class)("{$vendor}/{$name}");

                return [
                    'project' => $project,
                    'issue' => $project->$type($id),
                    'body' => app(ParseMarkdown::class)($project->$type($id)['body']),
                ];
            }
        );
    }
}
