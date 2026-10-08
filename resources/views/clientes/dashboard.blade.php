@extends('layouts.app')

@section('title', 'Mi panel')

@section('content')

<div class="page-header">
    <div>
        <span class="page-eyebrow">PORTAL DEL CLIENTE</span>

        <h2>Mi panel</h2>

        <p>
            Bienvenido a tu panel de Nutriología.
        </p>
    </div>
</div>

<div class="card">

    <div class="card-header">

        <div>
            <div class="card-title">
                Bienvenido
            </div>

            <div class="card-subtitle">
                Tu cuenta de cliente está funcionando correctamente.
            </div>
        </div>

    </div>

    <div class="card-body">

        <p>
            Hola,
            <strong>
                {{ $cliente->nombre_completo }}
            </strong>.
        </p>

        <p class="mt-2">
            Desde aquí podrás consultar tus citas,
            actualizar tu información y completar tu formulario clínico.
        </p>

    </div>

</div>

@endsection