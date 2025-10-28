<?php

namespace Database\Seeders;

use App\Models\Pelicula;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Pelicula::factory()->times(1000)->create();
    }
}
