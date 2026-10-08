@extends('layouts.app')

@section('title', 'Mis citas | Nutriología')

@section('content')

<div class="page-header">

    <div>
        <span class="eyebrow">
            MI ESPACIO
        </span>

        <h1>
            Mis citas
        </h1>

        <p>
            Consulta y administra tus citas nutricionales.
        </p>
    </div>

    <div class="page-actions">

        <a
            href="{{ route('cliente.citas.crear') }}"
            class="btn btn-primary"
        >
            + Agendar cita
        </a>

    </div>

</div>


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="alert alert-error">
        {{ session('error') }}
    </div>

@endif


<div class="card">

    <div class="card-header">

        <div>
            <h2>
                Historial de citas
            </h2>

            <p>
                Aquí puedes consultar tus citas programadas.
            </p>
        </div>

    </div>


    @if($citas->count())

        <div class="table-wrapper">

            <table class="data-table">

                <thead>

                    <tr>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Hora
                        </th>

                        <th>
                            Nutriólogo
                        </th>

                        <th>
                            Motivo
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Acción
                        </th>

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

                                @if($cita->nutriologo)

                                    {{ $cita->nutriologo->nombre }}
                                    {{ $cita->nutriologo->apellido_paterno }}

                                @else

                                    Sin asignar

                                @endif

                            </td>


                            <td>

                                {{ $cita->motivo ?: 'Consulta nutricional' }}

                            </td>


                            <td>

                                @php

                                    $estado = $cita->estado;

                                    $claseEstado = match($estado) {
                                        'pendiente' => 'badge-warning',
                                        'confirmada' => 'badge-success',
                                        'atendida' => 'badge-success',
                                        'cancelada' => 'badge-danger',
                                        'no_asistio' => 'badge-danger',
                                        default => 'badge-secondary',
                                    };

                                    $textoEstado = match($estado) {
                                        'pendiente' => 'Pendiente',
                                        'confirmada' => 'Confirmada',
                                        'atendida' => 'Atendida',
                                        'cancelada' => 'Cancelada',
                                        'no_asistio' => 'No asistió',
                                        default => ucfirst($estado),
                                    };

                                @endphp


                                <span class="badge {{ $claseEstado }}">

                                    {{ $textoEstado }}

                                </span>

                            </td>


                            <td>

                                <div class="table-actions">

                                    <a
                                        href="{{ route('cliente.citas.mostrar', $cita) }}"
                                        class="btn btn-small btn-secondary"
                                    >
                                        Ver
                                    </a>


                                    @if(
                                        !in_array($cita->estado, ['cancelada', 'atendida', 'no_asistio'])
                                        && \Carbon\Carbon::parse($cita->fecha . ' ' . $cita->hora)->isFuture()
                                    )

                                        <form
                                            action="{{ route('cliente.citas.cancelar', $cita) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Deseas cancelar esta cita?');"
                                        >

                                            @csrf

                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-small btn-danger"
                                            >
                                                Cancelar
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        @if(method_exists($citas, 'links'))

            <div class="pagination-wrapper">

                {{ $citas->links() }}

            </div>

        @endif


    @else

        <div class="empty-state">

            <div class="empty-state-icon">

                <svg
                    viewBox="0 0 24 24"
                    width="56"
                    height="56"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.6"
                >

                    <rect
                        x="3"
                        y="4"
                        width="18"
                        height="17"
                        rx="2"
                    />

                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h18" />

                    <path d="M8 14h2" />
                    <path d="M14 14h2" />
                    <path d="M8 17h2" />
                    <path d="M14 17h2" />

                </svg>

            </div>


            <h3>
                No tienes citas registradas
            </h3>


            <p>
                Cuando agendes una consulta aparecerá aquí.
            </p>


            <a
                href="{{ route('cliente.citas.crear') }}"
                class="btn btn-primary"
            >
                Agendar una cita
            </a>

        </div>

    @endif

</div>

@endsection