@extends('layouts.app')

@section('title', 'Formulario clínico')

@section('content')

<div class="page-header">
    <div>
        <span class="eyebrow">CONSULTORIO DE NUTRICIÓN</span>

        <h1>Formulario clínico</h1>

        <p>
            Información clínica registrada por el cliente.
        </p>
    </div>

    <div class="page-actions">
        <a
            href="{{ route('nutriologo.clientes.mostrar', $cliente->id) }}"
            class="btn btn-secondary"
        >
            Volver al cliente
        </a>
    </div>
</div>


{{-- =========================================================
   INFORMACIÓN DEL CLIENTE
========================================================= --}}

<section class="card clinical-card">

    <div class="card-header">
        <div>
            <span class="eyebrow">PERFIL DEL CLIENTE</span>

            <h2>Información del cliente</h2>

            <p>
                Datos personales registrados en el sistema.
            </p>
        </div>
    </div>

    <div class="data-grid clinical-data-grid">

        <div class="data-item">
            <span class="data-label">Nombre completo</span>

            <strong>
                {{ $cliente->nombre }}
                {{ $cliente->apellido_paterno }}
                {{ $cliente->apellido_materno }}
            </strong>
        </div>

        <div class="data-item">
            <span class="data-label">Correo electrónico</span>

            <strong>
                {{ $cliente->user->email ?? 'No registrado' }}
            </strong>
        </div>

        <div class="data-item">
            <span class="data-label">Teléfono</span>

            <strong>
                {{ $cliente->telefono ?: 'No registrado' }}
            </strong>
        </div>

        <div class="data-item">
            <span class="data-label">Fecha de nacimiento</span>

            <strong>
                @if($cliente->fecha_nacimiento)
                    {{ \Carbon\Carbon::parse($cliente->fecha_nacimiento)->format('d/m/Y') }}
                @else
                    No registrada
                @endif
            </strong>
        </div>

    </div>

</section>


{{-- =========================================================
   INFORMACIÓN CLÍNICA
========================================================= --}}

<section class="card clinical-card">

    <div class="card-header">
        <div>
            <span class="eyebrow">EVALUACIÓN NUTRICIONAL</span>

            <h2>Información clínica</h2>

            <p>
                Datos proporcionados por el cliente para su evaluación nutricional.
            </p>
        </div>
    </div>


    @if($cliente->formularioClinico)

        @php
            $formulario = $cliente->formularioClinico;
        @endphp


        {{-- =================================================
           DATOS PRINCIPALES
        ================================================== --}}

        <div class="clinical-section">

            <div class="clinical-section-title">
                <h3>Datos principales</h3>

                <p>
                    Información básica para la valoración nutricional.
                </p>
            </div>

            <div class="data-grid clinical-data-grid">

                <div class="data-item">
                    <span class="data-label">Peso</span>

                    <strong>
                        {{ $formulario->peso ? $formulario->peso . ' kg' : 'No registrado' }}
                    </strong>
                </div>

                <div class="data-item">
                    <span class="data-label">Estatura</span>

                    <strong>
                        {{ $formulario->estatura ? $formulario->estatura . ' cm' : 'No registrada' }}
                    </strong>
                </div>

                <div class="data-item">
                    <span class="data-label">Objetivo nutricional</span>

                    <strong>
                        {{ $formulario->objetivo_nutricional ?: 'No registrado' }}
                    </strong>
                </div>

                <div class="data-item">
                    <span class="data-label">Actividad física</span>

                    <strong>
                        {{ $formulario->actividad_fisica ?: 'No registrada' }}
                    </strong>
                </div>

            </div>

        </div>


        {{-- =================================================
           ANTECEDENTES MÉDICOS
        ================================================== --}}

        <div class="clinical-section">

            <div class="clinical-section-title">
                <h3>Antecedentes médicos</h3>
            </div>

            <div class="clinical-detail">

                <span class="data-label">
                    Antecedentes médicos
                </span>

                <p>
                    {{ $formulario->antecedentes_medicos ?: 'No registrados.' }}
                </p>

            </div>

        </div>


        {{-- =================================================
           ALERGIAS
        ================================================== --}}

        <div class="clinical-section">

            <div class="clinical-section-title">
                <h3>Alergias y medicamentos</h3>
            </div>

            <div class="clinical-detail-grid">

                <div class="clinical-detail">

                    <span class="data-label">
                        Alergias alimentarias
                    </span>

                    <p>
                        {{ $formulario->alergias ?: 'No registradas.' }}
                    </p>

                </div>

                <div class="clinical-detail">

                    <span class="data-label">
                        Medicamentos actuales
                    </span>

                    <p>
                        {{ $formulario->medicamentos ?: 'No registrados.' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
           ENFERMEDADES Y CIRUGÍAS
        ================================================== --}}

        <div class="clinical-section">

            <div class="clinical-section-title">
                <h3>Antecedentes de salud</h3>
            </div>

            <div class="clinical-detail-grid">

                <div class="clinical-detail">

                    <span class="data-label">
                        Enfermedades
                    </span>

                    <p>
                        {{ $formulario->enfermedades ?: 'No registradas.' }}
                    </p>

                </div>

                <div class="clinical-detail">

                    <span class="data-label">
                        Cirugías
                    </span>

                    <p>
                        {{ $formulario->cirugias ?: 'No registradas.' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
           ALIMENTACIÓN
        ================================================== --}}

        <div class="clinical-section">

            <div class="clinical-section-title">
                <h3>Hábitos y alimentación</h3>
            </div>

            <div class="clinical-detail-grid">

                <div class="clinical-detail">

                    <span class="data-label">
                        Alimentación actual
                    </span>

                    <p>
                        {{ $formulario->alimentacion_actual ?: 'No registrada.' }}
                    </p>

                </div>

                <div class="clinical-detail">

                    <span class="data-label">
                        Consumo de agua
                    </span>

                    <p>
                        {{ $formulario->consumo_agua ?: 'No registrado.' }}
                    </p>

                </div>

                <div class="clinical-detail">

                    <span class="data-label">
                        Hábitos de sueño
                    </span>

                    <p>
                        {{ $formulario->habitos_sueno ?: 'No registrados.' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
           OBSERVACIONES
        ================================================== --}}

        <div class="clinical-section">

            <div class="clinical-section-title">
                <h3>Observaciones adicionales</h3>
            </div>

            <div class="clinical-detail">

                <span class="data-label">
                    Observaciones
                </span>

                <p>
                    {{ $formulario->observaciones ?: 'No hay observaciones adicionales.' }}
                </p>

            </div>

        </div>


    @else

        {{-- =================================================
           FORMULARIO VACÍO
        ================================================== --}}

        <div class="empty-state">

            <h3>Formulario clínico no registrado</h3>

            <p>
                Este cliente todavía no ha completado su formulario clínico.
            </p>

        </div>

    @endif

</section>


{{-- =========================================================
   ACCIONES
========================================================= --}}

<div class="page-actions">

    <a
        href="{{ route('nutriologo.clientes.mostrar', $cliente->id) }}"
        class="btn btn-secondary"
    >
        Volver al perfil del cliente
    </a>

</div>

@endsection