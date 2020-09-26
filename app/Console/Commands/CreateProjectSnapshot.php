<?php

namespace App\Console\Commands;

use App\Project;
use App\Projects;
use App\Snapshot;
use App\SnapshotProject;
use Illuminate\Console\Command;

class CreateProjectSnapshot extends Command
{
    protected $signature = 'snapshot:today {--f|force : Snapshot all projects, updating any existing data for today}';

    protected $description = 'Create a snapshot of the current status of all GitHub projects.';

    protected $bar;

    public function handle()
    {
        // Get a collection of projects from projects.json that don't have a snapshot for today
        $projects = $this->getProjectsToSnapshot();

        if ($projects->isEmpty()) {
            $this->line('No projects need snapshots for ' . now()->format('Y-m-d'));

            return 0;
        }

        $this->line("Getting snapshot for {$projects->count()} projects");
        $this->bar = $this->output->createProgressBar($projects->count());

        $projects->each(function ($project) {
            $project = new Project($project->namespace, $project->name, $project->maintainers);

            $this->updateProgress($project);

            $snapshotProject = SnapshotProject::firstOrCreate(
                ['namespace' => $project->namespace, 'name' => $project->name]
            );

            Snapshot::updateOrCreate(
                [
                    'project_id' => $snapshotProject->id,
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

    protected function getProjectsToSnapshot()
    {
        $projects = (new Projects)->all();

        if ($this->option('force')) {
            // Return the full list of projects without filtering
            return $projects;
        }

        $completedSnapshots = Snapshot::with('project')->today()->get()->map(function ($snapshot) {
            return sprintf('%s/%s', $snapshot->project->namespace, $snapshot->project->name);
        });

        // Only return projects that don't have a snapshot record for today
        return $projects->filter(function ($project) use ($completedSnapshots) {
            return ! $completedSnapshots->contains(
                sprintf('%s/%s', $project->namespace, $project->name)
            );
        });
    }

    protected function updateProgress($current = null)
    {
        $this->bar->advance();

        if ($current) {
            // Display current task context above the progress bar
            $this->bar->clear();
            $this->line("... {$current->namespace}/{$current->name}");
            $this->bar->display();
        }
    }
}
