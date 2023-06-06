<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->word;

        return [
            'name' => $name,
            'namespace' => config('app.organization'),
            'packagist_name' => config('app.organization').'/'.$name,
            'is_hidden' => false,
            'issues_count' => fake()->numberBetween(0, 5),
            'pull_requests_count' => fake()->numberBetween(0, 5),
            'issues' => [],
            'pull_requests' => [],
        ];
    }

    public function hidden(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_hidden' => true,
            ];
        });
    }
}
