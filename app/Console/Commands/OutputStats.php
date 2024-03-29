<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;

class OutputStats extends Command
{
    protected $signature = 'stats:output';

    protected $description = 'Output project stats to the console';

    public function handle(): int
    {
        $this->info("\n");

        $this->table(
            ['Project', 'Debt Score'],
            Project::all()->sortByDesc(function ($project) {
                return $project->debtScore();
            })->map(function ($project) {
                return [
                    sprintf('%s/%s', $project->namespace, $project->name),
                    $this->formatDebtScore($project->debtScore()),
                ];
            })
        );

        $this->info("\n");

        return 0;
    }

    protected function formatDebtScore(float $debtScore): string
    {
        if ($debtScore > 5) {
            return sprintf('<error>%s</error>', $debtScore);
        }
        if ($debtScore > 1) {
            return sprintf('<comment>%s</comment>', $debtScore);
        }

        return $debtScore;
    }
}
