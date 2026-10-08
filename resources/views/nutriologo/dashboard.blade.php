@extends('layouts.app')

@section('title', 'Dashboard | Nutriología')

@section('page-title', 'Dashboard')

@section('content')

<div class="page-header">

    <div class="page-header-content">

        <h2>
            Buenos días, {{ $nutriologo->nombre }}
        </h2>

        <p>
            Aquí tienes un resumen de la actividad de tu consultorio.
        </p>

    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('nutriologo.citas') }}"
            class="button button-primary"
        >
            <svg
                width="17"
                height="17"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>

            Ver citas
        </a>

    </div>

</div>


{{-- =====================================================
     ESTADÍSTICAS
===================================================== --}}

<div class="stats-grid">

    {{-- CLIENTES --}}
    <div class="stat-card">

        <div class="stat-icon">

            <svg
                width="22"
                height="22"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>

        </div>

        <div class="stat-content">

            <div class="stat-label">
                Clientes
            </div>

            <div class="stat-value">
                {{ $totalClientes }}
            </div>

        </div>

    </div>


    {{-- CITAS PENDIENTES --}}
    <div class="stat-card">

        <div class="stat-icon">

            <svg
                width="22"
                height="22"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <circle cx="12" cy="12" r="9"></circle>
                <polyline points="12 7 12 12 15 14"></polyline>
            </svg>

        </div>

        <div class="stat-content">

            <div class="stat-label">
                Pendientes
            </div>

            <div class="stat-value">
                {{ $citasPendientes }}
            </div>

        </div>

    </div>


    {{-- CITAS CONFIRMADAS --}}
    <div class="stat-card">

        <div class="stat-icon">

            <svg
                width="22"
                height="22"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <circle cx="12" cy="12" r="9"></circle>
                <polyline points="9 12 11 14 15 10"></polyline>
            </svg>

        </div>

        <div class="stat-content">

            <div class="stat-label">
                Confirmadas
            </div>

            <div class="stat-value">
                {{ $citasConfirmadas }}
            </div>

        </div>

    </div>


    {{-- CITAS DE HOY --}}
    <div class="stat-card">

        <div class="stat-icon">

            <svg
                width="22"
                height="22"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
                aria-hidden="true"
            >
                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
                <line x1="8" y1="14" x2="8" y2="14"></line>
                <line x1="12" y1="14" x2="12" y2="14"></line>
                <line x1="16" y1="14" x2="16" y2="14"></line>
            </svg>

        </div>

        <div class="stat-content">

            <div class="stat-label">
                Citas de hoy
            </div>

            <div class="stat-value">
                {{ $citasHoy->count() }}
            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     CONTENIDO PRINCIPAL
===================================================== --}}

<div class="grid grid-2">


    {{-- =================================================
         CITAS DE HOY
    ================================================== --}}

    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Citas de hoy
                </div>

                <div class="card-subtitle">
                    {{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
                </div>

            </div>

            <a
                href="{{ route('nutriologo.citas') }}"
                class="button button-secondary button-small"
            >
                Ver todas
            </a>

        </div>


        @if($citasHoy->count())

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>

                            <th>
                                Hora
                            </th>

                            <th>
                                Cliente
                            </th>

                            <th>
                                Estado
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($citasHoy as $cita)

                            <tr>

                                <td>
                                    <strong>
                                        {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                                    </strong>
                                </td>

                                <td>

                                    <a
                                        href="{{ route('nutriologo.clientes.mostrar', $cita->cliente->id) }}"
                                        style="font-weight: 600;"
                                    >
                                        {{ $cita->cliente->nombre_completo }}
                                    </a>

                                </td>

                                <td>

                                    @if($cita->estado === 'pendiente')

                                        <span class="badge badge-warning">
                                            Pendiente
                                        </span>

                                    @elseif($cita->estado === 'confirmada')

                                        <span class="badge badge-success">
                                            Confirmada
                                        </span>

                                    @elseif($cita->estado === 'atendida')

                                        <span class="badge badge-info">
                                            Atendida
                                        </span>

                                    @elseif($cita->estado === 'cancelada')

                                        <span class="badge badge-danger">
                                            Cancelada
                                        </span>

                                    @elseif($cita->estado === 'no_asistio')

                                        <span class="badge badge-danger">
                                            No asistió
                                        </span>

                                    @else

                                        <span class="badge badge-neutral">
                                            {{ ucfirst($cita->estado) }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">

                    <svg
                        width="26"
                        height="26"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>

                </div>

                <h3>
                    No hay citas para hoy
                </h3>

                <p>
                    Actualmente no tienes citas programadas para este día.
                </p>

            </div>

        @endif

    </div>


    {{-- =================================================
         PRÓXIMAS CITAS
    ================================================== --}}

    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Próximas citas
                </div>

                <div class="card-subtitle">
                    Tus siguientes consultas programadas
                </div>

            </div>

            <a
                href="{{ route('nutriologo.citas') }}"
                class="button button-secondary button-small"
            >
                Ver todas
            </a>

        </div>


        @if($proximasCitas->count())

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
                                Cliente
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($proximasCitas as $cita)

                            <tr>

                                <td>
                                    {{ $cita->fecha->format('d/m/Y') }}
                                </td>

                                <td>

                                    <strong>
                                        {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                                    </strong>

                                </td>

                                <td>

                                    <a
                                        href="{{ route('nutriologo.clientes.mostrar', $cita->cliente->id) }}"
                                        style="font-weight: 600;"
                                    >
                                        {{ $cita->cliente->nombre_completo }}
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">

                    <svg
                        width="26"
                        height="26"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <circle cx="12" cy="12" r="9"></circle>
                        <polyline points="12 7 12 12 15 14"></polyline>
                    </svg>

                </div>

                <h3>
                    No hay próximas citas
                </h3>

                <p>
                    No tienes consultas pendientes por atender.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- =====================================================
     ACCIONES RÁPIDAS
===================================================== --}}

<div class="card mt-3">

    <div class="card-header">

        <div>

            <div class="card-title">
                Acciones rápidas
            </div>

            <div class="card-subtitle">
                Accede rápidamente a las principales funciones.
            </div>

        </div>

    </div>


    <div class="card-body">

        <div class="grid grid-3">

            <a
                href="{{ route('nutriologo.clientes') }}"
                class="button button-secondary"
            >

                <svg
                    width="17"
                    height="17"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>

                Administrar clientes

            </a>


            <a
                href="{{ route('nutriologo.publicaciones.crear') }}"
                class="button button-secondary"
            >

                <svg
                    width="17"
                    height="17"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M12 20h9"></path>
                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                </svg>

                Crear publicación

            </a>


            <a
                href="{{ route('nutriologo.perfil') }}"
                class="button button-secondary"
            >

                <svg
                    width="17"
                    height="17"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M4 21a8 8 0 0 1 16 0"></path>
                </svg>

                Mi perfil

            </a>

        </div>

    </div>

</div>

@endsection