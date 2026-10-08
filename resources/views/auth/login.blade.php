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

    <title>Iniciar sesión | Nutriología</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body>

    <div class="auth-page">

        <div class="auth-container">

            <div class="auth-card">

                {{-- LOGOTIPO --}}

                <div class="auth-logo">
                    N
                </div>


                {{-- ENCABEZADO --}}

                <div class="auth-header">

                    <h1>
                        Bienvenido
                    </h1>

                    <p>
                        Ingresa a tu cuenta para continuar.
                    </p>

                </div>


                {{-- MENSAJE DE ERROR GENERAL --}}

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


                {{-- ERRORES DE VALIDACIÓN --}}

                @if($errors->any())

                    <div class="alert alert-error">

                        <div class="alert-icon">
                            !
                        </div>

                        <div>

                            <strong>
                                Revisa la información.
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


                {{-- FORMULARIO --}}

                <form
                    action="{{ route('login.store') }}"
                    method="POST"
                    class="auth-form"
                >

                    @csrf


                    {{-- CORREO --}}

                    <div class="form-group">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Correo electrónico
                            <span>*</span>
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            value="{{ old('email') }}"
                            placeholder="correo@ejemplo.com"
                            autocomplete="email"
                            required
                        >

                    </div>


                    {{-- CONTRASEÑA --}}

                    <div class="form-group">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Contraseña
                            <span>*</span>
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Ingresa tu contraseña"
                            autocomplete="current-password"
                            required
                        >

                    </div>


                    {{-- BOTÓN --}}

                    <button
                        type="submit"
                        class="button button-primary w-full"
                    >
                        Iniciar sesión
                    </button>

                </form>


                {{-- REGISTRO --}}

                <div class="auth-footer">

                    <span>
                        ¿Todavía no tienes una cuenta?
                    </span>

                    <a href="{{ route('registro') }}">
                        Crear cuenta
                    </a>

                </div>


                {{-- SITIO PÚBLICO --}}

                <div
                    style="
                        margin-top: 12px;
                        text-align: center;
                        font-size: 12px;
                        color: var(--color-text-muted);
                    "
                >

                    <a href="{{ route('inicio') }}">
                        Volver al sitio
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>
</html>