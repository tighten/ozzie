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

        $projects->all()->sortByDesc(function ($project) {
            return $project->debtScore();
        })->each(function ($project) {
            $this->info($project->name);
            $this->comment("-----------------------");
            $this->info('Debt score: ' . $project->debtScore() . "\n\n");
        });
    }
}
