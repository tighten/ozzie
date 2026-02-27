<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Notifications\SendOzzieStats;
use App\OrgSlack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Slack\SlackMessage;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

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
            'issues_count' => 500,
        ]);

        Project::factory()->create([
            'namespace' => 'acme',
            'name' => 'project-b',
            'issues_count' => 700,
        ]);

        $this->artisan('stats:slack')
            ->assertExitCode(0);

        Notification::assertSentTo(new OrgSlack, SendOzzieStats::class, function ($notification, $channels, $notifiable) {
            $slackNotification = $notification->toSlack($notifiable);

            $this->assertInstanceOf(SlackMessage::class, $slackNotification);
            $this->assertSame(['slack'], $channels);
            $this->assertInstanceOf(OrgSlack::class, $notifiable);

            $payload = $slackNotification->toArray();

            $this->assertSame('Ozzie', $payload['username']);
            $this->assertSame(':robot_face:', $payload['icon_emoji']);
            $this->assertSame(sprintf('Here are your Ozzie stats! %s', config('app.url')), $payload['text']);

            // First block is the header section with button
            $this->assertSame('section', $payload['blocks'][0]['type']);

            // Second block is section for project-b (higher debt)
            $this->assertSame('section', $payload['blocks'][1]['type']);
            $this->assertStringContainsString('*<https://github.com/acme/project-b|Acme / Project-b>*: *7*', $payload['blocks'][1]['text']['text']);

            // Third block is context for project-b
            $this->assertSame('context', $payload['blocks'][2]['type']);
            $this->assertStringContainsString('PRs: 0 (*0 old*)  Issues: 700 (*0 old*)', $payload['blocks'][2]['elements'][0]['text']);

            // Fourth block is section for project-a (lower debt)
            $this->assertSame('section', $payload['blocks'][3]['type']);
            $this->assertStringContainsString('*<https://github.com/acme/project-a|Acme / Project-a>*: *5*', $payload['blocks'][3]['text']['text']);

            // Fifth block is context for project-a
            $this->assertSame('context', $payload['blocks'][4]['type']);
            $this->assertStringContainsString('PRs: 0 (*0 old*)  Issues: 500 (*0 old*)', $payload['blocks'][4]['elements'][0]['text']);

            return true;
        });
    }
}
