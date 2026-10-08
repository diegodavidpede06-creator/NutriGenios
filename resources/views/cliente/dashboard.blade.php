@extends('layouts.app')

@section('title', 'Mi panel | Nutriología')

@section('content')

<div class="page-header">
    <div>
        <span class="eyebrow">MI CUENTA</span>

        <h1>
            Hola, {{ $cliente->nombre }}
        </h1>

        <p>
            Consulta tu información, tus citas y tu seguimiento nutricional.
        </p>
    </div>

    <div class="page-header-actions">
        <a href="{{ route('cliente.perfil') }}" class="btn btn-secondary">
            Mi perfil
        </a>

        <a href="{{ route('cliente.citas.crear') }}" class="btn btn-primary">
            Nueva cita
        </a>
    </div>
</div>


{{-- RESUMEN --}}
<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M20 21a8 8 0 0 0-16 0"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </div>

        <div>
            <span class="stat-label">CLIENTE</span>
            <strong>{{ $cliente->nombre }}</strong>
        </div>
    </div>


    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
        </div>

        <div>
            <span class="stat-label">MIS CITAS</span>
            <strong>{{ $cliente->citas->count() }}</strong>
        </div>
    </div>


    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 7v5l3 2"/>
            </svg>
        </div>

        <div>
            <span class="stat-label">PRÓXIMA CITA</span>

            <strong>
                @if($proximaCita)
                    {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y') }}
                @else
                    Sin cita
                @endif
            </strong>
        </div>
    </div>

</div>


{{-- PRÓXIMA CITA --}}
<div class="content-grid">

    <section class="panel">

        <div class="panel-header">
            <div>
                <h2>Próxima cita</h2>

                <p>
                    Información de tu próxima consulta.
                </p>
            </div>

            <a href="{{ route('cliente.citas') }}" class="btn btn-secondary">
                Ver citas
            </a>
        </div>


        @if($proximaCita)

            <div class="appointment-card">

                <div class="appointment-date">

                    <span>
                        {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d') }}
                    </span>

                    <small>
                        {{ \Carbon\Carbon::parse($proximaCita->fecha)->translatedFormat('M') }}
                    </small>

                </div>


                <div class="appointment-info">

                    <h3>
                        Consulta nutricional
                    </h3>

                    <p>
                        {{ $proximaCita->nutriologo->nombre }}
                        {{ $proximaCita->nutriologo->apellido_paterno }}
                    </p>

                    <div class="appointment-meta">

                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>

                            {{ \Carbon\Carbon::parse($proximaCita->hora)->format('H:i') }}
                        </span>

                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                <circle cx="12" cy="10" r="2.5"/>
                            </svg>

                            Consultorio
                        </span>

                    </div>

                </div>


                <div class="appointment-status">

                    <span class="badge badge-{{ $proximaCita->estado }}">
                        {{ ucfirst($proximaCita->estado) }}
                    </span>

                </div>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                </div>

                <h3>No tienes citas próximas</h3>

                <p>
                    Puedes reservar una nueva consulta desde el botón de abajo.
                </p>

                <a href="{{ route('cliente.citas.crear') }}" class="btn btn-primary">
                    Agendar una cita
                </a>

            </div>

        @endif

    </section>


    {{-- FORMULARIO CLÍNICO --}}
    <section class="panel">

        <div class="panel-header">

            <div>
                <h2>Formulario clínico</h2>

                <p>
                    Información de tu evaluación nutricional.
                </p>
            </div>

        </div>


        @if($cliente->formularioClinico)

            <div class="clinical-summary">

                <div class="clinical-item">
                    <span>Peso</span>

                    <strong>
                        {{ $cliente->formularioClinico->peso ?? 'No registrado' }}

                        @if($cliente->formularioClinico->peso)
                            kg
                        @endif
                    </strong>
                </div>


                <div class="clinical-item">
                    <span>Altura</span>

                    <strong>
                        {{ $cliente->formularioClinico->altura ?? 'No registrada' }}

                        @if($cliente->formularioClinico->altura)
                            cm
                        @endif
                    </strong>
                </div>


                <div class="clinical-item">
                    <span>Actividad física</span>

                    <strong>
                        {{ $cliente->formularioClinico->actividad_fisica ?? 'No registrada' }}
                    </strong>
                </div>

            </div>


            <div class="panel-actions">

                <a
                    href="{{ route('cliente.formulario.editar') }}"
                    class="btn btn-secondary"
                >
                    Editar formulario
                </a>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M6 3h12v18H6z"/>
                        <path d="M9 7h6M9 11h6M9 15h4"/>
                    </svg>
                </div>

                <h3>Formulario pendiente</h3>

                <p>
                    Todavía no has completado tu formulario clínico.
                </p>

                <a
                    href="{{ route('cliente.formulario.crear') }}"
                    class="btn btn-primary"
                >
                    Completar formulario
                </a>

            </div>

        @endif

    </section>

</div>


{{-- HISTORIAL --}}
<section class="panel">

    <div class="panel-header">

        <div>
            <h2>Mis últimas citas</h2>

            <p>
                Historial de tus consultas nutricionales.
            </p>
        </div>

        <a href="{{ route('cliente.citas') }}" class="btn btn-secondary">
            Ver historial
        </a>

    </div>


    @if($cliente->citas->count())

        <div class="table-wrapper">

            <table class="data-table">

                <thead>

                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Nutriólogo</th>
                        <th>Estado</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($cliente->citas->sortByDesc('fecha')->take(5) as $cita)

                        <tr>

                            <td>
                                {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                            </td>

                            <td>
                                {{ $cita->nutriologo->nombre }}
                                {{ $cita->nutriologo->apellido_paterno }}
                            </td>

                            <td>

                                <span class="badge badge-{{ $cita->estado }}">
                                    {{ ucfirst($cita->estado) }}
                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M8 12h8M12 8v8"/>
                </svg>

            </div>

            <h3>No tienes citas registradas</h3>

            <p>
                Cuando agendes una consulta aparecerá aquí.
            </p>

        </div>

    @endif

</section>

@endsection