<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paste>
 */
class PasteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->realText(),
            'created_at' => fake()->dateTime(),
            'visibility' => fake()->word(),
            'expires_at' => fake()->dateTime(),
            'programming_language' => fake()->word()
        ];
    }
}
