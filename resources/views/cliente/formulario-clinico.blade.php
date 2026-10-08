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


@if($cliente->formularioClinico)

    @php
        $formulario = $cliente->formularioClinico;
    @endphp


    {{-- PERFIL DEL CLIENTE --}}
    <section class="card clinical-card">

        <div class="card-header clinical-header">
            <div>
                <span class="clinical-section-label">
                    PERFIL DEL CLIENTE
                </span>

                <h2>Información del cliente</h2>

                <p>
                    Datos personales registrados en el sistema.
                </p>
            </div>
        </div>

        <div class="clinical-grid">

            <div class="clinical-data">
                <span>Nombre completo</span>

                <strong>
                    {{ $cliente->nombre }}
                    {{ $cliente->apellido_paterno }}
                    {{ $cliente->apellido_materno }}
                </strong>
            </div>

            <div class="clinical-data">
                <span>Correo electrónico</span>

                <strong>
                    {{ $cliente->user->email ?? 'No registrado' }}
                </strong>
            </div>

            <div class="clinical-data">
                <span>Teléfono</span>

                <strong>
                    {{ $cliente->telefono ?: 'No registrado' }}
                </strong>
            </div>

            <div class="clinical-data">
                <span>Fecha de nacimiento</span>

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


    {{-- DATOS PRINCIPALES --}}
    <section class="card clinical-card">

        <div class="card-header clinical-header">
            <div>
                <span class="clinical-section-label">
                    EVALUACIÓN NUTRICIONAL
                </span>

                <h2>Datos principales</h2>

                <p>
                    Información básica para la valoración nutricional.
                </p>
            </div>
        </div>

        <div class="clinical-grid clinical-grid-four">

            <div class="clinical-data">
                <span>Peso</span>

                <strong>
                    {{ $formulario->peso ? $formulario->peso . ' kg' : 'No registrado' }}
                </strong>
            </div>

            <div class="clinical-data">
                <span>Estatura</span>

                <strong>
                    {{ $formulario->estatura ? $formulario->estatura . ' cm' : 'No registrada' }}
                </strong>
            </div>

            <div class="clinical-data">
                <span>Objetivo nutricional</span>

                <strong>
                    {{ $formulario->objetivo_nutricional ?: 'No registrado' }}
                </strong>
            </div>

            <div class="clinical-data">
                <span>Actividad física</span>

                <strong>
                    {{ $formulario->actividad_fisica ?: 'No registrada' }}
                </strong>
            </div>

        </div>

    </section>


    {{-- ANTECEDENTES --}}
    <section class="card clinical-card">

        <div class="card-header clinical-header">
            <div>
                <span class="clinical-section-label">
                    HISTORIAL
                </span>

                <h2>Antecedentes médicos</h2>

                <p>
                    Información relacionada con el historial de salud del cliente.
                </p>
            </div>
        </div>

        <div class="clinical-text-box">

            <span>Antecedentes médicos</span>

            <p>
                {{ $formulario->antecedentes_medicos ?: 'No registrados.' }}
            </p>

        </div>

    </section>


    {{-- ALERGIAS Y MEDICAMENTOS --}}
    <section class="card clinical-card">

        <div class="card-header clinical-header">
            <div>
                <span class="clinical-section-label">
                    INFORMACIÓN MÉDICA
                </span>

                <h2>Alergias y medicamentos</h2>

                <p>
                    Información importante para la valoración nutricional.
                </p>
            </div>
        </div>

        <div class="clinical-grid">

            <div class="clinical-text-box">
                <span>Alergias alimentarias</span>

                <p>
                    {{ $formulario->alergias ?: 'No registradas.' }}
                </p>
            </div>

            <div class="clinical-text-box">
                <span>Medicamentos actuales</span>

                <p>
                    {{ $formulario->medicamentos ?: 'No registrados.' }}
                </p>
            </div>

        </div>

    </section>


    {{-- ANTECEDENTES DE SALUD --}}
    <section class="card clinical-card">

        <div class="card-header clinical-header">
            <div>
                <span class="clinical-section-label">
                    ANTECEDENTES
                </span>

                <h2>Antecedentes de salud</h2>

                <p>
                    Enfermedades y procedimientos médicos registrados.
                </p>
            </div>
        </div>

        <div class="clinical-grid">

            <div class="clinical-text-box">
                <span>Enfermedades</span>

                <p>
                    {{ $formulario->enfermedades ?: 'No registradas.' }}
                </p>
            </div>

            <div class="clinical-text-box">
                <span>Cirugías</span>

                <p>
                    {{ $formulario->cirugias ?: 'No registradas.' }}
                </p>
            </div>

        </div>

    </section>


    {{-- HÁBITOS --}}
    <section class="card clinical-card">

        <div class="card-header clinical-header">
            <div>
                <span class="clinical-section-label">
                    ESTILO DE VIDA
                </span>

                <h2>Hábitos y alimentación</h2>

                <p>
                    Información sobre alimentación, hidratación y descanso.
                </p>
            </div>
        </div>

        <div class="clinical-grid">

            <div class="clinical-text-box">
                <span>Alimentación actual</span>

                <p>
                    {{ $formulario->alimentacion_actual ?: 'No registrada.' }}
                </p>
            </div>

            <div class="clinical-text-box">
                <span>Consumo de agua</span>

                <p>
                    {{ $formulario->consumo_agua ?: 'No registrado.' }}
                </p>
            </div>

            <div class="clinical-text-box">
                <span>Hábitos de sueño</span>

                <p>
                    {{ $formulario->habitos_sueno ?: 'No registrados.' }}
                </p>
            </div>

        </div>

    </section>


    {{-- OBSERVACIONES --}}
    <section class="card clinical-card">

        <div class="card-header clinical-header">
            <div>
                <span class="clinical-section-label">
                    NOTAS
                </span>

                <h2>Observaciones adicionales</h2>

                <p>
                    Comentarios proporcionados por el cliente.
                </p>
            </div>
        </div>

        <div class="clinical-text-box">

            <span>Observaciones</span>

            <p>
                {{ $formulario->observaciones ?: 'No hay observaciones adicionales.' }}
            </p>

        </div>

    </section>


@else

    {{-- SIN FORMULARIO --}}
    <section class="card">

        <div class="empty-state">

            <h2>Formulario clínico no registrado</h2>

            <p>
                Este cliente todavía no ha completado su formulario clínico.
            </p>

        </div>

    </section>

@endif


<div class="page-actions">

    <a
        href="{{ route('nutriologo.clientes.mostrar', $cliente->id) }}"
        class="btn btn-secondary"
    >
        Volver al perfil del cliente
    </a>

</div>

@endsection