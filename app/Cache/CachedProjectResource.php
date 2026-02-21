<?php

namespace App\Cache;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class CachedProjectResource
{
    public function __invoke(string $namespace, string $name)
    {
        return Cache::rememberForever(
            "{$namespace}-{$name}",
            function () use ($namespace, $name) {
                return (new ProjectResource(Project::fromVendorAndName($namespace, $name)->firstOrFail()))->jsonSerialize();
            }
        );
    }
}
