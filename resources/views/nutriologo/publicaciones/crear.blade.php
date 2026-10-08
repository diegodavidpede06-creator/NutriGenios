@extends('layouts.app')

@section('title', 'Nueva publicación')

@section('content')

<div class="page-header">
    <div>
        <span class="eyebrow">SITIO WEB</span>
        <h1>Nueva publicación</h1>
        <p>Crea contenido informativo para el sitio público.</p>
    </div>

    <div class="page-header-actions">
        <a href="{{ route('nutriologo.publicaciones') }}" class="btn btn-secondary">
            Volver a publicaciones
        </a>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <div>
            <h2>Información de la publicación</h2>
            <p>
                Completa los datos que se mostrarán en el sitio público.
            </p>
        </div>
    </div>

    <form
        action="{{ route('nutriologo.publicaciones.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="form-content"
    >

        @csrf

        <div class="form-grid">

            <div class="form-group form-group-full">
                <label for="titulo">Título</label>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    value="{{ old('titulo') }}"
                    placeholder="Ej. Alimentación saludable en la vida diaria"
                    required
                >

                @error('titulo')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-group-full">
                <label for="resumen">Resumen</label>

                <textarea
                    id="resumen"
                    name="resumen"
                    rows="3"
                    placeholder="Escribe una breve descripción de la publicación..."
                >{{ old('resumen') }}</textarea>

                @error('resumen')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-group-full">
                <label for="contenido">Contenido</label>

                <textarea
                    id="contenido"
                    name="contenido"
                    rows="10"
                    placeholder="Escribe aquí el contenido completo de la publicación..."
                    required
                >{{ old('contenido') }}</textarea>

                @error('contenido')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="imagen">Imagen</label>

                <input
                    type="file"
                    id="imagen"
                    name="imagen"
                    accept="image/*"
                >

                <span class="form-help">
                    Puedes seleccionar una imagen para la publicación.
                </span>

                @error('imagen')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">

                <label class="checkbox-field">

                    <input
                        type="checkbox"
                        name="publicada"
                        value="1"
                        {{ old('publicada') ? 'checked' : '' }}
                    >

                    <span>Publicar inmediatamente</span>

                </label>

                <span class="form-help">
                    Si no se marca, la publicación quedará como borrador.
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
                Guardar publicación
            </button>

        </div>

    </form>

</div>

@endsection
