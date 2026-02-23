<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Slack\BlockKit\Elements\ButtonElement;
use Illuminate\Notifications\Slack\SlackMessage;

class SendOzzieStats extends Notification
{
    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack($notifiable): SlackMessage
    {
        $message = (new SlackMessage)
            ->username('Ozzie')
            ->emoji(':robot_face:')
            ->text(sprintf('Here are your Ozzie stats! %s', config('app.url')))
            ->sectionBlock(function (SectionBlock $block) {
                $block
                    ->text('Here are your Ozzie stats!')
                    ->markdown();
                $block->accessory(
                    (new ButtonElement('Open Ozzie'))->url(config('app.url'))
                );
            });

        Project::visible()->get()
            ->filter(fn ($project) => $project->debtScore() > 0)
            ->sortByDesc(function ($project) {
                return $project->debtScore();
            })
            ->each(function ($project) use ($message) {
                $scoreMoji = $project->debtScore() < 1 ? ':white_check_mark: ' : ':warning: ';

                $message->sectionBlock(function (SectionBlock $block) use ($project) {
                    $block
                        ->text(sprintf(
                            '*<%s|%s / %s>*: *%s*',
                            $project->url(),
                            ucwords($project->namespace),
                            ucwords($project->name),
                            $project->debtScore()
                        ))
                        ->markdown();
                });

                $message->contextBlock(function ($block) use ($project, $scoreMoji) {
                    $block->text($scoreMoji);
                    $block->text(sprintf(
                        "PRs: %s (*%s old*)\t\t\tIssues: %s (*%s old*)",
                        $project->pull_requests_count,
                        $project->oldPullRequests()->count(),
                        $project->issues_count,
                        $project->oldIssues()->count()
                    ))->markdown();
                });

                $message->dividerBlock();
            });

        return $message;
    }
}
