<?php

namespace App\Console\Commands;

use App\Notifications\SendOzzieStats;
use App\OrgSlack;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('stats:slack')]
#[Description('Send Ozzie stats to Slack')]
class SendStatsToSlack extends Command
{
    public function handle(): int
    {
        (new OrgSlack)->notify(new SendOzzieStats);

        return 0;
    }
}
