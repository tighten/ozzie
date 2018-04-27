<?php

namespace App\Console\Commands;

use App\Project;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateProjectSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a snapshot of the current status of Github projects.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projects = $this->fetchProjects();

        $projects->each(function ($repository) {
            $project = new Project($repository->namespace, $repository->name, $repository->maintainers);

            DB::table('projects')->insert([
                'name' => $project->name,
                'debt_score' => $project->debtScore(),
                'issues' => $project->issues()->count(),
                'old_issues' => $project->oldIssues()->count(),
                'pull_requests' => $project->prs()->count(),
                'old_pull_requests' => $project->oldPrs()->count(),
            ]);
        });
    }

    /**
     * Fetch github projects
     * from projects.json
     * @return Collection
     */
    protected function fetchProjects(): Collection
    {
        $repositories = collect(json_decode(file_get_contents(base_path('projects.json'))))->sortBy('name');

        return $repositories->filter(function ($repository) {
            return !DB::table('projects')
                        ->where('name', $repository->name)
                        ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))
                        ->exists();
        });
    }
}
