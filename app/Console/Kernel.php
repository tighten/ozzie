<?php

namespace App\Console;

use App\Console\Commands\CreateProjectSnapshots;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // CreateProjectSnapshots::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('projects:fetch')
            ->daily();

        $schedule->command('stats:snapshot')
            ->daily();

        $schedule->command('stats:fetch')
            ->hourly();

        $schedule->command('stats:slack')
            ->weekly()
            ->fridays()
            ->at('06:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
