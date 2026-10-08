<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Nutriología')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="public-body">

    <header class="public-header">

        <div class="public-header-inner">

            <a
                href="{{ route('inicio') }}"
                class="public-brand"
            >

                <span class="public-brand-mark">
                    N
                </span>

                <span class="public-brand-text">
                    <strong>Nutriología</strong>
                    <small>CONSULTORIO</small>
                </span>

            </a>


            <nav class="public-nav">

                <a href="{{ route('inicio') }}">
                    Inicio
                </a>

                <a href="{{ route('consultorio') }}">
                    Consultorio
                </a>

                <a href="{{ route('publicaciones') }}">
                    Publicaciones
                </a>

                <a href="{{ route('contacto') }}">
                    Contacto
                </a>

            </nav>


            <div class="public-header-actions">

                @auth

                    @if(auth()->user()->esNutriologo())

                        <a
                            href="{{ route('nutriologo.dashboard') }}"
                            class="btn btn-secondary"
                        >
                            Panel
                        </a>

                    @else

                        <a
                            href="{{ route('cliente.dashboard') }}"
                            class="btn btn-secondary"
                        >
                            Mi cuenta
                        </a>

                    @endif

                @else

                    <a
                        href="{{ route('login') }}"
                        class="btn btn-secondary"
                    >
                        Iniciar sesión
                    </a>

                    <a
                        href="{{ route('registro') }}"
                        class="btn btn-primary"
                    >
                        Registrarse
                    </a>

                @endauth

            </div>

        </div>

    </header>


    <main class="public-main">

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-error">
                {{ session('error') }}
            </div>

        @endif


        @yield('content')

    </main>


    <footer class="public-footer">

        <div class="public-footer-inner">

            <div>

                <strong>
                    Nutriología
                </strong>

                <p>
                    Consultorio de nutrición.
                </p>

            </div>


            <div>

                <p>
                    Atención nutricional personalizada.
                </p>

                <p>
                    © {{ date('Y') }} Nutriología. Todos los derechos reservados.
                </p>

            </div>

        </div>

    </footer>

</body>

</html>