<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;

class LigaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('liga')->insert([
            [
                'nombre' => 'La Liga'
            ],
            [
                'nombre' => 'Premier League',
            ]
        ]);

    }
}
