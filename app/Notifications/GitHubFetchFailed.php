<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Slack\SlackMessage;

class GitHubFetchFailed extends Notification
{
    public function __construct(
        protected string $repo,
        protected string $endpoint,
        protected int $code,
        protected string $exceptionClass,
    ) {}

    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->username('Ozzie')
            ->emoji(':warning:')
            ->text("GitHub API error fetching {$this->endpoint} for {$this->repo} (HTTP {$this->code})")
            ->sectionBlock(function (SectionBlock $block) {
                $block
                    ->text(sprintf(
                        ":warning: *GitHub API error*\n*Repo:* %s\n*Endpoint:* %s\n*HTTP Code:* %s\n*Exception:* %s",
                        $this->repo,
                        $this->endpoint,
                        $this->code,
                        $this->exceptionClass,
                    ))
                    ->markdown();
            });
    }
}
