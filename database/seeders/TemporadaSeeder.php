<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemporadaSeeder extends Seeder
{
    public function run()
    {
        DB::table('temporada')->insert([
            ['inicio' => 2020, 'fin' => 2021],
            ['inicio' => 2021, 'fin' => 2022],
            ['inicio' => 2022, 'fin' => 2023],
            ['inicio' => 2023, 'fin' => 2024],
            ['inicio' => 2024, 'fin' => 2025],
        ]);
    }
}
