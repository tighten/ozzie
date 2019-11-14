<?php

namespace App\Notifications;

use App\Projects;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class SendOzzieStats extends Notification
{
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $message = (new SlackMessage)
            ->from('Ozzie', ':robot:')
            ->content("Here are your Ozzie Stats!\nhttps://ozzie.tighten.co/");

        app(Projects::class)->all()->sortByDesc(function ($project) {
            return $project->debtScore();
        })->each(function ($project) use ($message) {
            $message->attachment(function ($attachment) use ($project) {
                $scoreMoji = $project->debtScore() < 1 ? ':white_check_mark: ' : ':warning: ';
                $attachment->title(ucwords($project->name), $project->url())
                    ->fields([
                        'Debt Score' => $scoreMoji . $project->debtScore(),
                        'PRs' => sprintf("%s (%s old)", $project->prs()->count(), $project->oldPrs()->count()),
                        'Issues' => sprintf("%s (%s old)", $project->issues()->count(), $project->oldIssues()->count()),
                    ]);
            });
        });

        return $message;
    }
}
