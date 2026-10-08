@extends('layouts.public')

@section('title', 'Inicio | Nutriología')

@section('content')

<section class="public-hero">

    <div class="public-hero-content">

        <span class="public-eyebrow">
            Consultorio de nutrición
        </span>

        <h1>
            Alimentación saludable para una mejor calidad de vida
        </h1>

        <p>
            Atención nutricional personalizada para ayudarte a construir
            hábitos saludables de acuerdo con tus necesidades.
        </p>

        <div class="public-hero-actions">

            @auth
                @if(auth()->user()->esCliente())
                    <a href="{{ route('cliente.citas.crear') }}" class="btn btn-primary">
                        Agendar consulta
                    </a>
                @elseif(auth()->user()->esNutriologo())
                    <a href="{{ route('nutriologo.dashboard') }}" class="btn btn-primary">
                        Ir al panel
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    Agendar consulta
                </a>
            @endauth

            <a href="{{ route('consultorio') }}" class="btn btn-secondary">
                Conocer el consultorio
            </a>

        </div>

    </div>


    <div class="public-hero-visual">

        <div class="public-hero-panel">

            <div class="public-hero-panel-icon">
                <svg
                    width="34"
                    height="34"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M12 3v18"></path>
                    <path d="M5 8c0 3 2.2 5 5 5"></path>
                    <path d="M19 8c0 3-2.2 5-5 5"></path>
                    <path d="M5 8c0-2.2 1.2-4 3-5"></path>
                    <path d="M19 8c0-2.2-1.2-4-3-5"></path>
                </svg>
            </div>

            <span class="public-hero-panel-label">
                Atención personalizada
            </span>

            <strong>
                Tu salud,
                <br>
                tu proceso.
            </strong>

            <p>
                Acompañamiento nutricional basado en tus objetivos,
                necesidades y hábitos.
            </p>

            <div class="public-hero-panel-stats">

                <div>
                    <strong>01</strong>
                    <span>Evaluación</span>
                </div>

                <div>
                    <strong>02</strong>
                    <span>Plan nutricional</span>
                </div>

                <div>
                    <strong>03</strong>
                    <span>Seguimiento</span>
                </div>

            </div>

        </div>

    </div>

</section>


<section class="public-section">

    <div class="public-section-header">

        <span>
            Nuestro enfoque
        </span>

        <h2>
            Una atención pensada para ti
        </h2>

        <p>
            Buscamos que cada consulta sea clara, personalizada
            y enfocada en mejorar tus hábitos de manera sostenible.
        </p>

    </div>


    <div class="public-cards">

        <article class="public-card">

            <div class="public-card-icon">

                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="8" r="3"></circle>
                    <path d="M5 21a7 7 0 0 1 14 0"></path>
                </svg>

            </div>

            <h3>
                Atención personalizada
            </h3>

            <p>
                Cada persona tiene necesidades diferentes.
                Por eso trabajamos de acuerdo con tu situación
                y objetivos.
            </p>

        </article>


        <article class="public-card">

            <div class="public-card-icon">

                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M12 3v18"></path>
                    <path d="M5 8c0 3 2.2 5 5 5"></path>
                    <path d="M19 8c0 3-2.2 5-5 5"></path>
                </svg>

            </div>

            <h3>
                Planificación nutricional
            </h3>

            <p>
                Organizamos recomendaciones que puedan integrarse
                de forma práctica a tu vida cotidiana.
            </p>

        </article>


        <article class="public-card">

            <div class="public-card-icon">

                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <path d="M20 11a8.1 8.1 0 0 1-8 8 8 8 0 1 1 8-8Z"></path>
                    <path d="M20 4v5h-5"></path>
                    <path d="M20 9a8 8 0 0 0-14-3"></path>
                </svg>

            </div>

            <h3>
                Seguimiento
            </h3>

            <p>
                El proceso continúa después de la primera consulta
                mediante seguimiento y ajustes cuando sean necesarios.
            </p>

        </article>

    </div>

</section>


@if($publicaciones->count())

<section class="public-section">

    <div class="public-section-header">

        <span>
            Información nutricional
        </span>

        <h2>
            Publicaciones recientes
        </h2>

        <p>
            Consulta información y recomendaciones relacionadas
            con nutrición y bienestar.
        </p>

    </div>


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
                            width="38"
                            height="38"
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
                        {{ optional($publicacion->publicada_en)->format('d/m/Y') }}
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

</section>

@endif


<section class="public-cta">

    <div>

        <h2>
            ¿Quieres comenzar tu proceso?
        </h2>

        <p>
            Agenda una consulta y conoce cómo podemos trabajar
            juntos en tus objetivos nutricionales.
        </p>

    </div>


    @auth

        @if(auth()->user()->esCliente())

            <a
                href="{{ route('cliente.citas.crear') }}"
                class="btn btn-primary"
            >
                Agendar consulta
            </a>

        @elseif(auth()->user()->esNutriologo())

            <a
                href="{{ route('nutriologo.dashboard') }}"
                class="btn btn-primary"
            >
                Ir al panel
            </a>

        @endif

    @else

        <a
            href="{{ route('registro') }}"
            class="btn btn-primary"
        >
            Crear cuenta
        </a>

    @endauth

</section>

@endsection