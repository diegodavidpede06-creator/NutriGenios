@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

<div class="page-header">
    <div>
        <span class="eyebrow">CONSULTORIO DE NUTRICIÓN</span>
        <h1>Clientes</h1>
        <p>Consulta y administra la información de tus pacientes.</p>
    </div>

    <div class="page-header-actions">
        <a href="{{ route('nutriologo.dashboard') }}" class="btn btn-secondary">
            Dashboard
        </a>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <div>
            <h2>Lista de clientes</h2>
            <p>
                Clientes registrados en el consultorio.
            </p>
        </div>
    </div>

    @if($clientes->count())

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Fecha de nacimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($clientes as $cliente)

                        <tr>

                            <td>
                                <strong>
                                    {{ $cliente->nombre }}
                                    {{ $cliente->apellido_paterno }}
                                    {{ $cliente->apellido_materno }}
                                </strong>
                            </td>

                            <td>
                                {{ $cliente->user?->email ?? 'Sin correo' }}
                            </td>

                            <td>
                                {{ $cliente->telefono ?: 'Sin teléfono' }}
                            </td>

                            <td>
                                @if($cliente->fecha_nacimiento)
                                    {{ \Carbon\Carbon::parse($cliente->fecha_nacimiento)->format('d/m/Y') }}
                                @else
                                    Sin registrar
                                @endif
                            </td>

                            <td>
                                <a
                                    href="{{ route('nutriologo.clientes.mostrar', $cliente) }}"
                                    class="btn btn-small btn-secondary"
                                >
                                    Ver perfil
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="pagination-wrapper">
            {{ $clientes->links() }}
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
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>

            </div>

            <h3>No hay clientes registrados</h3>

            <p>
                Actualmente no existen pacientes registrados en el sistema.
            </p>

        </div>

    @endif

</div>

@endsection