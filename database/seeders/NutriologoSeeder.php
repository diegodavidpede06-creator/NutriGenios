<?php

namespace Database\Seeders;

use App\Models\Nutriologo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NutriologoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            [
                'email' => 'admin@nutricion.test',
            ],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin12345'),
                'role' => 'nutriologo',
                'activo' => true,
            ]
        );

        Nutriologo::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'nombre' => 'Administrador',
                'apellido_paterno' => 'del Consultorio',
                'apellido_materno' => null,
                'cedula_profesional' => null,
                'telefono' => null,
                'especialidad' => 'Nutrición',
                'biografia' => 'Profesional encargado de la atención nutricional.',
            ]
        );
    }
}