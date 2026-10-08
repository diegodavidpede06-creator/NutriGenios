<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nutriologos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();

            $table->string('cedula_profesional')->nullable();
            $table->string('telefono')->nullable();
            $table->text('especialidad')->nullable();
            $table->text('biografia')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nutriologos');
    }
};