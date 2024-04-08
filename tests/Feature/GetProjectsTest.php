<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function get_a_list_of_all_projects(): void
    {
        $project_a = Project::factory()->create(['namespace' => 'acme', 'name' => 'project_a']);
        $project_b = Project::factory()->create(['namespace' => 'acme', 'name' => 'project_b']);

        $this->getJson('/api/projects')
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'namespace' => 'acme',
                        'name' => 'project_a',
                        'issues' => [],
                        'pull_requests' => [],
                        'downloads_total' => 0,
                        'downloads_last_30_days' => 0,
                        'packagist_name' => $project_a->packagist_name,
                        'is_hidden' => false,
                        'debt_score' => 0,
                    ],
                    [
                        'namespace' => 'acme',
                        'name' => 'project_b',
                        'issues' => [],
                        'pull_requests' => [],
                        'downloads_total' => 0,
                        'downloads_last_30_days' => 0,
                        'packagist_name' => $project_b->packagist_name,
                        'is_hidden' => false,
                        'debt_score' => 0,
                    ],
                ]
            ]);
    }
}
