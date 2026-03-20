<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'         => fake()->sentence(),  // Сгенерирует случайное предложение
            'description'   => fake()->paragraph(), // Сгенерирует случайный абзац текста
        ];
    }
}
