<?php

namespace App\Console\Commands;

use App\Projects;
use Illuminate\Console\Command;

class OutputStats extends Command
{
    protected $signature = 'stats:output';

    protected $description = 'Output project stats to the console';

    public function handle(Projects $projects)
    {
        $this->info("\n\n");

        $this->table(
            ['Project', 'Debt Score'],
            $projects->all()->sortByDesc(function ($project) {
                return $project->debtScore();
            })->map(function ($project) {
                return [
                    $project->name,
                    $this->formatDebtScore($project->debtScore()),
                ];
            })
        );
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
