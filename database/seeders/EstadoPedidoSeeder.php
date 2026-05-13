<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoPedidoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estado_pedido')->insert([
            ['id' => 1, 'nombre' => 'pendiente'],
            ['id' => 2, 'nombre' => 'enviado'],
            ['id' => 3, 'nombre' => 'entregado'],
            ['id' => 4, 'nombre' => 'cancelado'],
        ]);
    }
}
