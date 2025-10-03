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
            'title'=> fake()->word(),
            'created_at' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'visibility' => fake()->word(),
            'expires_at' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'programming_language' => fake()->word()
        ];
    }
}
