<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nutriologo_id')
                ->constrained('nutriologos')
                ->cascadeOnDelete();

            $table->string('titulo');
            $table->string('slug')->unique();

            $table->text('resumen')->nullable();
            $table->longText('contenido');

            $table->string('imagen')->nullable();

            $table->boolean('publicada')->default(false);
            $table->timestamp('publicada_en')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};