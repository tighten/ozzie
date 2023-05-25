<?php

namespace App\Console\Commands;

use App\Notifications\SendOzzieStats;
use App\OrgSlack;
use Illuminate\Console\Command;

class SendStatsToSlack extends Command
{
    protected $signature = 'stats:slack';

    protected $description = 'Send Ozzie stats to Slack';

    public function handle(): void
    {
        (new OrgSlack)->notify(new SendOzzieStats);
    }
}
