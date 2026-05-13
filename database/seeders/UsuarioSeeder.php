<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuario')->insert([
            [
                'nombre' => 'David',
                'ape1' => 'Rivas',
                'ape2' => 'Garcia',
                'correo' => 'david@gmail.com',
                'password' => '$2y$12$5M9wD.YarHzLSO1CHVYjNO161GgCxxjovAsDlXIr26u6vTpMIzesm',
                'rol_id' => Rol::USUARIO,
                'email_verified_at' => now(),
            ],
            [
                'nombre' => 'Miguel Angel',
                'ape1' => 'Postigo',
                'ape2' => null,
                'correo' => 'miguel@gmail.com',
                'password' => '$2y$12$5M9wD.YarHzLSO1CHVYjNO161GgCxxjovAsDlXIr26u6vTpMIzesm',
                'rol_id' => Rol::USUARIO,
                'email_verified_at' => now(),
            ],
            [
                'nombre' => 'Manolo',
                'ape1' => 'Palomares',
                'ape2' => null,
                'correo' => 'manolo@gmail.com',
                'password' => '$2y$12$5M9wD.YarHzLSO1CHVYjNO161GgCxxjovAsDlXIr26u6vTpMIzesm',
                'rol_id' => Rol::USUARIO,
                'email_verified_at' => now(),
            ],
        ]);
    }
}
