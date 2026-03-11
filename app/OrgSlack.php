<?php

namespace App;

use Illuminate\Notifications\Notifiable;

class OrgSlack
{
    use Notifiable;

    public function __construct(protected ?string $webhookUrl = null) {}

    public function routeNotificationForSlack()
    {
        return $this->webhookUrl ?: config('services.slack.webhook_url');
    }

    public function getKey()
    {
        return 'org-slack-key';
    }
}
