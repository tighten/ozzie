<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OutputStatsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function outputs_stats_in_the_console(): void
    {
        Project::factory()->create(['name' => 'project_a', 'namespace' => 'acme', 'issues_count' => 600]);
        Project::factory()->create(['name' => 'project_b', 'namespace' => 'acme', 'issues_count' => 300]);
        Project::factory()->create(['name' => 'project_c', 'namespace' => 'acme', 'issues_count' => 100]);

        $this->artisan('stats:output')
            ->expectsTable(
                ['Project', 'Debt Score'],
                [
                    ['acme/project_a', '6'],
                    ['acme/project_b', '3'],
                    ['acme/project_c', '1'],
                ])
            ->assertExitCode(0);
    }
}
