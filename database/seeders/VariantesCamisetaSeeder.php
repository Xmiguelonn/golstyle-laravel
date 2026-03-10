<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantesCamisetaSeeder extends Seeder
{
    public function run()
    {
        DB::table('variantes_camiseta')->insert([
            [
                'cod_cam' => 1,
                'talla' => 'S',
                'stock' => 15,
            ],
            [
                'cod_cam' => 1,
                'talla' => 'M',
                'stock' => 20,
            ],
            [
                'cod_cam' => 1,
                'talla' => 'L',
                'stock' => 18,
            ],
        ]);
    }
}
