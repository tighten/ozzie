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

    public function handle()
    {
        $this->fetchProjects()->each(function ($repository) {
            $project_snapshot = new Project($repository->namespace, $repository->name, $repository->maintainers);

            DB::table('projects')->insert([
                'name' => $project_snapshot->name,
                'debt_score' => $project_snapshot->debtScore(),
                'issues' => $project_snapshot->issues()->count(),
                'old_issues' => $project_snapshot->oldIssues()->count(),
                'pull_requests' => $project_snapshot->prs()->count(),
                'old_pull_requests' => $project_snapshot->oldPrs()->count(),
            ]);
        });
    }

    /**
     * Fetch Github projects from projects.json
     *
     * @return Collection
     */
    protected function fetchProjects(): Collection
    {
        $repositories = collect(json_decode(file_get_contents(base_path('projects.json'))))->sortBy('name');

        $snapshots = DB::table('projects')
                        ->whereIn('name', $repositories->pluck('name'))
                        ->whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))
                        ->get();

        return $repositories->filter(function ($repository) use ($snapshots) {
            return $snapshots->where('name', $repository->name)->isEmpty();
        });
    }
}
