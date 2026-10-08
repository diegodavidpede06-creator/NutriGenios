<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Dashboard del cliente.
     */
    public function dashboard()
    {
        $cliente = Auth::user()
            ->cliente()
            ->with([
                'citas' => function ($query) {
                    $query->with('nutriologo')
                        ->orderBy('fecha')
                        ->orderBy('hora');
                },
                'formularioClinico',
            ])
            ->firstOrFail();

        $proximaCita = $cliente->citas()
            ->with('nutriologo')
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->where(function ($query) {
                $query->whereDate('fecha', '>', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->whereDate('fecha', now()->toDateString())
                            ->where('hora', '>=', now()->format('H:i:s'));
                    });
            })
            ->orderBy('fecha')
            ->orderBy('hora')
            ->first();

        return view('cliente.dashboard', compact(
            'cliente',
            'proximaCita'
        ));
    }

    /**
     * Mostrar perfil del cliente.
     */
    public function perfil()
    {
        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        return view('cliente.perfil', compact('cliente'));
    }

    /**
     * Actualizar perfil del cliente.
     */
    public function actualizarPerfil(Request $request)
    {
        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido_paterno' => ['required', 'string', 'max:100'],
            'apellido_materno' => ['nullable', 'string', 'max:100'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'genero' => ['nullable', 'string', 'max:50'],
            'direccion' => ['nullable', 'string', 'max:500'],
            'contacto_emergencia' => ['nullable', 'string', 'max:150'],
            'telefono_emergencia' => ['nullable', 'string', 'max:30'],
        ]);

        $cliente->update($datos);

        $usuario = Auth::user();

        $usuario->update([
            'name' => trim(
                $cliente->nombre . ' ' .
                $cliente->apellido_paterno . ' ' .
                ($cliente->apellido_materno ?? '')
            ),
        ]);

        return back()->with(
            'success',
            'Tu información personal fue actualizada correctamente.'
        );
    }

    /**
     * Mostrar las citas del cliente.
     */
    public function citas()
    {
        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        $citas = $cliente->citas()
            ->with('nutriologo')
            ->orderByDesc('fecha')
            ->orderByDesc('hora')
            ->paginate(10);

        return view(
            'cliente.citas',
            compact('cliente', 'citas')
        );
    }
}