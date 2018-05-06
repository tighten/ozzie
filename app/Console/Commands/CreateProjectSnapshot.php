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
    protected $description = 'Create a snapshot of the current status of GitHub projects.';

    public function handle()
    {
        $this->fetchProjects()->each(function ($repository) {
            $project = new Project($repository->namespace, $repository->name, $repository->maintainers);

            DB::table('projects')->insert([
                'name' => $project->name,
                'debt_score' => $project->debtScore(),
                'issue_count' => $project->issues()->count(),
                'old_issue_count' => $project->oldIssues()->count(),
                'pull_request_count' => $project->prs()->count(),
                'old_pull_request_count' => $project->oldPrs()->count(),
            ]);
        });
    }

    protected function fetchProjects()
    {
        $projects = collect(json_decode(file_get_contents(base_path('projects.json'))))->sortBy('name');

        $snapshots = DB::table('projects')
                        ->whereIn('name', $projects->pluck('name'))
                        ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))
                        ->get();

        return $projects->filter(function ($repository) use ($snapshots) {
            return $snapshots->where('name', $repository->name)->isEmpty();
        });
    }
}
