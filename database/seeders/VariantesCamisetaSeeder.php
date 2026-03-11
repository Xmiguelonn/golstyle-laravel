<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantesCamisetaSeeder extends Seeder
{
    public function run()
    {
        DB::table('variantes_camiseta')->insert([
            // Variantes para la Camiseta 1
            [
                'cod_var' => 1,
                'cod_cam' => 1,
                'talla' => 'S',
                'stock' => 10,
            ],
            [
                'cod_var' => 2,
                'cod_cam' => 1,
                'talla' => 'M',
                'stock' => 15,
            ],
            [
                'cod_var' => 3,
                'cod_cam' => 1,
                'talla' => 'L',
                'stock' => 5,
            ],
            // Variantes para la Camiseta 2
            [
                'cod_var' => 4,
                'cod_cam' => 2,
                'talla' => 'S',
                'stock' => 15,
            ],
            [
                'cod_var' => 5,
                'cod_cam' => 2,
                'talla' => 'M',
                'stock' => 20,
            ],
            [
                'cod_var' => 6,
                'cod_cam' => 2,
                'talla' => 'L',
                'stock' => 12,
            ],
            [
                'cod_var' => 7,
                'cod_cam' => 2,
                'talla' => 'XL',
                'stock' => 8,
            ],
        ]);
    }
}
