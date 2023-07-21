<?php

namespace Tests\Unit;

use App\Models\Maintainer;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DumpProjectsTableToJsonTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_dumps_non_hidden_projects_to_json(): void
    {
        Storage::fake('root');

        $project = Project::factory()->create(['name' => 'Whistling']);
        $maintainer = Maintainer::factory()->create(['github_username' => 'Suzy Sheep']);
        $project->maintainers()->attach($maintainer);

        // Seed an extra (unattached) maintainer and a hidden project,
        // neither of which should be included in the output JSON
        $otherProject = Project::factory()->hidden()->create(['name' => 'ChopTheTreeDown']);
        $otherMaintainer = Maintainer::factory()->create(['github_username' => 'Zoë Zebra']);

        Artisan::call('projects:json');

        $this->assertFileExists(base_path('projects.json.dist'));

        $json = Storage::disk('root')->get('projects.json.dist');
        $this->assertStringNotContainsStringIgnoringCase($otherMaintainer->github_username, $json);
        $this->assertStringNotContainsStringIgnoringCase($otherProject->name, $json);

        $outputAsArray = json_decode($json, true);
        $this->assertCount(1, $outputAsArray);

        // Make sure the file JSON equals the expected output
        $this->assertEquals(
            [
                [
                    'name' => $project->name,
                    'namespace' => $project->namespace,
                    'packagist_name' => $project->packagist_name,
                    'maintainers' => [$maintainer->github_username],
                ],
            ],
            $outputAsArray
        );
    }

    /** @test */
    public function using_all_flag_dumps_all_projects(): void
    {
        Storage::fake('root');

        Project::factory()->count(3)->create();
        Project::factory()->hidden()->count(2)->create();

        Artisan::call('projects:json', ['--all' => true]);

        $this->assertFileExists(base_path('projects.json.dist'));

        $outputAsArray = json_decode(Storage::disk('root')->get('projects.json.dist'), true);

        $this->assertCount(5, $outputAsArray);
    }
}
