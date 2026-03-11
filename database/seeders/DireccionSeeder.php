<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DireccionSeeder extends Seeder
{
    public function run()
    {
        DB::table('direccion')->insert([
            [
                'calle' => 'Calle Real',
                'num' => '10',
                'piso' => '2A',
                'cp' => '29700',
                'telefono' => '600112233',
                'ciudad' => 'Vélez-Málaga',
                'provincia' => 'Málaga',
                'cod_usu' => 1, // David
            ],
            [
                'calle' => 'Avenida de la Constitución',
                'num' => '5',
                'piso' => null,
                'cp' => '29740',
                'telefono' => '611445566',
                'ciudad' => 'Torre del Mar',
                'provincia' => 'Málaga',
                'cod_usu' => 2, // Miguel Ángel
            ],
            [
                'calle' => 'Calle Larios',
                'num' => '1',
                'piso' => 'Bajo',
                'cp' => '29005',
                'telefono' => '622778899',
                'ciudad' => 'Málaga',
                'provincia' => 'Málaga',
                'cod_usu' => 1, // David (segunda dirección)
            ]
        ]);
    }
}