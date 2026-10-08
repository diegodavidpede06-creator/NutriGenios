@extends('layouts.public')

@section('title', 'Consultorio | Nutriología')

@section('content')

<section class="public-page">

    <div class="public-page-header">

        <span class="public-eyebrow">
            Nuestro consultorio
        </span>

        <h1>
            Un espacio pensado para tu bienestar
        </h1>

        <p>
            Conoce nuestro enfoque de atención nutricional y la forma
            en que trabajamos para acompañarte durante tu proceso.
        </p>

    </div>


    <div class="public-cards">

        <article class="public-card">

            <div class="public-card-icon">

                <svg
                    width="26"
                    height="26"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M3 21h18"></path>
                    <path d="M5 21V8l7-5 7 5v13"></path>
                    <path d="M9 21v-6h6v6"></path>
                    <path d="M9 10h6"></path>
                </svg>

            </div>

            <h3>
                Atención profesional
            </h3>

            <p>
                Recibe orientación nutricional personalizada en un
                espacio dedicado a conocer tus necesidades y objetivos.
            </p>

        </article>


        <article class="public-card">

            <div class="public-card-icon">

                <svg
                    width="26"
                    height="26"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="12" cy="12" r="9"></circle>
                    <path d="M12 7v5l3 2"></path>
                </svg>

            </div>

            <h3>
                Horarios de atención
            </h3>

            <p>
                Las consultas se realizan de lunes a viernes,
                con horarios disponibles de 08:00 a 16:00 horas.
            </p>

        </article>


        <article class="public-card">

            <div class="public-card-icon">

                <svg
                    width="26"
                    height="26"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M12 3a9 9 0 1 0 9 9"></path>
                    <path d="M12 7v5l3 2"></path>
                    <path d="M16 3h5v5"></path>
                    <path d="M21 3l-5 5"></path>
                </svg>

            </div>

            <h3>
                Seguimiento
            </h3>

            <p>
                El proceso incluye seguimiento para revisar avances
                y realizar ajustes cuando sean necesarios.
            </p>

        </article>

    </div>


    <div class="public-article" style="margin-top: 25px;">

        <h2>
            Nuestro enfoque
        </h2>

        <p>
            Creemos que la nutrición debe adaptarse a cada persona.
            Por eso buscamos conocer tus hábitos, necesidades y
            objetivos antes de establecer recomendaciones.
        </p>

        <p>
            El objetivo es construir cambios que puedan mantenerse
            en el tiempo y que formen parte de tu vida cotidiana.
        </p>


        <h3>
            ¿Cómo funciona una consulta?
        </h3>

        <p>
            Durante la consulta se recopila información relevante
            sobre tu alimentación, antecedentes y objetivos.
            Con esta información se establece una orientación
            nutricional adecuada para tu proceso.
        </p>


        <h3>
            Agenda tu consulta
        </h3>

        <p>
            Para reservar una cita es necesario contar con una cuenta
            de cliente. Desde tu panel podrás consultar los horarios
            disponibles y seleccionar el que mejor se adapte a ti.
        </p>


        <div style="margin-top: 24px;">

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

        </div>

    </div>

</section>

@endsection