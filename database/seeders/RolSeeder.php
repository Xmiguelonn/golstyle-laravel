<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rol')->insert([
            ['id' => 1, 'nombre' => 'usuario'],
            ['id' => 2, 'nombre' => 'admin'],
        ]);
    }
}
