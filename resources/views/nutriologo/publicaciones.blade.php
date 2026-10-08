@extends('layouts.app')

@section('title', 'Publicaciones')

@section('content')

<div class="page-header">
    <div>
        <span class="eyebrow">SITIO WEB</span>
        <h1>Publicaciones</h1>
        <p>Administra el contenido informativo del consultorio.</p>
    </div>

    <div class="page-header-actions">
        <a
            href="{{ route('nutriologo.publicaciones.crear') }}"
            class="btn btn-primary"
        >
            Nueva publicación
        </a>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <div>
            <h2>Publicaciones</h2>

            <p>
                Artículos y contenido publicados en el sitio público.
            </p>
        </div>
    </div>

    @if($publicaciones->count())

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($publicaciones as $publicacion)

                        <tr>

                            <td>
                                <strong>
                                    {{ $publicacion->titulo }}
                                </strong>

                                @if($publicacion->resumen)
                                    <div class="table-description">
                                        {{ $publicacion->resumen }}
                                    </div>
                                @endif
                            </td>

                            <td>

                                @if($publicacion->publicada)

                                    <span class="status-badge status-success">
                                        Publicada
                                    </span>

                                @else

                                    <span class="status-badge status-warning">
                                        Borrador
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $publicacion->created_at
                                    ? $publicacion->created_at->format('d/m/Y')
                                    : 'Sin fecha'
                                }}
                            </td>

                            <td>

                                <div class="table-actions">

                                    <a
                                        href="{{ route('nutriologo.publicaciones.editar', $publicacion) }}"
                                        class="btn btn-small btn-secondary"
                                    >
                                        Editar
                                    </a>

                                    <form
                                        action="{{ route('nutriologo.publicaciones.destroy', $publicacion) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Deseas eliminar esta publicación?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-small btn-danger"
                                        >
                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="pagination-wrapper">
            {{ $publicaciones->links() }}
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
                    <path d="M4 4h16v16H4z"></path>
                    <path d="M8 8h8"></path>
                    <path d="M8 12h8"></path>
                    <path d="M8 16h5"></path>
                </svg>

            </div>

            <h3>No hay publicaciones</h3>

            <p>
                Todavía no has creado ninguna publicación para el sitio público.
            </p>

            <div class="empty-state-actions">

                <a
                    href="{{ route('nutriologo.publicaciones.crear') }}"
                    class="btn btn-primary"
                >
                    Crear primera publicación
                </a>

            </div>

        </div>

    @endif

</div>

@endsection