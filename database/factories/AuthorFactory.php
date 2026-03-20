<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'  => fake()->name(),
            'bio'   => fake()->paragraph()
        ];
    }
}
