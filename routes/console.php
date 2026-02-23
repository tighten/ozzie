<?php

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


Schedule::command('projects:fetch')
    ->daily();

Schedule::command('stats:snapshot')
    ->daily();

Schedule::command('stats:fetch')
    ->hourly();

Schedule::command('stats:slack')
    ->weekly()
    ->fridays()
    ->at('06:00');
