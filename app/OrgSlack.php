<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class OrgSlack
{
    use Notifiable;

    public function routeNotificationForSlack()
    {
        return config('services.slack.webhook_url');
    }
}
