<?php

namespace Tests\Feature;

use App\Models\Project;
use Github\Api\Repo;
use GrahamCampbell\GitHub\Facades\GitHub as GitHubClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class FetchGitHubProjectsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();

        Http::fake([
            'packagist.org/search.json?q=tighten&per_page=100' => Http::response([
                'results' => [
                    [
                        'name' => 'tighten/ziggy',
                        'description' => 'Use your Laravel named routes in JavaScript.',
                        'url' => 'https://packagist.org/packages/tighten/ziggy',
                        'repository' => 'https://github.com/tighten/ziggy',
                        'downloads' => 16043634,
                        'favers' => 3697,
                    ],
                    [
                        'name' => 'tighten/collect',
                        'description' => 'Collect - Illuminate Collections as a separate package.',
                        'url' => 'https://packagist.org/packages/tighten/collect',
                        'repository' => 'https://github.com/tighten/collect',
                        'downloads' => 17251907,
                        'favers' => 1540,
                        'abandoned' => 'illuminate/collections',
                    ],
                ],
            ]),
        ]);

        $this->mockGithubClient('tighten');
    }

    /** @test */
    public function fetch_projects_and_persist_successfully(): void
    {
        $this->artisan('projects:fetch');

        $this->assertDatabaseCount('projects', 2);

        $this->assertDatabaseHas('projects', [
            'namespace' => 'tighten',
            'name' => 'ziggy',
            'packagist_name' => 'tighten/ziggy',
        ]);

        $this->assertDatabaseHas('projects', [
            'namespace' => 'tighten',
            'name' => 'collect',
            'packagist_name' => 'tighten/collect',
        ]);
    }

    /** @test */
    public function fetch_projects_and_persist_successfully_with_all_option_enabled(): void
    {
        $this->artisan('projects:fetch --all');

        $this->assertDatabaseCount('projects', 4);
    }

    /** @test */
    public function fetch_projects_and_persist_successfully_with_archived_option_enabled(): void
    {
        $this->artisan('projects:fetch --archived');

        $this->assertDatabaseCount('projects', 3);
    }

    /** @test */
    public function fetch_projects_and_persist_successfully_with_fork_option_enabled(): void
    {
        $this->artisan('projects:fetch --fork');

        $this->assertDatabaseCount('projects', 3);
    }

    /** @test */
    public function avoid_persisting_projects_that_already_exist_in_the_database(): void
    {
        $existingProject = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'ziggy',
            'packagist_name' => 'tighten/ziggy',
        ]);

        $this->artisan('projects:fetch');

        $this->assertDatabaseCount('projects', 2);
        $this->assertEquals($existingProject->updated_at, $existingProject->fresh()->updated_at);
    }

    public function mockGithubClient($namespace): void
    {
        $repoMock = Mockery::mock(Repo::class);

        $repoMock->shouldReceive('org')
            ->with($namespace, [
                'page' => 1,
                'per_page' => 100,
            ])
            ->once()
            ->andReturn([
                [
                    'full_name' => 'tighten/ziggy',
                    'description' => 'Use your Laravel named routes in JavaScript.',
                    'url' => 'https://api.github.com/repos/tighten/ziggy',
                    'archived' => false,
                    'fork' => false,
                ],
                [
                    'full_name' => 'tighten/collect',
                    'description' => 'Collect - Illuminate Collections as a separate package.',
                    'url' => 'https://api.github.com/repos/tighten/collect',
                    'archived' => false,
                    'fork' => false,
                ],
                [
                    'full_name' => 'tighten/FlexSlider',
                    'description' => 'An awesome, fully responsive jQuery slider plugin',
                    'url' => 'https://api.github.com/repos/tighten/FlexSlider',
                    'archived' => false,
                    'fork' => true,
                ],
                [
                    'full_name' => 'tighten/confomo',
                    'description' => 'ConFOMO is a simple tool that makes it easy to track your friends at conferences.',
                    'url' => 'https://api.github.com/repos/tighten/confomo',
                    'archived' => true,
                    'fork' => false,
                ],
            ]);

        $repoMock->shouldReceive('org')
            ->with($namespace, [
                'page' => 2,
                'per_page' => 100,
            ])
            ->once()
            ->andReturn([]);

        GitHubClient::shouldReceive('repositories')
            ->andReturn($repoMock);
    }
}
