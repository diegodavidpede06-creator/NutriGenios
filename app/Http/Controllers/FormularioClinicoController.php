<?php

namespace App\Http\Controllers;

use App\Models\FormularioClinico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormularioClinicoController extends Controller
{
    /**
     * Mostrar formulario clínico del cliente.
     *
     * Si todavía no existe, se mostrará el formulario vacío.
     */
    public function create()
    {
        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        $formulario = $cliente->formularioClinico;

        return view(
            'cliente.formulario-clinico',
            compact('cliente', 'formulario')
        );
    }

    /**
     * Guardar formulario clínico.
     */
    public function store(Request $request)
    {
        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        $datos = $request->validate([
            'peso' => [
                'nullable',
                'numeric',
                'min:0',
                'max:500',
            ],

            'estatura' => [
                'nullable',
                'numeric',
                'min:30',
                'max:250',
            ],

            'objetivo_nutricional' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'antecedentes_medicos' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'alergias' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'medicamentos' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'enfermedades' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'cirugias' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'alimentacion_actual' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'actividad_fisica' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'consumo_agua' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'habitos_sueno' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'observaciones' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $cliente->formularioClinico()->updateOrCreate(
            [
                'cliente_id' => $cliente->id,
            ],
            $datos
        );

        return redirect()
            ->route('cliente.formulario.crear')
            ->with(
                'success',
                'Tu formulario clínico fue guardado correctamente.'
            );
    }

    /**
     * Mostrar formulario clínico para edición.
     */
    public function edit()
    {
        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        $formulario = $cliente->formularioClinico;

        return view(
            'cliente.formulario-clinico',
            compact('cliente', 'formulario')
        );
    }

    /**
     * Actualizar formulario clínico.
     */
    public function update(Request $request)
    {
        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        $formulario = $cliente->formularioClinico;

        if (!$formulario) {
            return redirect()
                ->route('cliente.formulario.crear')
                ->with(
                    'error',
                    'Primero debes crear tu formulario clínico.'
                );
        }

        $datos = $request->validate([
            'peso' => [
                'nullable',
                'numeric',
                'min:0',
                'max:500',
            ],

            'estatura' => [
                'nullable',
                'numeric',
                'min:30',
                'max:250',
            ],

            'objetivo_nutricional' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'antecedentes_medicos' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'alergias' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'medicamentos' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'enfermedades' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'cirugias' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'alimentacion_actual' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'actividad_fisica' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'consumo_agua' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'habitos_sueno' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'observaciones' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $formulario->update($datos);

        return redirect()
            ->route('cliente.formulario.editar')
            ->with(
                'success',
                'Tu formulario clínico fue actualizado correctamente.'
            );
    }
}