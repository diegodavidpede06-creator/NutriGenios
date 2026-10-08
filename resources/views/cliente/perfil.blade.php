@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')

<div class="page-header">

    <div>
        <span class="eyebrow">MI CUENTA</span>

        <h1>Mi perfil</h1>

        <p>
            Consulta y actualiza tu información personal.
        </p>
    </div>

</div>


@if ($errors->any())

    <div class="alert alert-error">

        <strong>
            Revisa los siguientes datos:
        </strong>

        <ul style="margin: 10px 0 0 20px;">

            @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


@if (session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


<div class="card">

    <div class="card-header">

        <div>

            <span class="eyebrow">
                INFORMACIÓN PERSONAL
            </span>

            <h2>Datos del cliente</h2>

            <p>
                Mantén actualizada tu información de contacto.
            </p>

        </div>

    </div>


    <form
        action="{{ route('cliente.perfil.actualizar') }}"
        method="POST"
        class="form-grid"
        id="formPerfil"
    >

        @csrf

        @method('PUT')


        {{-- NOMBRE --}}

        <div class="form-group">

            <label for="nombre">
                Nombre
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre', $cliente->nombre) }}"
                maxlength="100"
                required
            >

        </div>


        {{-- APELLIDO PATERNO --}}

        <div class="form-group">

            <label for="apellido_paterno">
                Apellido paterno
            </label>

            <input
                type="text"
                id="apellido_paterno"
                name="apellido_paterno"
                value="{{ old('apellido_paterno', $cliente->apellido_paterno) }}"
                maxlength="100"
                required
            >

        </div>


        {{-- APELLIDO MATERNO --}}

        <div class="form-group">

            <label for="apellido_materno">
                Apellido materno
            </label>

            <input
                type="text"
                id="apellido_materno"
                name="apellido_materno"
                value="{{ old('apellido_materno', $cliente->apellido_materno) }}"
                maxlength="100"
            >

        </div>


        {{-- FECHA DE NACIMIENTO --}}

        <div class="form-group">

            <label for="fecha_nacimiento">
                Fecha de nacimiento
            </label>

            <input
                type="date"
                id="fecha_nacimiento"
                name="fecha_nacimiento"
                value="{{ old('fecha_nacimiento', optional($cliente->fecha_nacimiento)->format('Y-m-d')) }}"
            >

        </div>


        {{-- TELÉFONO DEL CLIENTE --}}

        <div class="form-group">

            <label for="telefono">
                Teléfono
            </label>

            <input
                type="text"
                id="telefono"
                name="telefono"
                value="{{ old('telefono', $cliente->telefono) }}"
                maxlength="10"
                minlength="10"
                inputmode="numeric"
                pattern="[0-9]{10}"
                placeholder="Ej. 5512345678"
                autocomplete="tel"
            >

            <small>
                Ingresa exactamente 10 dígitos.
            </small>

        </div>


        {{-- GÉNERO --}}

        <div class="form-group">

            <label for="genero">
                Género
            </label>

            <select
                id="genero"
                name="genero"
            >

                <option value="">
                    Seleccionar
                </option>

                <option
                    value="masculino"
                    @selected(old('genero', $cliente->genero) === 'masculino')
                >
                    Masculino
                </option>

                <option
                    value="femenino"
                    @selected(old('genero', $cliente->genero) === 'femenino')
                >
                    Femenino
                </option>

                <option
                    value="otro"
                    @selected(old('genero', $cliente->genero) === 'otro')
                >
                    Otro
                </option>

            </select>

        </div>


        {{-- DIRECCIÓN --}}

        <div class="form-group form-group-full">

            <label for="direccion">
                Dirección
            </label>

            <textarea
                id="direccion"
                name="direccion"
                rows="3"
                maxlength="500"
            >{{ old('direccion', $cliente->direccion) }}</textarea>

        </div>


        {{-- NOMBRE DEL CONTACTO DE EMERGENCIA --}}

        <div class="form-group">

            <label for="contacto_emergencia_nombre">
                Nombre del contacto de emergencia
            </label>

            <input
                type="text"
                id="contacto_emergencia_nombre"
                name="contacto_emergencia_nombre"
                value="{{ old('contacto_emergencia_nombre', $cliente->contacto_emergencia_nombre) }}"
                maxlength="100"
                placeholder="Ej. María López"
            >

        </div>


        {{-- TELÉFONO DEL CONTACTO DE EMERGENCIA --}}

        <div class="form-group">

            <label for="contacto_emergencia_telefono">
                Teléfono de emergencia
            </label>

            <input
                type="text"
                id="contacto_emergencia_telefono"
                name="contacto_emergencia_telefono"
                value="{{ old('contacto_emergencia_telefono', $cliente->contacto_emergencia_telefono) }}"
                maxlength="10"
                minlength="10"
                inputmode="numeric"
                pattern="[0-9]{10}"
                placeholder="Ej. 5512345678"
                autocomplete="tel"
            >

            <small>
                Ingresa exactamente 10 dígitos.
            </small>

        </div>


        {{-- BOTONES --}}

        <div class="form-actions form-group-full">

            <a
                href="{{ route('cliente.dashboard') }}"
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


<script>

document.addEventListener('DOMContentLoaded', function () {

    const telefono =
        document.getElementById('telefono');

    const telefonoEmergencia =
        document.getElementById('contacto_emergencia_telefono');

    const formulario =
        document.getElementById('formPerfil');


    /*
    |--------------------------------------------------------------------------
    | Limitar campos telefónicos
    |--------------------------------------------------------------------------
    */

    function limitarTelefono(input) {

        if (!input) {
            return;
        }

        input.addEventListener('input', function () {

            this.value = this.value
                .replace(/\D/g, '')
                .slice(0, 10);

        });

        input.addEventListener('keypress', function (event) {

            if (!/[0-9]/.test(event.key)) {
                event.preventDefault();
            }

        });

        input.addEventListener('paste', function () {

            setTimeout(() => {

                this.value = this.value
                    .replace(/\D/g, '')
                    .slice(0, 10);

            }, 0);

        });

    }


    limitarTelefono(telefono);

    limitarTelefono(telefonoEmergencia);


    /*
    |--------------------------------------------------------------------------
    | Validación antes de guardar
    |--------------------------------------------------------------------------
    */

    formulario.addEventListener('submit', function (event) {

        const telefonoValor =
            telefono.value.trim();

        const telefonoEmergenciaValor =
            telefonoEmergencia.value.trim();


        /*
        |--------------------------------------------------------------------------
        | Validar teléfono del cliente
        |--------------------------------------------------------------------------
        */

        if (
            telefonoValor !== '' &&
            !/^\d{10}$/.test(telefonoValor)
        ) {

            event.preventDefault();

            alert(
                'El teléfono debe contener exactamente 10 dígitos.'
            );

            telefono.focus();

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Validar teléfono de emergencia
        |--------------------------------------------------------------------------
        */

        if (
            telefonoEmergenciaValor !== '' &&
            !/^\d{10}$/.test(telefonoEmergenciaValor)
        ) {

            event.preventDefault();

            alert(
                'El teléfono de emergencia debe contener exactamente 10 dígitos.'
            );

            telefonoEmergencia.focus();

            return;
        }

    });

});

</script>

@endsection