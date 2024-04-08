<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Notifications\SendOzzieStats;
use App\OrgSlack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use function Symfony\Component\String\s;

class SendStatsToSlackTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sends_latest_stats_to_slack(): void
    {
        Notification::fake();

        Project::factory()->create([
            'namespace' => 'acme',
            'name' => 'project-a',
            'issues_count' => 500
        ]);

        Project::factory()->create([
            'namespace' => 'acme',
            'name' => 'project-b',
            'issues_count' => 700
        ]);

        $this->artisan('stats:slack')
            ->assertExitCode(0);

        Notification::assertSentTo(new OrgSlack(), SendOzzieStats::class, function ($notification, $channels, $notifiable) {
            $slackNotification = $notification->toSlack($notifiable);

            return $channels === ['slack']
                && $notifiable instanceof OrgSlack
                && $slackNotification->username === 'Ozzie'
                && $slackNotification->icon === ':robot_face:'
                && $slackNotification->content === sprintf('Here are your Ozzie stats! %s', config('app.url'))
                && $slackNotification->attachments[0]->blocks[0]->text['text'] === '*<https://github.com/acme/project-b|Acme / Project-b>*: *7*'
                && $slackNotification->attachments[1]->blocks[0]->text['text'] === '*<https://github.com/acme/project-a|Acme / Project-a>*: *5*'
                && $slackNotification->attachments[0]->blocks[1]->elements[1]['text'] === "PRs: 0 (*0 old*)\t\t\tIssues: 700 (*0 old*)"
                && $slackNotification->attachments[1]->blocks[1]->elements[1]['text'] === "PRs: 0 (*0 old*)\t\t\tIssues: 500 (*0 old*)";
        });
    }
}
