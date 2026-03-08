<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeleccionSeeder extends Seeder
{
    public function run()
    {
        DB::table('seleccion')->insert([
            ['nombre' => 'España'],
            ['nombre' => 'Francia'],
            ['nombre' => 'Brasil'],
            ['nombre' => 'Argentina'],
            ['nombre' => 'Alemania'],
        ]);
    }
}
