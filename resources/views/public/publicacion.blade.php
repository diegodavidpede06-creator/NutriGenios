@extends('layouts.public')

@section('title', $publicacion->titulo . ' | Nutriología')

@section('content')

<section class="public-page">

    <div class="public-page-header">

        <span class="public-eyebrow">
            Información nutricional
        </span>

        <h1>
            {{ $publicacion->titulo }}
        </h1>

        <p>
            @if($publicacion->publicada_en)
                Publicado el {{ $publicacion->publicada_en->format('d/m/Y') }}
            @else
                Publicado el {{ $publicacion->created_at->format('d/m/Y') }}
            @endif
        </p>

    </div>


    <article class="public-article">

        @if($publicacion->imagen)

            <img
                src="{{ asset('storage/' . $publicacion->imagen) }}"
                alt="{{ $publicacion->titulo }}"
                style="
                    width: 100%;
                    max-height: 480px;
                    object-fit: cover;
                    border-radius: 18px;
                    margin-bottom: 28px;
                "
            >

        @endif


        @if($publicacion->resumen)

            <p style="
                font-size: 16px;
                font-weight: 600;
                margin-bottom: 22px;
            ">
                {{ $publicacion->resumen }}
            </p>

        @endif


        <div class="public-publication-content">

            {!! nl2br(e($publicacion->contenido)) !!}

        </div>


        <div style="
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid var(--color-border);
        ">

            <a
                href="{{ route('publicaciones') }}"
                class="btn btn-secondary"
            >
                Volver a publicaciones
            </a>

        </div>

    </article>

</section>

@endsection