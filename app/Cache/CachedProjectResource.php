<?php

namespace App\Cache;

use App\Http\Resources\ProjectResource;
use App\Project;
use Illuminate\Support\Facades\Cache;

class CachedProjectResource
{
    public function __invoke(string $packagistName)
    {
        [$vendor, $name] = explode('/', $packagistName);
        return Cache::rememberForever(
            "{$vendor}-{$name}",
            function () use ($packagistName) {
                return new ProjectResource(Project::forPackagist($packagistName)->firstOrFail());
            }
        );
    }
}
