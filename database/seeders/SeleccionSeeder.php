<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;

class SeleccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('seleccion')->insert([
            [
                'nombre' => 'Argentina',
            ],
            [
                'nombre' => 'España',
            ]
        ]);

    }
}
