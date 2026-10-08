@extends('layouts.app')

@section('title', 'Agendar cita')

@section('content')

<div class="page-header">

    <div>
        <span class="eyebrow">MI ESPACIO</span>

        <h1>Agendar cita</h1>

        <p>
            Selecciona el día y horario para tu consulta nutricional.
        </p>
    </div>

    <a
        href="{{ route('cliente.citas') }}"
        class="btn btn-secondary"
    >
        Ver mis citas
    </a>

</div>


<div class="card">

    <div class="card-header">

        <div>

            <h2>Nueva cita</h2>

            <p>
                Completa los datos para solicitar tu consulta.
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


    <form
        action="{{ route('cliente.citas.store') }}"
        method="POST"
        class="form-grid"
        id="formCita"
    >

        @csrf


        {{-- FECHA --}}

        <div class="form-group">

            <label for="fecha">
                Fecha de la cita
            </label>

            <input
                type="date"
                id="fecha"
                name="fecha"
                value="{{ old('fecha') }}"
                min="{{ now()->toDateString() }}"
                required
            >

            <small>
                El consultorio atiende de lunes a viernes.
            </small>

        </div>


        {{-- HORA --}}

        <div class="form-group">

            <label for="hora">
                Horario
            </label>

            <select
                id="hora"
                name="hora"
                required
                disabled
            >

                <option value="">
                    Selecciona primero una fecha
                </option>

            </select>

            <small id="mensajeDisponibilidad">
                Los horarios disponibles aparecerán aquí.
            </small>

        </div>


        {{-- MOTIVO --}}

        <div class="form-group form-group-full">

            <label for="motivo">
                Motivo de la consulta
            </label>

            <textarea
                id="motivo"
                name="motivo"
                rows="4"
                maxlength="1000"
                placeholder="Escribe brevemente el motivo de tu consulta..."
            >{{ old('motivo') }}</textarea>

        </div>


        {{-- ACCIONES --}}

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
                id="btnGuardar"
                disabled
            >
                Solicitar cita
            </button>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const fecha = document.getElementById('fecha');
    const hora = document.getElementById('hora');
    const mensaje = document.getElementById('mensajeDisponibilidad');
    const btnGuardar = document.getElementById('btnGuardar');

    const horaAnterior = @json(old('hora'));


    function resetearHorario(mensajeTexto = 'Los horarios disponibles aparecerán aquí.') {

        hora.innerHTML = '';

        const opcion = document.createElement('option');

        opcion.value = '';
        opcion.textContent = 'Selecciona una fecha';

        hora.appendChild(opcion);

        hora.disabled = true;

        btnGuardar.disabled = true;

        mensaje.textContent = mensajeTexto;
    }


    function cargarHorarios(fechaSeleccionada) {

        hora.innerHTML = '';

        const cargando = document.createElement('option');

        cargando.value = '';
        cargando.textContent = 'Cargando horarios...';

        hora.appendChild(cargando);

        hora.disabled = true;

        btnGuardar.disabled = true;

        mensaje.textContent =
            'Consultando disponibilidad...';


        fetch(
            "{{ route('cliente.citas.disponibilidad') }}?fecha="
            + encodeURIComponent(fechaSeleccionada),
            {
                method: 'GET',

                headers: {
                    'Accept': 'application/json'
                }
            }
        )
        .then(response => {

            if (!response.ok) {

                throw new Error(
                    'No se pudo consultar la disponibilidad.'
                );

            }

            return response.json();

        })
        .then(data => {

            hora.innerHTML = '';

            if (data.disponible === false) {

                const opcion = document.createElement('option');

                opcion.value = '';
                opcion.textContent =
                    data.mensaje || 'No hay disponibilidad.';

                hora.appendChild(opcion);

                hora.disabled = true;

                btnGuardar.disabled = true;

                mensaje.textContent =
                    data.mensaje || 'No hay disponibilidad.';

                return;
            }


            const horarios = Array.isArray(data.horarios)
                ? data.horarios
                : [];


            if (horarios.length === 0) {

                const opcion = document.createElement('option');

                opcion.value = '';
                opcion.textContent =
                    'No hay horarios disponibles';

                hora.appendChild(opcion);

                hora.disabled = true;

                btnGuardar.disabled = true;

                mensaje.textContent =
                    'No hay horarios disponibles para esta fecha.';

                return;
            }


            const opcionInicial =
                document.createElement('option');

            opcionInicial.value = '';
            opcionInicial.textContent =
                'Selecciona un horario';

            hora.appendChild(opcionInicial);


            let disponibles = 0;


            horarios.forEach(function (horario) {

                const opcion =
                    document.createElement('option');

                const valor = horario.hora;

                const disponible =
                    horario.disponible === true;


                opcion.value = valor;


                if (disponible) {

                    opcion.textContent = valor;

                    disponibles++;

                } else {

                    opcion.textContent =
                        valor + ' — Ocupado';

                    opcion.disabled = true;

                }


                if (
                    disponible &&
                    horaAnterior &&
                    horaAnterior === valor
                ) {

                    opcion.selected = true;

                }


                hora.appendChild(opcion);

            });


            if (disponibles === 0) {

                hora.disabled = true;

                btnGuardar.disabled = true;

                mensaje.textContent =
                    'Todos los horarios de esta fecha están ocupados.';

                return;
            }


            hora.disabled = false;

            btnGuardar.disabled =
                hora.value === '';


            mensaje.textContent =
                'Los horarios marcados como ocupados no pueden seleccionarse.';

        })
        .catch(error => {

            console.error(error);

            hora.innerHTML = '';

            const opcion =
                document.createElement('option');

            opcion.value = '';

            opcion.textContent =
                'Error al cargar horarios';

            hora.appendChild(opcion);

            hora.disabled = true;

            btnGuardar.disabled = true;

            mensaje.textContent =
                'No fue posible consultar los horarios. Intenta nuevamente.';

        });

    }


    fecha.addEventListener('change', function () {

        const fechaSeleccionada =
            this.value;


        if (!fechaSeleccionada) {

            resetearHorario();

            return;

        }


        cargarHorarios(fechaSeleccionada);

    });


    hora.addEventListener('change', function () {

        btnGuardar.disabled =
            this.value === '';

    });


    /*
     * Si el formulario regresó por un error
     * de validación, volver a cargar los horarios.
     */

    if (fecha.value) {

        cargarHorarios(fecha.value);

    }

});

</script>

@endsection