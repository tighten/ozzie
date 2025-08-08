<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class FetchResultFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'type' => 'packagist',
            'success' => true,
        ];
    }

    public function success(): self
    {
        return $this->state([
            'success' => true,
        ]);
    }

    public function fail(): self
    {
        return $this->state([
            'success' => false,
        ]);
    }
}
