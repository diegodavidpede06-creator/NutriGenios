<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            [
                'email' => 'cliente@nutricion.test',
            ],
            [
                'name' => 'Cliente Demo',
                'password' => Hash::make('Cliente12345'),
                'role' => 'cliente',
                'activo' => true,
            ]
        );

        Cliente::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Cliente',
                'apellido_paterno' => 'Demo',
                'apellido_materno' => null,
                'fecha_nacimiento' => '2000-01-15',
                'telefono' => '5555555555',
                'genero' => null,
                'direccion' => null,
                'contacto_emergencia' => null,
                'telefono_emergencia' => null,
            ]
        );
    }
}