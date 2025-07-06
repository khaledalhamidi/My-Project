<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {



        $this->call([
        PostSeeder::class,

        EmployeeSeeder::class,
        WorkSeeder::class,
        DepartmentSeeder::class,
       DepartmentWorkSeeder::class,

    ]);
    }
}
