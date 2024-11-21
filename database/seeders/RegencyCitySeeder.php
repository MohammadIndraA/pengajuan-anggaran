<?php

namespace Database\Seeders;

use App\Models\RegencyCity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegencyCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegencyCity::factory()->create();
    }
}
