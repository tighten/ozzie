<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaintainerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'github_username' => fake()->userName,
        ];
    }
}
