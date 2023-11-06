<?php

namespace Tests\Feature;

use App\Cache\CachedProjectList;
use App\Models\Maintainer;
use App\Models\Project;
use Github\Api\Issue;
use Github\Api\PullRequest;
use Github\Api\Repo;
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
            'packagist.org/packages/tighten/bar.json' => Http::response([
                'package' => [
                    'downloads' => [
                        'total' => 1000,
                        'monthly' => 100,
                    ],
                ],
            ]),
        ]);

        $issueMock = Mockery::mock(Issue::class);
        $issueMock->shouldReceive('all')
            ->with('tighten', 'bar')
            ->once()
            ->andReturn([]);

        $moc = Mockery::mock(PullRequest::class);
        $moc->shouldReceive('all')
            ->with('tighten', 'bar')
            ->once()
            ->andReturn([]);

        $repoMock = Mockery::mock(Repo::class);
        $repoMock->shouldReceive('show')
            ->with('tighten', 'bar')
            ->once()
            ->andReturn(['archived' => false]);

        GitHubClient::shouldReceive('issues')
            ->once()
            ->andReturn($issueMock);
        GitHubClient::shouldReceive('pullRequests')
            ->once()
            ->andReturn($moc);

        GitHubClient::shouldReceive('repo')
            ->once()
            ->andReturn($repoMock);

        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'bar',
            'packagist_name' => null,
        ]);
        $maintainer = Maintainer::factory()->create([
            'github_username' => 'Baz',
        ]);
        $project->maintainers()->attach($maintainer);

        $this->artisan('stats:fetch')->assertSuccessful();
        $project->refresh();

        $this->assertEquals($project->downloads_total, 1000);
        $this->assertEquals($project->downloads_last_30_days, 100);
        $this->assertEquals($project->issues_count, 0);
        $this->assertEquals($project->pull_requests_count, 0);
        $this->assertEquals($project->issues, collect([]));
        $this->assertEquals($project->pull_requests, collect([]));
        $this->assertNotEmpty(Cache::get('projects'));
    }

    /** @test */
    public function report_errors_if_fetching_fails(): void
    {
        $this->markTestIncomplete();
    }
}
