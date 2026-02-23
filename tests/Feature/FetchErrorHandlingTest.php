<?php

namespace Tests\Feature;

use App\Models\FetchResult;
use App\Models\Project;
use App\Remotes\Packagist\Package;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Throwable;

class FetchErrorHandlingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function packagist_curl_error_marks_as_unsuccessful(): void
    {
        $project = Project::factory()->create([
            'namespace' => 'tighten',
            'name' => 'foobar',
            'packagist_name' => 'tighten/foobar',
        ]);

        Http::fake([
            "https://packagist.org/packages/{$project->namespace}/{$project->name}.json" => function ($request) {

                // Guzzle will throw this kind of exception for curl errors
                // such as this. See CurlFactory for more details.
                throw new RequestException('cURL error 18: transfer closed with outstanding read data remaining', $request->toPsrRequest());
            },
        ]);

        try {
            // Attempt to fetch from Packagist
            $package = Package::fromProject($project);
            $this->assertNull($package->downloadsData);
        } catch (Throwable $e) {
            $this->fail('Package failed to swallow curl exception');
        }
    }

    /** @test */
    public function fetch_success_rate_calculates_for_package(): void
    {
        $project = Project::factory()->create();

        // Without any records the rate is null
        $this->assertNull($project->recentFetchSuccessRate());

        // 9 successes
        FetchResult::factory()
            ->times(9)
            ->success()
            ->create([
                'project_id' => $project->id,
            ]);

        $this->assertEquals(1, $project->recentFetchSuccessRate());

        // 1 failure
        FetchResult::factory()
            ->times(1)
            ->fail()
            ->create([
                'project_id' => $project->id,
            ]);

        $this->assertEquals(0.9, $project->recentFetchSuccessRate());
    }
}
