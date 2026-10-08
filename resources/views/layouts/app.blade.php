<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Nutriología')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')

</head>

<body>

    <div class="app-shell">

        @include('partials.sidebar')

        <div class="main-wrapper">

            @include('partials.topbar')

            <main class="main-content">

                @if(session('success'))

                    <div class="alert alert-success">

                        <div class="alert-icon">
                            ✓
                        </div>

                        <div>
                            {{ session('success') }}
                        </div>

                    </div>

                @endif


                @if(session('error'))

                    <div class="alert alert-error">

                        <div class="alert-icon">
                            !
                        </div>

                        <div>
                            {{ session('error') }}
                        </div>

                    </div>

                @endif


                @if($errors->any())

                    <div class="alert alert-error">

                        <div class="alert-icon">
                            !
                        </div>

                        <div>

                            <strong>
                                Revisa la información:
                            </strong>

                            <ul class="validation-errors">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                @endif


                @yield('content')

            </main>

        </div>

    </div>

    @stack('scripts')

</body>

</html>