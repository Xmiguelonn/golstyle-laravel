<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('equipo')->insert([
            [
                'nombre' => 'Real Madrid',
                'cod_lig' => 1,
            ],
            [
                'nombre' => 'Girona',
                'cod_lig' => 1,
            ],
            [
                'nombre' => 'Manchester City',
                'cod_lig' => 2,
            ]

        ]);

    }
}
