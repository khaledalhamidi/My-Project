<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'name' => $this->faker->name(),
        'age' => $this->faker->numberBetween(18, 60),
        'city' => $this->faker->sentence(), // or better use $this->faker->city()
        'created_at' => now(),
        'updated_at' => now(),
    ];
    }
}
