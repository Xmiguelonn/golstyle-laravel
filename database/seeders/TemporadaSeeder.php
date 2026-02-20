<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB;

class TemporadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('temporada')->insert([
            [
                'inicio' => 2020,
                'fin' => 2021,
            ],
            [
                'inicio' => 2025,
                'fin' => 2026,  
            ],
        ]);

    }
}
