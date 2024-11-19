<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Province;
use App\Models\RegencyCity;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $roles = ['admin', 'pusat', 'province', 'regency', 'departement'];  
        $prov = Province::inRandomOrder()->first()->id;
        $regen = RegencyCity::inRandomOrder()->first()->id;
        $dev = Departement::inRandomOrder()->first()->id;
        foreach ($roles as $role) {  
            User::factory()->create([  
                'name' => $role,  
                'username' => $role,  
                'region' => fake()->address(),
                'email' => $role . '@mail.com',  
                'password' => Hash::make($role),  
                'role' => $role,
                'province_id' => $prov,
                'regency_city_id' => $regen,
                'departement_id' => 1,  
            ]);  
        }  
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
