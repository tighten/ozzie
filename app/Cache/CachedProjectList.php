<?php

namespace App\Cache;

use App\Models\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class CachedProjectList
{
    public function __invoke()
    {
        return [
            'projects' => $this->getProjects(),
            'hacktoberfest' => Carbon::now()->isSameMonth(Carbon::parse('October')),
            'organization' => config('app.organization'),
            'user' => auth()->user(),
        ];
    }

    public function getProjects()
    {
        return Cache::remember(
            'projects',
            now()->addMinutes(5),
            function () {
                return Project::exclude(['pull_requests', 'issues'])->get()
                    ->filter(fn ($project) => ! $project->is_hidden)
                    ->transform(fn ($project) => app(CachedProjectResource::class)($project->packagist_name))
                    ->sortByDesc(fn ($project) => $project['debt_score'])
                    ->values();

                return Project::all()
                    ->sortByDesc(fn ($project) => $project['debt_score'])
                    ->values();
            }
        );
    }
}
