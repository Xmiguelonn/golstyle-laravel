<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    public function run()
    {
        DB::table('pedido')->insert([
            [
                'fecha' => now(),
                'total' => 55.50,
                'estado' => 'completado',
                'cod_usu' => 1,
                'cod_dir' => 1,
            ],
            [
                'fecha' => now(),
                'total' => 120.00,
                'estado' => 'pendiente',
                'cod_usu' => 1,                
                'cod_dir' => 3,
            ],
            [
                'fecha' => '2026-03-09',
                'total' => 89.99,
                'estado' => 'enviado',
                'cod_usu' => 2,
                'cod_dir' => 2,
            ]
        ]);
    }
}
