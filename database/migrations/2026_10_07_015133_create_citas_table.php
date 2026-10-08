<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete();

            $table->foreignId('nutriologo_id')
                ->constrained('nutriologos')
                ->cascadeOnDelete();

            $table->date('fecha');
            $table->time('hora');

            $table->string('estado')->default('pendiente');

            $table->text('motivo')->nullable();
            $table->text('notas')->nullable();

            $table->timestamps();

            $table->unique(['nutriologo_id', 'fecha', 'hora']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};