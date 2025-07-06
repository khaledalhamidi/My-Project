<?php

namespace Database\Seeders;
use App\Models\Department;
use App\Models\work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentWorkSeeder extends Seeder
{
    public function run(): void
    {
        // أنشئ 5 أقسام و 10 أعمال أولاً
        $departments = Department::factory()->count(5)->create();
        $works = Work::factory()->count(10)->create();

        // ربط كل قسم بـ 2-4 أعمال عشوائية
        foreach ($departments as $department) {
            $randomWorks = $works->random(rand(2, 4))->pluck('id')->toArray();
            $department->works()->attach($randomWorks);
        }
    }
}
