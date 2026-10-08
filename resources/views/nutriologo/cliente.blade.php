@extends('layouts.app')

@section('title', 'Perfil del cliente')

@section('content')

<div class="page-header">
    <div>
        <span class="eyebrow">CONSULTORIO DE NUTRICIÓN</span>

        <h1>
            Perfil del cliente
        </h1>

        <p class="page-description">
            Consulta la información personal, clínica y las citas del cliente.
        </p>
    </div>

    <div class="page-actions">
        <a href="{{ route('nutriologo.clientes') }}" class="btn btn-secondary">
            Volver a clientes
        </a>
    </div>
</div>


<div class="content-grid">

    {{-- INFORMACIÓN PERSONAL --}}
    <section class="card">

        <div class="card-header">
            <div>
                <h2>Información personal</h2>
                <p>Datos registrados del cliente.</p>
            </div>
        </div>

        <div class="info-grid">

            <div class="info-item">
                <span>Nombre completo</span>

                <strong>
                    {{ $cliente->nombre }}
                    {{ $cliente->apellido_paterno }}
                    {{ $cliente->apellido_materno }}
                </strong>
            </div>

            <div class="info-item">
                <span>Correo electrónico</span>

                <strong>
                    {{ $cliente->user->email ?? 'No registrado' }}
                </strong>
            </div>

            <div class="info-item">
                <span>Teléfono</span>

                <strong>
                    {{ $cliente->telefono ?: 'No registrado' }}
                </strong>
            </div>

            <div class="info-item">
                <span>Fecha de nacimiento</span>

                <strong>
                    {{ $cliente->fecha_nacimiento ? \Carbon\Carbon::parse($cliente->fecha_nacimiento)->format('d/m/Y') : 'No registrada' }}
                </strong>
            </div>

            <div class="info-item">
                <span>Género</span>

                <strong>
                    {{ $cliente->genero ?: 'No registrado' }}
                </strong>
            </div>

            <div class="info-item">
                <span>Dirección</span>

                <strong>
                    {{ $cliente->direccion ?: 'No registrada' }}
                </strong>
            </div>

        </div>

    </section>


    {{-- CONTACTO DE EMERGENCIA --}}
    <section class="card">

        <div class="card-header">
            <div>
                <h2>Contacto de emergencia</h2>
                <p>Información para situaciones de emergencia.</p>
            </div>
        </div>

        <div class="info-grid">

            <div class="info-item">
                <span>Nombre</span>

                <strong>
                    {{ $cliente->contacto_emergencia_nombre ?: 'No registrado' }}
                </strong>
            </div>

            <div class="info-item">
                <span>Teléfono</span>

                <strong>
                    {{ $cliente->contacto_emergencia_telefono ?: 'No registrado' }}
                </strong>
            </div>

            <div class="info-item">
                <span>Parentesco</span>

                <strong>
                    {{ $cliente->contacto_emergencia_parentesco ?: 'No registrado' }}
                </strong>
            </div>

        </div>

    </section>


    {{-- FORMULARIO CLÍNICO --}}
    <section class="card">

        <div class="card-header">

            <div>
                <h2>Formulario clínico</h2>

                <p>
                    Información relacionada con la evaluación nutricional.
                </p>
            </div>

            @if($cliente->formularioClinico)
                <a
                    href="{{ route('nutriologo.formularios.mostrar', $cliente->id) }}"
                    class="btn btn-secondary"
                >
                    Ver formulario
                </a>
            @endif

        </div>

        @if($cliente->formularioClinico)

            <div class="info-grid">

                <div class="info-item">
                    <span>Peso</span>

                    <strong>
                        {{ $cliente->formularioClinico->peso ?? 'No registrado' }}
                        @if($cliente->formularioClinico->peso)
                            kg
                        @endif
                    </strong>
                </div>

                <div class="info-item">
                    <span>Estatura</span>

                    <strong>
                        {{ $cliente->formularioClinico->estatura ?? 'No registrada' }}
                        @if($cliente->formularioClinico->estatura)
                            cm
                        @endif
                    </strong>
                </div>

                <div class="info-item">
                    <span>Objetivo</span>

                    <strong>
                        {{ $cliente->formularioClinico->objetivo ?: 'No registrado' }}
                    </strong>
                </div>

            </div>

        @else

            <div class="empty-state">
                <p>
                    Este cliente todavía no ha completado su formulario clínico.
                </p>
            </div>

        @endif

    </section>


    {{-- CITAS --}}
    <section class="card">

        <div class="card-header">

            <div>
                <h2>Historial de citas</h2>

                <p>
                    Citas registradas para este cliente.
                </p>
            </div>

        </div>

        @if($cliente->citas->count())

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($cliente->citas as $cita)

                            <tr>

                                <td>
                                    {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                                </td>

                                <td>
                                    <span class="badge badge-{{ $cita->estado }}">
                                        {{ ucfirst($cita->estado) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $cita->motivo ?: 'Sin motivo registrado' }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <p>
                    Este cliente todavía no tiene citas registradas.
                </p>

            </div>

        @endif

    </section>

</div>

@endsection