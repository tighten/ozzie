<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function show_the_details_of_a_single_project(): void
    {
        $project = Project::factory()->create([
            'namespace' => $namespace = 'acme',
            'name' => $name = 'my-project',
            'packagist_name' => null,
        ]);

        $this->getJson("/api/projects/{$namespace}/{$name}")
            ->assertOk()
            ->assertJson([
                'data' => [
                    'namespace' => 'acme',
                    'name' => 'my-project',
                    'issues' => [],
                    'pull_requests' => [],
                    'downloads_total' => 0,
                    'downloads_last_30_days' => 0,
                    'packagist_name' => $project->packagist_name,
                    'is_hidden' => false,
                    'debt_score' => 0,
                ],
            ]);
    }
}
