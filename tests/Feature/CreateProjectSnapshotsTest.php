<?php

namespace Tests\Feature;

use App\Cache\CachedProjectList;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateProjectSnapshotsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function one_snapshot_is_created_for_each_project(): void
    {
        $projects = Project::factory()
            ->count(3)
            ->withPrs([['number' => 1], ['number' => 2], ['number' => 3]])
            ->withIssues([['number' => 1], ['number' => 2]])
            ->create();

        $this->artisan('stats:snapshot')
            ->assertExitCode(0);

        $this->assertDatabaseCount('snapshots', 3);

        $projects->each(function ($project) {
            $this->assertDatabaseHas('snapshots', [
                'project_id' => $project->id,
                'snapshot_date' => now()->format('Y-m-d'),
                'debt_score' => $project->debtScore(),
                'pull_request_count' => 3,
                'old_pull_request_count' => 0,
                'issue_count' => 2,
                'old_issue_count' => 0,
                'downloads_total' => 0,
                'downloads_last_30_days' => 0,
            ]);
        });
    }

    #[Test]
    public function no_snapshots_are_created_if_the_project_has_already_been_snapshotted_today(): void
    {
        Project::factory()
            ->create();

        $this->artisan('stats:snapshot')
            ->assertExitCode(0);

        $this->artisan('stats:snapshot')
            ->expectsOutput('No projects need snapshots for ' . now()->format('Y-m-d'))
            ->assertExitCode(0);

        $this->assertDatabaseCount('snapshots', 1);
    }

    #[Test]
    public function the_force_option_overwrites_the_project_snapshot_taken_today(): void
    {
        $project = Project::factory()
            ->create(['downloads_total' => 50]);

        $this->artisan('stats:snapshot')
            ->assertExitCode(0);

        $this->assertDatabaseCount('snapshots', 1);
        $this->assertDatabaseHas('snapshots', [
            'project_id' => $project->id,
            'downloads_total' => 50,
        ]);

        $project->update(['downloads_total' => 1000]);

        $this->artisan('stats:snapshot --force')
            ->assertExitCode(0);

        $this->assertDatabaseCount('snapshots', 1);
        $this->assertDatabaseHas('snapshots', [
            'project_id' => $project->id,
            'downloads_total' => 1000,
        ]);
    }

    #[Test]
    public function no_snapshots_are_created_if_no_projects_exist(): void
    {
        $this->artisan('stats:snapshot')
            ->expectsOutput('No projects need snapshots for ' . now()->format('Y-m-d'))
            ->assertExitCode(0);
    }

    #[Test]
    public function the_cache_is_cleared_and_rebuilt_after_snapshots_are_taken(): void
    {
        Cache::shouldReceive('clear')
            ->once();

        $cacheRebuilt = false;

        $this->app->bind(CachedProjectList::class, function () use (&$cacheRebuilt) {
            return function () use (&$cacheRebuilt) {
                $cacheRebuilt = true;
            };
        });

        Project::factory()->create();

        $this->artisan('stats:snapshot')
            ->assertExitCode(0);

        $this->assertTrue($cacheRebuilt);
    }
}
