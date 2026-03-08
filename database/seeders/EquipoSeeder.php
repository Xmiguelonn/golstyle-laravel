<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('equipo')->insert([
            // LaLiga
            ['nombre' => 'Real Madrid', 'cod_lig' => 1],
            ['nombre' => 'FC Barcelona', 'cod_lig' => 1],
            ['nombre' => 'Atlético de Madrid', 'cod_lig' => 1],

            // Premier League
            ['nombre' => 'Manchester City', 'cod_lig' => 2],
            ['nombre' => 'Liverpool', 'cod_lig' => 2],
            ['nombre' => 'Arsenal', 'cod_lig' => 2],

            // Serie A
            ['nombre' => 'Juventus', 'cod_lig' => 3],
            ['nombre' => 'AC Milan', 'cod_lig' => 3],
            ['nombre' => 'Inter de Milán', 'cod_lig' => 3],

            // Bundesliga
            ['nombre' => 'Bayern Munich', 'cod_lig' => 4],
            ['nombre' => 'Borussia Dortmund', 'cod_lig' => 4],
            ['nombre' => 'RB Leipzig', 'cod_lig' => 4],

            // Ligue 1
            ['nombre' => 'Paris Saint-Germain', 'cod_lig' => 5],
            ['nombre' => 'Olympique de Marseille', 'cod_lig' => 5],
            ['nombre' => 'Olympique Lyonnais', 'cod_lig' => 5],
        ]);
    }
}
