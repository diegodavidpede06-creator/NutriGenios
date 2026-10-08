<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FormularioClinicoController;
use App\Http\Controllers\NutriologoController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'inicio'])
    ->name('inicio');

Route::get('/consultorio', [PublicController::class, 'consultorio'])
    ->name('consultorio');

Route::get('/publicaciones', [PublicController::class, 'publicaciones'])
    ->name('publicaciones');

Route::get('/publicaciones/{slug}', [PublicController::class, 'mostrarPublicacion'])
    ->name('publicaciones.mostrar');

Route::get('/contacto', [PublicController::class, 'contacto'])
    ->name('contacto');


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'mostrarLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])
        ->name('registro');

    Route::post('/registro', [AuthController::class, 'registro'])
        ->name('registro.store');
});


Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('acceso')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ÁREA DEL CLIENTE
|--------------------------------------------------------------------------
*/

Route::prefix('cliente')
    ->name('cliente.')
    ->middleware(['acceso', 'cliente'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [ClienteController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | PERFIL
        |--------------------------------------------------------------------------
        */

        Route::get('/perfil', [ClienteController::class, 'perfil'])
            ->name('perfil');

        Route::put('/perfil', [ClienteController::class, 'actualizarPerfil'])
            ->name('perfil.actualizar');


        /*
        |--------------------------------------------------------------------------
        | CITAS
        |--------------------------------------------------------------------------
        */

        Route::get('/citas', [ClienteController::class, 'citas'])
            ->name('citas');

        Route::get('/citas/nueva', [CitaController::class, 'crear'])
            ->name('citas.crear');

        Route::get('/citas/disponibilidad', [CitaController::class, 'disponibilidad'])
            ->name('citas.disponibilidad');

        Route::post('/citas', [CitaController::class, 'store'])
            ->name('citas.store');

        Route::get('/citas/{cita}', [CitaController::class, 'mostrar'])
            ->name('citas.mostrar');

        Route::patch('/citas/{cita}/cancelar', [CitaController::class, 'cancelar'])
            ->name('citas.cancelar');


        /*
        |--------------------------------------------------------------------------
        | FORMULARIO CLÍNICO
        |--------------------------------------------------------------------------
        */

        Route::get('/formulario-clinico', [FormularioClinicoController::class, 'create'])
            ->name('formulario.create');

        Route::get('/formulario-clinico', [FormularioClinicoController::class, 'create'])
            ->name('formulario.crear');

        Route::post('/formulario-clinico', [FormularioClinicoController::class, 'store'])
            ->name('formulario.store');

        Route::get('/formulario-clinico/editar', [FormularioClinicoController::class, 'edit'])
            ->name('formulario.edit');

        Route::get('/formulario-clinico/editar', [FormularioClinicoController::class, 'edit'])
            ->name('formulario.editar');

        Route::put('/formulario-clinico', [FormularioClinicoController::class, 'update'])
            ->name('formulario.update');
    });


/*
|--------------------------------------------------------------------------
| ÁREA DEL NUTRIÓLOGO / SUPERUSUARIO
|--------------------------------------------------------------------------
*/

Route::prefix('nutriologo')
    ->name('nutriologo.')
    ->middleware(['acceso', 'superusuario'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [NutriologoController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | PERFIL
        |--------------------------------------------------------------------------
        */

        Route::get('/perfil', [NutriologoController::class, 'perfil'])
            ->name('perfil');

        Route::put('/perfil', [NutriologoController::class, 'actualizarPerfil'])
            ->name('perfil.actualizar');


        /*
        |--------------------------------------------------------------------------
        | CLIENTES
        |--------------------------------------------------------------------------
        */

        Route::get('/clientes', [NutriologoController::class, 'clientes'])
            ->name('clientes');

        Route::get('/clientes/{cliente}', [NutriologoController::class, 'mostrarCliente'])
            ->name('clientes.mostrar');

        Route::get('/clientes/{cliente}/formulario-clinico', [NutriologoController::class, 'mostrarFormulario'])
            ->name('formularios.mostrar');


        /*
        |--------------------------------------------------------------------------
        | CITAS
        |--------------------------------------------------------------------------
        */

        Route::get('/citas', [NutriologoController::class, 'citas'])
            ->name('citas');

        Route::get('/citas/{cita}', [NutriologoController::class, 'mostrarCita'])
            ->name('citas.mostrar');

        Route::patch('/citas/{cita}/confirmar', [NutriologoController::class, 'confirmarCita'])
            ->name('citas.confirmar');

        Route::patch('/citas/{cita}/cancelar', [NutriologoController::class, 'cancelarCita'])
            ->name('citas.cancelar');

        Route::patch('/citas/{cita}/atendida', [NutriologoController::class, 'marcarAtendida'])
            ->name('citas.atendida');

        Route::patch('/citas/{cita}/no-asistio', [NutriologoController::class, 'marcarNoAsistio'])
            ->name('citas.no-asistio');


        /*
        |--------------------------------------------------------------------------
        | PUBLICACIONES
        |--------------------------------------------------------------------------
        */

        Route::get('/publicaciones', [PublicacionController::class, 'index'])
            ->name('publicaciones');

        Route::get('/publicaciones/crear', [PublicacionController::class, 'crear'])
            ->name('publicaciones.crear');

        Route::post('/publicaciones', [PublicacionController::class, 'store'])
            ->name('publicaciones.store');

        Route::get('/publicaciones/{publicacion}/editar', [PublicacionController::class, 'editar'])
            ->name('publicaciones.editar');

        Route::put('/publicaciones/{publicacion}', [PublicacionController::class, 'update'])
            ->name('publicaciones.update');

        Route::delete('/publicaciones/{publicacion}', [PublicacionController::class, 'destroy'])
            ->name('publicaciones.destroy');
    });