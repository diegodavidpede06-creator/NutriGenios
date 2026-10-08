<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formularios_clinicos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')
                ->unique()
                ->constrained('clientes')
                ->cascadeOnDelete();

            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('estatura', 5, 2)->nullable();

            $table->text('objetivo_nutricional')->nullable();
            $table->text('antecedentes_medicos')->nullable();
            $table->text('alergias')->nullable();
            $table->text('medicamentos')->nullable();

            $table->text('enfermedades')->nullable();
            $table->text('cirugias')->nullable();

            $table->text('alimentacion_actual')->nullable();
            $table->text('actividad_fisica')->nullable();

            $table->text('consumo_agua')->nullable();
            $table->text('habitos_sueno')->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formularios_clinicos');
    }
};