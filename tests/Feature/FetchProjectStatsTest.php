<?php

namespace Tests\Feature;

use App\Models\Project;
use Github\Api\Issue;
use Github\Api\PullRequest;
use Github\Api\Repo;
use Github\Exception\ApiLimitExceedException;
use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class FetchProjectStatsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function fetch_stats_and_persist_successfully(): void
    {
        Http::preventStrayRequests();

        Http::fake([
            'packagist.org/packages/tighten/existing_package.json' => Http::response([
                'package' => [
                    'downloads' => [
                        'total' => 1000,
                        'monthly' => 100,
                    ],
                ],
            ]),
        ]);

        $this->mockGithubClient('tighten', 'existing_package');

        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'existing_package',
            'packagist_name' => 'tighten/existing_package',
        ]);

        $this->artisan('stats:fetch')->assertSuccessful();
        $project->refresh();

        $this->assertEquals($project->downloads_total, 1000);
        $this->assertEquals($project->downloads_last_30_days, 100);

        $this->assertEquals($project->issues_count, 1);
        $this->assertEquals($project->pull_requests_count, 1);
        $this->assertEquals($project->issues, collect([
            [
                'labels' => [['name' => 'help wanted']],
                'created_at' => '2021-01-01T00:00:00.000000Z',
                'html_url' => 'https://example.com/issue/2',
                'pull_request' => null,
                'title' => 'Readme is unclear',
                'number' => '1234',
                'body' => 'Something in the readme is unclear and needs to be updated.',
                'user' => 'appleseed',
            ],
        ]));
        $this->assertEquals($project->pull_requests, collect([
            [
                'body' => 'This PR adds a readme to the project',
                'created_at' => '2021-01-01T00:00:00.000000Z',
                'draft' => false,
                'html_url' => 'https://example.com/pr/1',
                'node_id' => 12345,
                'number' => 1,
                'title' => 'Add Readme',
                'labels' => [],
                'user' => 'johncash',
            ],
        ]));

        $this->assertEquals($project->is_hidden, false);
        $this->assertNotEmpty(Cache::get('projects'));
    }

    /** @test */
    public function failed_stats_fetch_does_not_overwrite_packagist_stats(): void
    {
        Http::preventStrayRequests();

        Http::fake([
            'packagist.org/packages/tighten/404_package.json' => Http::response([], 404),
        ]);

        $this->mockGithubClient('tighten', '404_package');

        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => '404_package',
            'packagist_name' => 'tighten/404_package',
            'downloads_total' => 100,
            'downloads_last_30_days' => 10,
        ]);

        $this->artisan('stats:fetch')->assertSuccessful();

        $project->refresh();

        $this->assertEquals($project->downloads_total, 100);
        $this->assertEquals($project->downloads_last_30_days, 10);

        $this->assertEquals($project->issues_count, 1);
        $this->assertEquals($project->pull_requests_count, 1);
        $this->assertEquals($project->issues, collect([
            [
                'labels' => [['name' => 'help wanted']],
                'created_at' => '2021-01-01T00:00:00.000000Z',
                'html_url' => 'https://example.com/issue/2',
                'pull_request' => null,
                'title' => 'Readme is unclear',
                'number' => '1234',
                'body' => 'Something in the readme is unclear and needs to be updated.',
                'user' => 'appleseed',
            ],
        ]));
        $this->assertEquals($project->pull_requests, collect([
            [
                'body' => 'This PR adds a readme to the project',
                'created_at' => '2021-01-01T00:00:00.000000Z',
                'draft' => false,
                'html_url' => 'https://example.com/pr/1',
                'node_id' => 12345,
                'number' => 1,
                'title' => 'Add Readme',
                'labels' => [],
                'user' => 'johncash',
            ],
        ]));

        $this->assertEquals($project->is_hidden, false);
        $this->assertNotEmpty(Cache::get('projects'));
    }

    /** @test */
    public function deleted_github_repo_is_marked_as_hidden(): void
    {
        $reposMock = Mockery::mock(Repo::class);
        $reposMock->shouldReceive('show')
            ->with('tighten', 'deleted_package')
            ->once()
            ->andThrow(new \Github\Exception\RuntimeException('Not Found', 404));
        GitHubClient::shouldReceive('repo')
            ->once()
            ->andReturn($reposMock);

        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'deleted_package',
        ]);

        $this->artisan('stats:fetch')
            ->expectsOutputToContain('Hiding deleted_package: repo not found on GitHub.')
            ->assertSuccessful();

        $project->refresh();

        $this->assertTrue($project->is_hidden);
    }

    /** @test */
    public function archived_github_repo_is_marked_as_hidden(): void
    {
        $reposMock = Mockery::mock(Repo::class);
        $reposMock->shouldReceive('show')
            ->with('tighten', 'archived_package')
            ->once()
            ->andReturn(['archived' => true]);
        GitHubClient::shouldReceive('repo')
            ->once()
            ->andReturn($reposMock);

        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'archived_package',
        ]);

        $this->artisan('stats:fetch')
            ->expectsOutputToContain('Hiding archived_package: repo is archived on GitHub.')
            ->assertSuccessful();

        $project->refresh();

        $this->assertTrue($project->is_hidden);
    }

    /** @test */
    public function rate_limited_repo_is_not_hidden(): void
    {
        $reposMock = Mockery::mock(Repo::class);
        $reposMock->shouldReceive('show')
            ->with('tighten', 'rate_limited_package')
            ->once()
            ->andThrow(new ApiLimitExceedException);
        GitHubClient::shouldReceive('repo')
            ->once()
            ->andReturn($reposMock);

        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'rate_limited_package',
        ]);

        $this->artisan('stats:fetch')
            ->expectsOutputToContain('Skipping rate_limited_package')
            ->assertSuccessful();

        $project->refresh();

        $this->assertFalse($project->is_hidden);
    }

    /** @test */
    public function hidden_projects_are_skipped(): void
    {
        $project = Project::factory()->hidden()->create();

        // No GitHub mocks set up — if the command tries to call GitHub, it will fail
        $this->artisan('stats:fetch')->assertSuccessful();
    }

    public function mockGithubClient($namespace, $repo): void
    {
        $issuesMock = Mockery::mock(Issue::class);
        $issuesMock->shouldReceive('all')
            ->with($namespace, $repo)
            ->once()
            ->andReturn([
                // Include an issue that's in progress to test that it's filtered out
                [
                    'labels' => [['name' => 'in progress']],
                    'created_at' => '2021-01-01T00:00:00.000000Z',
                ],
                // Include an issue that has a PR associated with it to test that it's filtered out
                [
                    'labels' => [['name' => 'good first issue']],
                    'created_at' => '2021-01-01T00:00:00.000000Z',
                    'html_url' => 'https://example.com/issue/1',
                    'pull_request' => 'https://example.com/pr/1',
                    'title' => 'Need to add a readme',
                    'number' => '1234',
                    'body' => 'This repo does not have a readme',
                    'user' => 'johnsmith',
                ],
                [
                    'labels' => [['name' => 'help wanted']],
                    'created_at' => '2021-01-01T00:00:00.000000Z',
                    'html_url' => 'https://example.com/issue/2',
                    'pull_request' => null,
                    'title' => 'Readme is unclear',
                    'number' => '1234',
                    'body' => 'Something in the readme is unclear and needs to be updated.',
                    'user' => 'appleseed',
                ],
            ]);
        GitHubClient::shouldReceive('issues')
            ->once()
            ->andReturn($issuesMock);

        $pullRequestsMock = Mockery::mock(PullRequest::class);
        $pullRequestsMock->shouldReceive('all')
            ->with($namespace, $repo)
            ->once()
            ->andReturn([
                // Include a draft PR to test that it's filtered out
                [
                    'draft' => true,
                    'created_at' => '2021-01-01T00:00:00.000000Z',
                ],
                // Include a PR that's in progress to test that it's filtered out
                [
                    'labels' => [['name' => 'in progress']],
                    'created_at' => '2021-01-01T00:00:00.000000Z',
                ],
                // Include an open PR to test that it's included
                [
                    'body' => 'This PR adds a readme to the project',
                    'created_at' => '2021-01-01T00:00:00.000000Z',
                    'draft' => false,
                    'html_url' => 'https://example.com/pr/1',
                    'node_id' => 12345,
                    'number' => 1,
                    'title' => 'Add Readme',
                    'labels' => [],
                    'user' => 'johncash',
                ],
            ]);
        GitHubClient::shouldReceive('pullRequests')
            ->once()
            ->andReturn($pullRequestsMock);

        $reposMock = Mockery::mock(Repo::class);
        $reposMock->shouldReceive('show')
            ->with($namespace, $repo)
            ->once()
            ->andReturn(['archived' => false]);
        GitHubClient::shouldReceive('repo')
            ->once()
            ->andReturn($reposMock);
    }
}
