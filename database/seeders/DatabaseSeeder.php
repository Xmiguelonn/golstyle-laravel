<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->call([
            RolSeeder::class,
            EstadoPedidoSeeder::class,
            UsuarioSeeder::class,
            DireccionSeeder::class,
            LigaSeeder::class,
            EquipoSeeder::class,
            SeleccionSeeder::class,
            TemporadaSeeder::class,
            CamisetaSeeder::class,
            VariantesCamisetaSeeder::class,
            PedidoSeeder::class,
            DetallePedidoSeeder::class,
        ]);
    }
}
