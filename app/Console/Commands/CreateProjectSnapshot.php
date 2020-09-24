<?php

namespace App\Console\Commands;

use App\Project;
use App\Snapshot;
use Illuminate\Console\Command;

class CreateProjectSnapshot extends Command
{
    protected $signature = 'snapshot:today {--f|force : Snapshot all projects, updating any existing data for today}';

    protected $description = 'Create a snapshot of the current status of all GitHub projects.';

    protected $bar;

    public function handle()
    {
        // Get a collection of projects from projects.json that don't have a snapshot for today
        $projects = $this->fetchProjects();

        if ($projects->isEmpty()) {
            $this->line('No projects need snapshots for ' . now()->format('Y-m-d'));

            return 0;
        }

        $this->line("Getting snapshot for {$projects->count()} projects");
        $this->bar = $this->output->createProgressBar($projects->count());

        $projects->each(function ($project) {
            $project = new Project($project->namespace, $project->name, $project->maintainers);

            $this->updateProgress($project->name);

            Snapshot::updateOrCreate(
                [
                    'name' => $project->name,
                    'snapshot_date' => now()->format('Y-m-d'),
                ],
                [
                    'debt_score' => $project->debtScore(),
                    'issue_count' => $project->issues()->count(),
                    'old_issue_count' => $project->oldIssues()->count(),
                    'pull_request_count' => $project->prs()->count(),
                    'old_pull_request_count' => $project->oldPrs()->count(),
                ]
            );
        });

        $this->bar->finish();

        return 0;
    }

    protected function fetchProjects()
    {
        $projects = collect(json_decode(file_get_contents(base_path('projects.json'))));

        if ($this->option('force')) {
            // Return the full list of projects without filtering
            return $projects;
        }

        $completedSnapshots = Snapshot::today()->get()->pluck('name');

        // Only return projects that don't have a snapshot record for today
        return $projects->filter(function ($project) use ($completedSnapshots) {
            return ! $completedSnapshots->contains($project->name);
        });
    }

    protected function updateProgress($current = null)
    {
        $this->bar->advance();

        if ($current) {
            // Display current task context above the progress bar
            $this->bar->clear();
            $this->line("... {$current}");
            $this->bar->display();
        }
    }
}
