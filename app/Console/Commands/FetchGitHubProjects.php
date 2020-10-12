<?php

namespace App\Console\Commands;

use App\Projects;
use Illuminate\Console\Command;

class FetchGitHubProjects extends Command
{
    protected $signature = 'projects:fetch';

    protected $description = 'Fetches the organization\'s GitHub repositories.';

    public function handle()
    {
        $projects = app('mygithub')
            ->repositories(config('app.organization'))
            ->where('archived', false)
            ->map(function ($repo) {
                return [
                    'namespace' => $repo->namespace,
                    'name' => $repo->name,
                    'maintainers' => []
                ];
            });

        (new Projects)->write($projects);
    }
}
