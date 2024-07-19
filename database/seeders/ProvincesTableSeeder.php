<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = [
            ['name' => 'Ilocos Norte'],
            ['name' => 'Ilocos Sur'],
            ['name' => 'La Union'],
            ['name' => 'Pangasinan'],
            ['name' => 'Batanes'],
            ['name' => 'Cagayan'],
            ['name' => 'Isabela'],
            ['name' => 'Nueva Vizcaya'],
            ['name' => 'Quirino'],
            ['name' => 'Aurora'],
            ['name' => 'Bataan'],
            ['name' => 'Bulacan'],
            ['name' => 'Nueva Ecija'],
            ['name' => 'Pampanga'],
            ['name' => 'Tarlac'],
            ['name' => 'Zambales'],
            ['name' => 'Batangas'],
            ['name' => 'Cavite'],
            ['name' => 'Laguna'],
            ['name' => 'Quezon'],
            ['name' => 'Rizal'],
            ['name' => 'Marinduque'],
            ['name' => 'Occidental Mindoro'],
            ['name' => 'Oriental Mindoro'],
            ['name' => 'Palawan'],
            ['name' => 'Romblon'],
        ];

        DB::table('provinces')->insert($provinces);
    }
}
