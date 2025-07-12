<?php

namespace Database\Seeders;
use App\Models\work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    Work::factory()->count(40)->create();

    }

}
