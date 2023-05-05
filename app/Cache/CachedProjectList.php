<?php

namespace App\Cache;

use App\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class CachedProjectList
{
    public function __invoke()
    {
        return Cache::rememberForever(
            'projects',
            function () {
                return [
                    'projects' => Project::visible()->get()
                        ->transform(fn ($project) => app(CachedProjectResource::class)($project->packagist_name))
                        ->sortByDesc(fn ($project) => $project['debt_score'])
                        ->values(),
                    'hacktoberfest' => Carbon::now()->isSameMonth(Carbon::parse('October')),
                    'organization' => config('app.organization'),
                ];
            }
        );
    }
}
