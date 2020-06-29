<?php

namespace App\Notifications;

use App\Projects;
use Illuminate\Notifications\Notification;
use NathanHeffley\LaravelSlackBlocks\Messages\SlackMessage;

class SendOzzieStats extends Notification
{
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $message = (new SlackMessage)
            ->from('Ozzie', ':robot_face:')
            // Provide a text-only fallback message
            ->content(sprintf('Here are your Ozzie stats! %s', config('app.url')))
            ->block(function ($block) {
                $block
                    ->type('section')
                    ->text([
                        'type' => 'mrkdwn',
                        'text' => 'Here are your Ozzie stats!',
                    ])
                    ->accessory([
                        'type' => 'button',
                        'url' => config('app.url'),
                        'text' => [
                            'type' => 'plain_text',
                            'text' => 'Open Ozzie',
                            'emoji' => true,
                        ],
                    ]);
            });

        app(Projects::class)->all()->sortByDesc(function ($project) {
            return $project->debtScore();
        })->each(function ($project) use ($message) {
            $message->attachment(function ($attachment) use ($project) {
                $scoreMoji = $project->debtScore() < 1 ? ':white_check_mark: ' : ':warning: ';
                $hexColor = $project->debtScore() < 1 ? '#44AB31' : '#F9C336';
                $attachment
                    ->color($hexColor)
                    ->block(function ($block) use ($project) {
                        $block
                            ->type('section')
                            ->text([
                                'type' => 'mrkdwn',
                                'text' => sprintf(
                                    '*<%s|%s>*: *%s*',
                                    $project->url(),
                                    ucwords($project->name),
                                    $project->debtScore()
                                ),
                            ]);
                    })
                    ->block(function ($block) use ($project, $scoreMoji) {
                        $block
                            ->type('context')
                            ->elements([
                                [
                                    'type' => 'plain_text',
                                    'emoji' => true,
                                    'text' => $scoreMoji,
                                ],
                                [
                                    'type' => 'mrkdwn',
                                    'text' => sprintf(
                                        "PRs: %s (*%s old*)\t\t\tIssues: %s (*%s old*)",
                                        $project->prs()->count(),
                                        $project->oldPrs()->count(),
                                        $project->issues()->count(),
                                        $project->oldIssues()->count()
                                    ),
                                ],
                            ]);
                    })
                    ->dividerBlock();
            });
        });

        return $message;
    }
}
