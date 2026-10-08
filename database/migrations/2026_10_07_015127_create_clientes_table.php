<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();

            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('genero')->nullable();

            $table->text('direccion')->nullable();

            $table->string('contacto_emergencia')->nullable();
            $table->string('telefono_emergencia')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};