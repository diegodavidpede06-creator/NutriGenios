@extends('layouts.public')

@section('title', 'Publicaciones | Nutriología')

@section('content')

<section class="public-page">

    <div class="public-page-header">

        <span class="public-eyebrow">
            Información nutricional
        </span>

        <h1>
            Publicaciones
        </h1>

        <p>
            Información y recomendaciones para ayudarte a conocer
            mejor diferentes aspectos relacionados con nutrición y bienestar.
        </p>

    </div>


    @if($publicaciones->count())

        <div class="public-publications">

            @foreach($publicaciones as $publicacion)

                <article class="public-publication">

                    @if($publicacion->imagen)

                        <img
                            src="{{ asset('storage/' . $publicacion->imagen) }}"
                            alt="{{ $publicacion->titulo }}"
                            class="public-publication-image"
                        >

                    @else

                        <div class="public-publication-placeholder">

                            <svg
                                width="40"
                                height="40"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M4 19h16"></path>
                                <path d="M5 19V5h14v14"></path>
                                <path d="M8 9h8"></path>
                                <path d="M8 13h5"></path>
                            </svg>

                        </div>

                    @endif


                    <div class="public-publication-body">

                        <h3>
                            {{ $publicacion->titulo }}
                        </h3>


                        @if($publicacion->resumen)

                            <p>
                                {{ $publicacion->resumen }}
                            </p>

                        @endif


                        <div class="public-publication-meta">

                            @if($publicacion->publicada_en)
                                {{ $publicacion->publicada_en->format('d/m/Y') }}
                            @else
                                {{ $publicacion->created_at->format('d/m/Y') }}
                            @endif

                        </div>


                        <div style="margin-top: 16px;">

                            <a
                                href="{{ route('publicaciones.mostrar', $publicacion->slug) }}"
                                class="btn btn-secondary"
                            >
                                Leer publicación
                            </a>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>


        @if($publicaciones->hasPages())

            <div style="
                margin-top: 30px;
                display: flex;
                justify-content: center;
                gap: 8px;
            ">

                @if($publicaciones->onFirstPage())

                    <span class="btn btn-secondary" style="opacity: .5;">
                        Anterior
                    </span>

                @else

                    <a
                        href="{{ $publicaciones->previousPageUrl() }}"
                        class="btn btn-secondary"
                    >
                        Anterior
                    </a>

                @endif


                @if($publicaciones->hasMorePages())

                    <a
                        href="{{ $publicaciones->nextPageUrl() }}"
                        class="btn btn-secondary"
                    >
                        Siguiente
                    </a>

                @else

                    <span class="btn btn-secondary" style="opacity: .5;">
                        Siguiente
                    </span>

                @endif

            </div>

        @endif

    @else

        <div class="public-article">

            <h2>
                Próximamente
            </h2>

            <p>
                En este espacio encontrarás publicaciones y
                recomendaciones relacionadas con nutrición y bienestar.
            </p>

        </div>

    @endif

</section>

@endsection