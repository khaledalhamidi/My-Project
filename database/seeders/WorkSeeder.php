<?php

namespace Database\Seeders;

use App\Models\employee;
use App\Models\work;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // //
        Work::factory()->count(100000)->create();
        $startDate = Carbon::create(2025, 6, 15);
        $endDate = Carbon::create(2025, 7, 15);

        $period = CarbonPeriod::create($startDate, '1 day', $endDate);

        $tasksPerDay = [3, 4, 7]; // Day 1 = 10 tasks, Day 2 = 3, Day 3 = 7

        $employeeIds = Employee::pluck('id')->shuffle()->values();

        $employeeIndex = 0;

        foreach ($period as $date) {
            $dayIndex = $date->diffInDays($startDate);
            if (isset($tasksPerDay[$dayIndex])) {
                $count = $tasksPerDay[$dayIndex];
                for ($i = 0; $i < $count; $i++) {
                    // Loop over available employees
                    if (!isset($employeeIds[$employeeIndex])) {
                        $employeeIndex = 0;
                    }

                    Work::factory()->create([
                        'created_at' => $date->toDateString(),
                        'created_by' => $employeeIds[$employeeIndex],
                    ]);

                    $employeeIndex++;
                }
            }
        }
    }
}
