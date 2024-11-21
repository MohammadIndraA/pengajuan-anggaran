<?php

namespace Database\Factories;

use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Province>
 */
class ProvinceFactory extends Factory
{
    protected $model = Province::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $id = 1; 
        $provinsi = [ 
        1 => 'Aceh',
         2 => 'Sumatera Utara',
         3 => 'Sumatera Barat',
         4 => 'Riau',
         5 => 'Jambi',
         6 => 'Sumatera Selatan',
         7 => 'Bengkulu',
         8 => 'Lampung',
         9 => 'Kepulauan Bangka Belitung',
         10 => 'Kepulauan Riau',
         11 => 'Dki Jakarta',
         12 => 'Jawa Barat',
         13 => 'Jawa Tengah',
         14 => 'Di Yogyakarta',
         15 => 'Jawa Timur',
         16 => 'Banten',
         17 => 'Bali',
         18 => 'Nusa Tenggara Barat',
         19 => 'Nusa Tenggara Timur',
         20 => 'Kalimantan Barat',
         21 => 'Kalimantan Tengah',
         22 => 'Kalimantan Selatan',
         23 => 'Kalimantan Timur',
         24 => 'Kalimantan Utara',
         25 => 'Sulawesi Utara',
         26 => 'Sulawesi Tengah',
         27 => 'Sulawesi Selatan',
         28 => 'Sulawesi Tenggara',
         29 => 'Gorontalo',
         30 => 'Sulawesi Barat',
         31 => 'Maluku',
         32 => 'Maluku Utara',
         33 => 'Papua Barat',
         34 => 'Papua' ];
         return [ '
         id' => $id,
        'name' => $provinsi[$id++], 
    ];
    }
}
