<?php

namespace App\Console\Commands;

use App\Project;
use App\Snapshot;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateProjectSnapshots extends Command
{
    protected $signature = 'stats:snapshot {--f|force : Force an update of any snapshots captured today}';

    protected $description = "Create a snapshot of the current status of all projects' scores.";

    protected $bar;

    public function handle()
    {
        $projects = $this->projectsToSnapshot();

        if ($projects->isEmpty()) {
            $this->line('No projects need snapshots for ' . now()->format('Y-m-d'));

            return 0;
        }

        $this->createProgressBar($projects->count());

        $projects->each(function ($project) {
            $this->updateProgressBar($project->name);

            Snapshot::updateOrCreate(
                [
                    'project_id' => $project->id,
                    'snapshot_date' => now()->format('Y-m-d'),
                ],
                [
                    'name' => $project->name,
                    'debt_score' => $project->debtScore(),
                    'issue_count' => $project->issues->count(),
                    'old_issue_count' => $project->oldIssues()->count(),
                    'pull_request_count' => $project->pull_requests->count(),
                    'old_pull_request_count' => $project->oldPullRequests()->count(),
                ]
            );
        });

        $this->bar->finish();

        return 0;
    }

    protected function projectsToSnapshot()
    {
        if ($this->option('force')) {
            // Require updating for all projects, whether or not they've already had a snapshot captured today
            return Project::all();
        }

        $projects = Project::doesntHave('snapshotToday')->get();

        $completedSnapshots = Snapshot::today()->get()->pluck('name');

        // Only return projects that don't have a snapshot record for today
        return $projects->filter(function ($project) use ($completedSnapshots) {
            return ! $completedSnapshots->contains($project->name);
        });
    }

    protected function createProgressBar($count)
    {
        $this->line("Getting snapshot for {$count} " . Str::plural('project', $count));
        $this->bar = $this->output->createProgressBar($count);
    }

    protected function updateProgressBar($current)
    {
        $this->bar->advance();

        // Display current task context above the progress bar
        $this->bar->clear();
        $this->line("... {$current}");
        $this->bar->display();
    }
}
