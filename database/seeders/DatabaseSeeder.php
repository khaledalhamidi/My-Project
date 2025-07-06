<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([
        //     //PostSeeder::class,
        //    // CustomerSeeder::class,
        //     EmployeeSeeder::class,   // ✅ Add this if you created it
        //     WorkSeeder::class,       // ✅ Add this if you created it
        // ]);


        $this->call([
        // PostSeeder::class,
        // CustomerSeeder::class,
        EmployeeSeeder::class,
        WorkSeeder::class,
    ]);
    }
}
