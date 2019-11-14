<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class TightenSlack
{
    use Notifiable;

    public function routeNotificationForSlack()
    {
        return config('services.slack.webhook_url');
    }
}
