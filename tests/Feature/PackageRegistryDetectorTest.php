<?php

namespace Tests\Feature;

use App\Enums\PackageRegistry;
use App\Models\Project;
use App\Remotes\PackageRegistryDetector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PackageRegistryDetectorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    #[Test]
    public function a_packagist_name_we_already_have_is_trusted_without_searching(): void
    {
        // No search.json fake: searching Packagist here would be a stray request
        Http::fake([
            'packagist.org/packages/tightenco/jigsaw.json' => Http::response(['package' => []]),
        ]);

        $project = Project::factory()->undetectedRegistry()->create([
            'namespace' => 'tighten',
            'name' => 'jigsaw',
            'packagist_name' => 'tightenco/jigsaw',
        ]);

        $this->assertEquals(PackageRegistry::Packagist, $this->detector()->detect($project));
        $this->assertEquals('tightenco/jigsaw', $project->packagist_name);
    }

    #[Test]
    public function a_scoped_npm_package_is_detected(): void
    {
        Http::fake([
            'packagist.org/search.json*' => Http::response(['results' => []]),
            'registry.npmjs.org/dashboard' => Http::response([], 404),
            'registry.npmjs.org/@tighten/dashboard' => Http::response([
                'name' => '@tighten/dashboard',
                'repository' => 'github:tighten/dashboard',
            ]),
        ]);

        $project = Project::factory()->undetectedRegistry()->create([
            'namespace' => 'tighten',
            'name' => 'dashboard',
        ]);

        $this->assertEquals(PackageRegistry::Npm, $this->detector()->detect($project));
        $this->assertEquals('@tighten/dashboard', $project->npm_name);
        $this->assertNull($project->packagist_name);
    }

    #[Test]
    public function packagist_wins_when_a_project_is_published_to_both(): void
    {
        Http::fake([
            'packagist.org/search.json*' => Http::response(['results' => [
                [
                    'name' => 'tighten/ziggy',
                    'repository' => 'https://github.com/tighten/ziggy',
                ],
            ]]),
        ]);

        $project = Project::factory()->undetectedRegistry()->create([
            'namespace' => 'tighten',
            'name' => 'ziggy',
        ]);

        $this->assertEquals(PackageRegistry::Packagist, $this->detector()->detect($project));
        $this->assertEquals('tighten/ziggy', $project->packagist_name);
    }

    #[Test]
    public function an_unreachable_npm_leaves_the_project_alone(): void
    {
        Http::fake([
            'packagist.org/search.json*' => Http::response(['results' => []]),
            'registry.npmjs.org/*' => Http::response([], 503),
        ]);

        $project = Project::factory()->undetectedRegistry()->create([
            'namespace' => 'tighten',
            'name' => 'dashboard',
        ]);

        $this->assertNull($this->detector()->detect($project));
        $this->assertEquals(PackageRegistry::Unknown, $project->package_registry);
    }

    #[Test]
    public function redetect_restores_existing_names_when_the_registries_cannot_be_reached(): void
    {
        Http::fake([
            'packagist.org/search.json*' => Http::response([], 503),
        ]);

        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'jigsaw',
            'packagist_name' => 'tightenco/jigsaw',
        ]);

        $this->assertNull($this->detector()->redetect($project));
        $this->assertEquals('tightenco/jigsaw', $project->packagist_name);
        $this->assertEquals(PackageRegistry::Packagist, $project->package_registry);
    }

    protected function detector(): PackageRegistryDetector
    {
        return app(PackageRegistryDetector::class);
    }
}
