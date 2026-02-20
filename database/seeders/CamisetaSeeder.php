<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;

class CamisetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('camiseta')->insert([
            [
                'color' => 'rojo',
                'cod_equi' => null,
                'cod_sel' => 2,
                'cod_tem' => 1,
                'imagen_principal' => 'Se supone que esto es la imagen, no me critiquen',
            ],
            [
                'color' => 'azul',
                'cod_equi' => null,
                'cod_sel' => 1,
                'cod_tem' => 2,
                'imagen_principal' => 'Se supone que esto es la imagen, no me critiquen',
            ],
            [
                'color' => 'blanco',
                'cod_equi' => 2,
                'cod_sel' => null,
                'cod_tem' => 2,
                'imagen_principal' => 'Se supone que esto es la imagen, no me critiquen',
            ],

        ]);

    }
}
