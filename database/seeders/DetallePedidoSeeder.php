<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetallePedidoSeeder extends Seeder
{
    public function run()
    {
        DB::table('detalle_pedido')->insert([
            // Productos para el Pedido #1
            [
                'precio_unid' => 25.50,
                'cantidad' => 1,
                'cod_ped' => 1, 
                'cod_var' => 1, // Camiseta 1, Talla S
                'nombre_personalizado' => 'DAVID',
                'dorsal_personalizado' => 10,
            ],
            [
                'precio_unid' => 25.50,
                'cantidad' => 1,
                'cod_ped' => 1,
                'cod_var' => 2, // Camiseta 1, Talla M
                'nombre_personalizado' => null,
                'dorsal_personalizado' => null,
            ],

            // Producto para el Pedido #2
            [
                'precio_unid' => 30.00,
                'cantidad' => 2,
                'cod_ped' => 2,
                'cod_var' => 4, // Camiseta 2, Talla M
                'nombre_personalizado' => 'MIGUEL',
                'dorsal_personalizado' => 7,
            ],

            // Producto para el Pedido #3
            [
                'precio_unid' => 25.50,
                'cantidad' => 1,
                'cod_ped' => 3,
                'cod_var' => 3, // Camiseta 1, Talla L
                'nombre_personalizado' => 'MANOLO',
                'dorsal_personalizado' => 9,
            ],
        ]);
    }
}