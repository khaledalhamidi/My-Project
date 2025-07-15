<?php

namespace Database\Factories;

use App\Models\employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
   public function definition(): array
    {
        $arabicFaker = \Faker\Factory::create('ar_SA');

        $employeeId = Employee::inRandomOrder()->value('id') ?? Employee::factory()->create()->id;

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            // 'employee_id' => \App\Models\Employee::inRandomOrder()->first()->id ?? \App\Models\Employee::factory(),

            'title' => [
                'en' => $this->faker->sentence(3),
                'ar' => $arabicFaker->sentence(3),
            ],
            'description' => [
                'en' => $this->faker->paragraph(),
                'ar' => $arabicFaker->paragraph(),
            ],


            'status' => $this->faker->randomElement(['new', 'in_progress', 'pending', 'completed']),
            'created_by' => Employee::inRandomOrder()->first()?->id ?? Employee::factory(),
        ];
    }
}
