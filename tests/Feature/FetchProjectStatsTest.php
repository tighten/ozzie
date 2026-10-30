<?php

namespace Tests\Feature;

use App\Console\Commands\FetchProjectStats;
use App\Enums\PackageRegistry;
use App\Models\Project;
use Facades\Github\Client as GitHubClient;
use Github\Api\Issue;
use Github\Api\PullRequest;
use Github\Api\Repo;
use Github\Exception\ApiLimitExceedException;
use Github\Exception\RuntimeException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FetchProjectStatsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
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

        $this->artisan(FetchProjectStats::class)->assertSuccessful();
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
                'head_ref' => 'add-readme',
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

    #[Test]
    public function failed_stats_fetch_does_not_overwrite_packagist_stats(): void
    {
        Http::preventStrayRequests();

        Http::fake([
            'packagist.org/packages/tighten/404_package.json' => Http::response([], 404),
            'packagist.org/search.json*' => Http::response(['results' => []]),
            'registry.npmjs.org/*' => Http::response([], 404),
        ]);

        $this->mockGithubClient('tighten', '404_package');

        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => '404_package',
            'packagist_name' => 'tighten/404_package',
            'downloads_total' => 100,
            'downloads_last_30_days' => 10,
        ]);

        $this->artisan(FetchProjectStats::class)->assertSuccessful();

        $project->refresh();

        $this->assertEquals($project->downloads_total, 100);
        $this->assertEquals($project->downloads_last_30_days, 10);

        // The Packagist name we had is gone, so we stop asking Packagist for it
        $this->assertEquals(PackageRegistry::None, $project->package_registry);
        $this->assertNull($project->packagist_name);

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
                'head_ref' => 'add-readme',
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

    #[Test]
    public function npm_project_downloads_are_fetched_from_npm(): void
    {
        Http::preventStrayRequests();

        Http::fake([
            'api.npmjs.org/downloads/point/last-month/ziggy-js' => Http::response(['downloads' => 100]),
            'api.npmjs.org/downloads/point/*' => Http::response(['downloads' => 1000]),
        ]);

        $this->mockGithubClient('tighten', 'ziggy');

        $project = Project::factory()->npmPackage()->create([
            'namespace' => 'tighten',
            'name' => 'ziggy',
            'npm_name' => 'ziggy-js',
        ]);

        $this->artisan(FetchProjectStats::class)->assertSuccessful();

        $project->refresh();

        $this->assertEquals(1000, $project->downloads_total);
        $this->assertEquals(100, $project->downloads_last_30_days);
        $this->assertEquals(PackageRegistry::Npm, $project->package_registry);
    }

    #[Test]
    public function projects_on_no_registry_are_not_looked_up_at_all(): void
    {
        // Any request to a package registry here would be a stray request
        Http::preventStrayRequests();

        $this->mockGithubClient('tighten', 'not_a_package');

        $project = Project::factory()->notAPackage()->create([
            'namespace' => 'tighten',
            'name' => 'not_a_package',
        ]);

        $this->artisan(FetchProjectStats::class)->assertSuccessful();

        $this->assertEquals(PackageRegistry::None, $project->refresh()->package_registry);
    }

    #[Test]
    public function a_registry_with_no_package_name_is_skipped_rather_than_fetched(): void
    {
        // Building a request from a missing package name would be a stray request
        Http::preventStrayRequests();

        $this->mockGithubClient('tighten', 'jigsaw');

        Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'jigsaw',
            'packagist_name' => null,
        ]);

        $this->artisan(FetchProjectStats::class)
            ->expectsOutputToContain('Skipping downloads for jigsaw')
            ->assertSuccessful();
    }

    #[Test]
    public function an_undetected_registry_is_detected_before_downloads_are_fetched(): void
    {
        Http::preventStrayRequests();

        Http::fake([
            'packagist.org/search.json*' => Http::response(['results' => [
                [
                    'name' => 'tightenco/jigsaw',
                    'repository' => 'https://github.com/tighten/jigsaw',
                ],
            ]]),
            'packagist.org/packages/tightenco/jigsaw.json' => Http::response([
                'package' => [
                    'downloads' => [
                        'total' => 1000,
                        'monthly' => 100,
                    ],
                ],
            ]),
        ]);

        $this->mockGithubClient('tighten', 'jigsaw');

        $project = Project::factory()->undetectedRegistry()->create([
            'namespace' => 'tighten',
            'name' => 'jigsaw',
        ]);

        $this->artisan(FetchProjectStats::class)->assertSuccessful();

        $project->refresh();

        $this->assertEquals(PackageRegistry::Packagist, $project->package_registry);
        $this->assertEquals('tightenco/jigsaw', $project->packagist_name);
        $this->assertEquals(1000, $project->downloads_total);
        $this->assertEquals(100, $project->downloads_last_30_days);
    }

    #[Test]
    public function an_unreachable_registry_leaves_the_project_undetected(): void
    {
        Http::preventStrayRequests();

        Http::fake([
            'packagist.org/search.json*' => Http::response([], 503),
        ]);

        $this->mockGithubClient('tighten', 'jigsaw');

        $project = Project::factory()->undetectedRegistry()->create([
            'namespace' => 'tighten',
            'name' => 'jigsaw',
        ]);

        $this->artisan(FetchProjectStats::class)
            ->expectsOutputToContain('Could not determine which package registry jigsaw belongs to.')
            ->assertSuccessful();

        $this->assertEquals(PackageRegistry::Unknown, $project->refresh()->package_registry);
    }

    #[Test]
    public function deleted_github_repo_is_marked_as_hidden(): void
    {
        $reposMock = Mockery::mock(Repo::class);
        $reposMock->shouldReceive('show')
            ->with('tighten', 'deleted_package')
            ->once()
            ->andThrow(new RuntimeException('Not Found', 404));
        GitHubClient::shouldReceive('repo')
            ->once()
            ->andReturn($reposMock);

        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'deleted_package',
        ]);

        $this->artisan(FetchProjectStats::class)
            ->expectsOutputToContain('Hiding deleted_package: repo not found on GitHub.')
            ->assertSuccessful();

        $project->refresh();

        $this->assertTrue($project->is_hidden);
    }

    #[Test]
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

        $this->artisan(FetchProjectStats::class)
            ->expectsOutputToContain('Hiding archived_package: repo is archived on GitHub.')
            ->assertSuccessful();

        $project->refresh();

        $this->assertTrue($project->is_hidden);
    }

    #[Test]
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

        $this->artisan(FetchProjectStats::class)
            ->expectsOutputToContain('Skipping rate_limited_package')
            ->assertSuccessful();

        $project->refresh();

        $this->assertFalse($project->is_hidden);
    }

    #[Test]
    public function hidden_projects_are_skipped(): void
    {
        $project = Project::factory()->hidden()->create();

        // No GitHub mocks set up — if the command tries to call GitHub, it will fail
        $this->artisan(FetchProjectStats::class)->assertSuccessful();
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
                    'head' => ['ref' => 'add-readme'],
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
