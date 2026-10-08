@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')

<div class="page-header">
    <div>
        <span class="eyebrow">CUENTA</span>
        <h1>Mi perfil</h1>
        <p>Consulta la información de tu perfil profesional.</p>
    </div>

    <div class="page-header-actions">
        <a href="{{ route('nutriologo.dashboard') }}" class="btn btn-secondary">
            Dashboard
        </a>
    </div>
</div>

<div class="profile-grid">

    <div class="card">

        <div class="card-header">
            <div>
                <h2>Información personal</h2>
                <p>Datos registrados del nutriólogo.</p>
            </div>
        </div>

        <div class="profile-content">

            <div class="profile-avatar">
                {{ strtoupper(substr($nutriologo->nombre, 0, 1)) }}
            </div>

            <div class="profile-name">
                <h2>
                    {{ $nutriologo->nombre }}
                    {{ $nutriologo->apellido_paterno }}
                    {{ $nutriologo->apellido_materno }}
                </h2>

                <p>Nutriólogo</p>
            </div>

        </div>

        <div class="profile-details">

            <div class="detail-item">
                <span class="detail-label">Correo electrónico</span>
                <span class="detail-value">
                    {{ $nutriologo->user?->email ?? 'Sin correo registrado' }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Teléfono</span>
                <span class="detail-value">
                    {{ $nutriologo->telefono ?: 'Sin teléfono registrado' }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Cédula profesional</span>
                <span class="detail-value">
                    {{ $nutriologo->cedula ?: 'Sin registrar' }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Especialidad</span>
                <span class="detail-value">
                    {{ $nutriologo->especialidad ?: 'Sin especialidad registrada' }}
                </span>
            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-header">
            <div>
                <h2>Información profesional</h2>
                <p>Descripción del profesional del consultorio.</p>
            </div>
        </div>

        <div class="profile-biography">

            @if($nutriologo->biografia)
                <p>
                    {{ $nutriologo->biografia }}
                </p>
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
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 8v4"></path>
                            <path d="M12 16h.01"></path>
                        </svg>
                    </div>

                    <h3>Sin biografía</h3>

                    <p>
                        Todavía no se ha registrado una descripción profesional.
                    </p>

                </div>
            @endif

        </div>

    </div>

</div>

@endsection