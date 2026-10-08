@extends('layouts.app')

@section('title', 'Citas')

@section('content')

<div class="page-header">
    <div>
        <span class="eyebrow">CONSULTORIO DE NUTRICIÓN</span>

        <h1>Citas</h1>

        <p>
            Administra y consulta las citas de tus pacientes.
        </p>
    </div>

    <div class="page-header-actions">
        <a
            href="{{ route('nutriologo.dashboard') }}"
            class="btn btn-secondary"
        >
            Dashboard
        </a>
    </div>
</div>


<div class="card">

    <div class="card-header">

        <div>
            <h2>Agenda de citas</h2>

            <p>
                Consulta las citas programadas y su estado.
            </p>
        </div>

    </div>


    @if($citas->count())

        <div class="table-wrapper">

            <table class="data-table">

                <thead>

                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Estado</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>

                </thead>


                <tbody>

                    @foreach($citas as $cita)

                        <tr>

                            <td>
                                {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                            </td>


                            <td>
                                {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                            </td>


                            <td>

                                @if($cita->cliente)

                                    <strong>
                                        {{ $cita->cliente->nombre }}
                                        {{ $cita->cliente->apellido_paterno }}
                                    </strong>

                                @else

                                    <span>
                                        Paciente no disponible
                                    </span>

                                @endif

                            </td>


                            <td>

                                @php

                                    $estado = $cita->estado;

                                    $claseEstado = match($estado) {

                                        'pendiente' =>
                                            'status-warning',

                                        'confirmada' =>
                                            'status-success',

                                        'cancelada' =>
                                            'status-danger',

                                        'atendida' =>
                                            'status-success',

                                        'no_asistio' =>
                                            'status-danger',

                                        default =>
                                            'status-neutral',

                                    };


                                    $textoEstado = match($estado) {

                                        'pendiente' =>
                                            'Pendiente',

                                        'confirmada' =>
                                            'Confirmada',

                                        'cancelada' =>
                                            'Cancelada',

                                        'atendida' =>
                                            'Atendida',

                                        'no_asistio' =>
                                            'No asistió',

                                        default =>
                                            ucfirst($estado),

                                    };

                                @endphp


                                <span
                                    class="status-badge {{ $claseEstado }}"
                                >
                                    {{ $textoEstado }}
                                </span>

                            </td>


                            <td>

                                {{ $cita->motivo ?: 'Sin motivo registrado' }}

                            </td>


                            <td>

                                <a
                                    href="{{ route('nutriologo.citas.mostrar', $cita) }}"
                                    class="btn btn-small btn-secondary"
                                >
                                    Ver
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        <div class="pagination-wrapper">

            {{ $citas->links() }}

        </div>


    @else

        <div class="empty-state">

            <div class="empty-state-icon">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    width="34"
                    height="34"
                >

                    <rect
                        x="3"
                        y="4"
                        width="18"
                        height="17"
                        rx="2"
                    ></rect>

                    <path d="M16 2v4"></path>

                    <path d="M8 2v4"></path>

                    <path d="M3 10h18"></path>

                    <path d="M8 14h2"></path>

                    <path d="M14 14h2"></path>

                </svg>

            </div>


            <h3>
                No hay citas registradas
            </h3>


            <p>
                Actualmente no tienes citas programadas.
            </p>

        </div>

    @endif

</div>

@endsection