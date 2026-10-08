@extends('layouts.public')

@section('title', 'Contacto | Nutriología')

@section('content')

<section class="public-page">

    <div class="public-page-header">

        <span class="public-eyebrow">
            Contacto
        </span>

        <h1>
            Estamos para ayudarte
        </h1>

        <p>
            Si deseas conocer más sobre nuestros servicios o comenzar
            tu proceso nutricional, puedes ponerte en contacto con el
            consultorio.
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
                    aria-hidden="true"
                >
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                        19.79 19.79 0 0 1-8.63-3.07
                        19.5 19.5 0 0 1-6-6
                        19.79 19.79 0 0 1-3.07-8.67
                        A2 2 0 0 1 4.11 2h3
                        a2 2 0 0 1 2 1.72
                        12.84 12.84 0 0 0 .7 2.81
                        2 2 0 0 1-.45 2.11L8.09 9.91
                        a16 16 0 0 0 6 6l1.27-1.27
                        a2 2 0 0 1 2.11-.45
                        12.84 12.84 0 0 0 2.81.7
                        A2 2 0 0 1 22 16.92z">
                    </path>
                </svg>

            </div>

            <h3>
                Teléfono
            </h3>

            <p>
                Ponte en contacto con el consultorio para conocer
                disponibilidad y resolver tus dudas.
            </p>

            <strong>
                Próximamente
            </strong>

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
                    aria-hidden="true"
                >
                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                    <polyline points="3 7 12 13 21 7"></polyline>
                </svg>

            </div>

            <h3>
                Correo electrónico
            </h3>

            <p>
                Puedes utilizar este medio para realizar consultas
                relacionadas con el servicio.
            </p>

            <strong>
                Próximamente
            </strong>

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
                    aria-hidden="true"
                >
                    <path d="M20 10c0 5-8 11-8 11S4 15 4 10
                        a8 8 0 1 1 16 0z">
                    </path>
                    <circle cx="12" cy="10" r="2.5"></circle>
                </svg>

            </div>

            <h3>
                Consultorio
            </h3>

            <p>
                Conoce nuestro espacio de atención y recibe
                orientación nutricional personalizada.
            </p>

            <a
                href="{{ route('consultorio') }}"
                class="btn btn-secondary"
                style="margin-top: 10px;"
            >
                Conocer el consultorio
            </a>

        </article>

    </div>


    <div class="public-article" style="margin-top: 25px;">

        <h2>
            Agenda tu consulta
        </h2>

        <p>
            Para reservar una cita necesitas crear una cuenta de
            cliente. Una vez registrado podrás acceder a tu panel,
            consultar los horarios disponibles y seleccionar una
            fecha para tu consulta.
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