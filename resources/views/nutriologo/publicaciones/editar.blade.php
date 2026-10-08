@extends('layouts.app')

@section('title', 'Editar publicación')

@section('content')

<div class="page-header">

    <div>
        <span class="eyebrow">SITIO WEB</span>
        <h1>Editar publicación</h1>
        <p>Modifica la información de la publicación.</p>
    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('nutriologo.publicaciones') }}"
            class="btn btn-secondary"
        >
            Volver a publicaciones
        </a>

    </div>

</div>

<div class="card">

    <div class="card-header">

        <div>
            <h2>Información de la publicación</h2>

            <p>
                Actualiza los datos y guarda los cambios.
            </p>
        </div>

    </div>

    <form
        action="{{ route('nutriologo.publicaciones.update', $publicacion) }}"
        method="POST"
        enctype="multipart/form-data"
        class="form-content"
    >

        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group form-group-full">

                <label for="titulo">
                    Título
                </label>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    value="{{ old('titulo', $publicacion->titulo) }}"
                    required
                >

                @error('titulo')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group form-group-full">

                <label for="resumen">
                    Resumen
                </label>

                <textarea
                    id="resumen"
                    name="resumen"
                    rows="4"
                >{{ old('resumen', $publicacion->resumen) }}</textarea>

                @error('resumen')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group form-group-full">

                <label for="contenido">
                    Contenido
                </label>

                <textarea
                    id="contenido"
                    name="contenido"
                    rows="10"
                    required
                >{{ old('contenido', $publicacion->contenido) }}</textarea>

                @error('contenido')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group">

                <label for="imagen">
                    Imagen
                </label>

                <input
                    type="file"
                    id="imagen"
                    name="imagen"
                    accept="image/*"
                >

                @if($publicacion->imagen)

                    <span class="form-help">
                        Esta publicación ya tiene una imagen.
                    </span>

                @else

                    <span class="form-help">
                        No hay una imagen registrada.
                    </span>

                @endif

                @error('imagen')
                    <span class="form-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            <div class="form-group">

                <label class="checkbox-field">

                    <input
                        type="checkbox"
                        name="publicada"
                        value="1"
                        {{ old('publicada', $publicacion->publicada) ? 'checked' : '' }}
                    >

                    <span>
                        Publicación publicada
                    </span>

                </label>

                <span class="form-help">
                    Activa esta opción para mostrar la publicación en el sitio público.
                </span>

            </div>

        </div>

        <div class="form-actions">

            <a
                href="{{ route('nutriologo.publicaciones') }}"
                class="btn btn-secondary"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar cambios
            </button>

        </div>

    </form>

</div>

@endsection
