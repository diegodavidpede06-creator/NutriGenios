@extends('layouts.app')

@section('title', 'Detalle de cita')

@section('content')

<div class="page-header">
    <div>
        <span class="eyebrow">MI ESPACIO</span>

        <h1>Detalle de cita</h1>

        <p>
            Consulta la información de tu cita nutricional.
        </p>
    </div>

    <div class="page-header-actions">
        <a href="{{ route('cliente.citas') }}" class="btn btn-secondary">
            Volver a mis citas
        </a>
    </div>
</div>


<div class="detail-grid">

    {{-- INFORMACIÓN DE LA CITA --}}
    <section class="card">

        <div class="card-header">
            <div>
                <h2>Información de la cita</h2>

                <p>
                    Datos de la consulta programada.
                </p>
            </div>
        </div>


        <div class="detail-list">

            {{-- FECHA --}}
            <div class="detail-item">

                <span class="detail-label">
                    Fecha
                </span>

                <strong class="detail-value">
                    {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                </strong>

            </div>


            {{-- HORA --}}
            <div class="detail-item">

                <span class="detail-label">
                    Hora
                </span>

                <strong class="detail-value">
                    {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                </strong>

            </div>


            {{-- NUTRIÓLOGO --}}
            <div class="detail-item">

                <span class="detail-label">
                    Nutriólogo
                </span>

                <strong class="detail-value">

                    @if($cita->nutriologo)
                        {{ $cita->nutriologo->nombre }}
                        {{ $cita->nutriologo->apellido_paterno ?? '' }}
                    @else
                        Administrador del Consultorio
                    @endif

                </strong>

            </div>


            {{-- ESTADO --}}
            <div class="detail-item">

                <span class="detail-label">
                    Estado
                </span>

                <span class="status-badge status-{{ $cita->estado }}">
                    {{ ucfirst(str_replace('_', ' ', $cita->estado)) }}
                </span>

            </div>

        </div>

    </section>


    {{-- MOTIVO --}}
    <section class="card">

        <div class="card-header">

            <div>
                <h2>Motivo de la consulta</h2>

                <p>
                    Información proporcionada al solicitar la cita.
                </p>
            </div>

        </div>


        <div class="detail-text">

            @if($cita->motivo)

                <p>
                    {{ $cita->motivo }}
                </p>

            @else

                <p class="text-muted">
                    No se indicó un motivo.
                </p>

            @endif

        </div>

    </section>


    {{-- NOTAS --}}
    <section class="card">

        <div class="card-header">

            <div>
                <h2>Notas adicionales</h2>

                <p>
                    Información adicional de la cita.
                </p>
            </div>

        </div>


        <div class="detail-text">

            @if($cita->notas)

                <p>
                    {{ $cita->notas }}
                </p>

            @else

                <p class="text-muted">
                    No hay notas adicionales.
                </p>

            @endif

        </div>

    </section>


    {{-- ACCIONES --}}
    <section class="card">

        <div class="card-header">

            <div>
                <h2>Acciones</h2>

                <p>
                    Opciones disponibles para esta cita.
                </p>
            </div>

        </div>


        <div class="action-row">

            <a
                href="{{ route('cliente.citas') }}"
                class="btn btn-secondary"
            >
                Ver todas mis citas
            </a>


            @if(in_array($cita->estado, ['pendiente', 'confirmada']))

                <form
                    action="{{ route('cliente.citas.cancelar', $cita) }}"
                    method="POST"
                    onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta cita?');"
                >

                    @csrf

                    @method('PATCH')

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Cancelar cita
                    </button>

                </form>

            @endif

        </div>

    </section>

</div>

@endsection