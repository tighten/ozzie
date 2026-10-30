<?php

namespace Database\Factories;

use App\Enums\PackageRegistry;
use App\GitHub\Dto\Issue;
use App\GitHub\Dto\PullRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->word;

        return [
            'name' => $name,
            'namespace' => config('app.organization'),
            'packagist_name' => config('app.organization') . '/' . $name,
            'npm_name' => null,
            'package_registry' => PackageRegistry::Packagist,
            'is_hidden' => false,
            'issues_count' => 0,
            'pull_requests_count' => 0,
            'issues' => [],
            'pull_requests' => [],
        ];
    }

    public function npmPackage(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'packagist_name' => null,
                'npm_name' => $attributes['name'],
                'package_registry' => PackageRegistry::Npm,
            ];
        });
    }

    public function notAPackage(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'packagist_name' => null,
                'npm_name' => null,
                'package_registry' => PackageRegistry::None,
            ];
        });
    }

    public function undetectedRegistry(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'packagist_name' => null,
                'npm_name' => null,
                'package_registry' => PackageRegistry::Unknown,
            ];
        });
    }

    public function hidden(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_hidden' => true,
            ];
        });
    }

    public function withIssues(array $issues): Factory
    {
        return $this->state(function (array $attributes) use ($issues) {
            return [
                'issues_count' => count($issues),
                'issues' => collect($issues)->map(function ($issue, $index) {
                    return new Issue(array_merge([
                        'created_at' => now(),
                        'html_url' => fake()->url(),
                        'pull_request' => null,
                        'title' => fake()->sentence(),
                        'number' => $index,
                        'body' => fake()->paragraph(),
                        'labels' => [],
                        'user' => [
                            'html_url' => fake()->url(),
                            'login' => fake()->userName(),
                        ],
                    ], $issue));
                })->toArray(),
            ];
        });
    }

    public function withPrs(array $pullRequests): Factory
    {
        return $this->state(function (array $attributes) use ($pullRequests) {
            return [
                'pull_requests_count' => count($pullRequests),
                'pull_requests' => collect($pullRequests)->map(function ($pullRequest, $index) {
                    return new PullRequest(array_merge([
                        'created_at' => now(),
                        'html_url' => fake()->url(),
                        'draft' => fake()->boolean(),
                        'title' => fake()->sentence(),
                        'number' => $index,
                        'body' => fake()->paragraph(),
                        'node_id' => fake()->uuid(),
                        'labels' => [],
                        'user' => [
                            'html_url' => fake()->url(),
                            'login' => fake()->userName(),
                        ],
                    ], $pullRequest));
                })->toArray(),
            ];
        });
    }
}
