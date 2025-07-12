<?php

namespace Database\Factories;

use App\Models\employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'employee_id' => \App\Models\Employee::inRandomOrder()->first()->id ?? \App\Models\Employee::factory(),
            'status' => $this->faker->randomElement(['new', 'in_progress', 'pending', 'completed']),
            'created_by' => Employee::inRandomOrder()->first()?->id ?? Employee::factory(),
        ];
    }
}
