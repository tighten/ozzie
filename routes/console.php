<?php

use App\Console\Commands\CreateProjectSnapshots;
use App\Console\Commands\FetchGitHubProjects;
use App\Console\Commands\FetchProjectStats;
use App\Console\Commands\SendStatsToSlack;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->describe('Display an inspiring quote');

Schedule::command(FetchGitHubProjects::class)
    ->daily();

Schedule::command(CreateProjectSnapshots::class)
    ->daily();

Schedule::command(FetchProjectStats::class)
    ->hourly();

Schedule::command(SendStatsToSlack::class)
    ->weekly()
    ->fridays()
    ->at('06:00');
