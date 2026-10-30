<?php

namespace Tests\Feature;

use App\Console\Commands\FetchGitHubProjects;
use App\Enums\PackageRegistry;
use App\Models\Project;
use Facades\Github\Client as GitHubClient;
use Github\Api\Repo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function fetch_projects_and_persist_successfully(): void
    {
        $this->artisan(FetchGitHubProjects::class);

        $this->assertDatabaseCount('projects', 2);

        $this->assertDatabaseHas('projects', [
            'namespace' => 'tighten',
            'name' => 'ziggy',
            'packagist_name' => 'tighten/ziggy',
            'npm_name' => null,
            'package_registry' => PackageRegistry::Packagist->value,
        ]);

        $this->assertDatabaseHas('projects', [
            'namespace' => 'tighten',
            'name' => 'collect',
            'packagist_name' => 'tighten/collect',
            'npm_name' => null,
            'package_registry' => PackageRegistry::Packagist->value,
        ]);
    }

    #[Test]
    public function projects_on_no_package_registry_are_recorded_as_such(): void
    {
        $this->fakeNpm();

        $this->artisan(FetchGitHubProjects::class, ['--archived' => true]);

        $this->assertDatabaseHas('projects', [
            'namespace' => 'tighten',
            'name' => 'confomo',
            'packagist_name' => null,
            'npm_name' => null,
            'package_registry' => PackageRegistry::None->value,
        ]);
    }

    #[Test]
    public function npm_packages_are_detected_when_they_point_back_at_the_repo(): void
    {
        $this->fakeNpm([
            'confomo' => [
                'name' => 'confomo',
                'repository' => ['type' => 'git', 'url' => 'git+https://github.com/tighten/confomo.git'],
            ],
        ]);

        $this->artisan(FetchGitHubProjects::class, ['--archived' => true]);

        $this->assertDatabaseHas('projects', [
            'namespace' => 'tighten',
            'name' => 'confomo',
            'packagist_name' => null,
            'npm_name' => 'confomo',
            'package_registry' => PackageRegistry::Npm->value,
        ]);
    }

    #[Test]
    public function an_npm_package_belonging_to_another_repo_is_not_claimed(): void
    {
        $this->fakeNpm([
            'confomo' => [
                'name' => 'confomo',
                'repository' => ['type' => 'git', 'url' => 'git+https://github.com/someone-else/confomo.git'],
            ],
        ]);

        $this->artisan(FetchGitHubProjects::class, ['--archived' => true]);

        $this->assertDatabaseHas('projects', [
            'namespace' => 'tighten',
            'name' => 'confomo',
            'npm_name' => null,
            'package_registry' => PackageRegistry::None->value,
        ]);
    }

    #[Test]
    public function fetch_projects_and_persist_successfully_with_all_option_enabled(): void
    {
        $this->fakeNpm();

        $this->artisan(FetchGitHubProjects::class, ['--all' => true]);

        $this->assertDatabaseCount('projects', 4);
    }

    #[Test]
    public function fetch_projects_and_persist_successfully_with_archived_option_enabled(): void
    {
        $this->fakeNpm();

        $this->artisan(FetchGitHubProjects::class, ['--archived' => true]);

        $this->assertDatabaseCount('projects', 3);
    }

    #[Test]
    public function fetch_projects_and_persist_successfully_with_fork_option_enabled(): void
    {
        $this->fakeNpm();

        $this->artisan(FetchGitHubProjects::class, ['--fork' => true]);

        $this->assertDatabaseCount('projects', 3);
    }

    #[Test]
    public function avoid_persisting_projects_that_already_exist_in_the_database(): void
    {
        $existingProject = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'ziggy',
            'packagist_name' => 'tighten/ziggy',
        ]);

        $this->artisan(FetchGitHubProjects::class);

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

    /**
     * Stub the npm registry. Anything not listed in $packages 404s, i.e. isn't
     * published to npm. Stubs are matched in the order they're registered, so
     * the catch-all has to go last.
     */
    protected function fakeNpm(array $packages = []): void
    {
        Http::fake(collect($packages)
            ->mapWithKeys(fn ($package, $name) => ["registry.npmjs.org/{$name}" => Http::response($package)])
            ->put('registry.npmjs.org/*', Http::response([], 404))
            ->all());
    }
}
