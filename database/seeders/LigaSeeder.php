<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LigaSeeder extends Seeder
{
    public function run()
    {
        DB::table('liga')->insert([
            ['nombre' => 'LaLiga'],
            ['nombre' => 'Premier League'],
            ['nombre' => 'Serie A'],
            ['nombre' => 'Bundesliga'],
            ['nombre' => 'Ligue 1'],
        ]);
    }
}
