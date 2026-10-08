<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NutriologoController extends Controller
{
    /**
     * Dashboard del nutriólogo.
     */
    public function dashboard()
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $hoy = now()->toDateString();

        $citasHoy = $nutriologo->citas()
            ->with('cliente')
            ->whereDate('fecha', $hoy)
            ->orderBy('hora')
            ->get();

        $proximasCitas = $nutriologo->citas()
            ->with('cliente')
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
            ->take(5)
            ->get();

        $totalClientes = Cliente::count();

        $citasPendientes = $nutriologo->citas()
            ->where('estado', 'pendiente')
            ->count();

        $citasConfirmadas = $nutriologo->citas()
            ->where('estado', 'confirmada')
            ->count();

        return view('nutriologo.dashboard', compact(
            'nutriologo',
            'citasHoy',
            'proximasCitas',
            'totalClientes',
            'citasPendientes',
            'citasConfirmadas'
        ));
    }

    /**
     * Mostrar perfil del nutriólogo.
     */
    public function perfil()
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        return view('nutriologo.perfil', compact('nutriologo'));
    }

    /**
     * Actualizar perfil del nutriólogo.
     */
    public function actualizarPerfil(Request $request)
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido_paterno' => ['required', 'string', 'max:100'],
            'apellido_materno' => ['nullable', 'string', 'max:100'],
            'cedula_profesional' => ['nullable', 'string', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'especialidad' => ['nullable', 'string', 'max:255'],
            'biografia' => ['nullable', 'string', 'max:5000'],
        ]);

        $nutriologo->update($datos);

        Auth::user()->update([
            'name' => trim(
                $nutriologo->nombre . ' ' .
                $nutriologo->apellido_paterno . ' ' .
                ($nutriologo->apellido_materno ?? '')
            ),
        ]);

        return back()->with(
            'success',
            'La información profesional fue actualizada correctamente.'
        );
    }

    /**
     * Lista de clientes.
     */
    public function clientes(Request $request)
    {
        $busqueda = $request->string('buscar')->trim()->toString();

        $clientes = Cliente::query()
            ->with('user')
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($query) use ($busqueda) {
                    $query->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('apellido_paterno', 'like', "%{$busqueda}%")
                        ->orWhere('apellido_materno', 'like', "%{$busqueda}%")
                        ->orWhereHas('user', function ($query) use ($busqueda) {
                            $query->where('email', 'like', "%{$busqueda}%");
                        });
                });
            })
            ->orderBy('apellido_paterno')
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('nutriologo.clientes', compact(
            'clientes',
            'busqueda'
        ));
    }

    /**
     * Mostrar información completa de un cliente.
     */
    public function mostrarCliente(int $cliente)
    {
        $cliente = Cliente::query()
            ->with([
                'user',
                'formularioClinico',
                'citas' => function ($query) {
                    $query->with('nutriologo')
                        ->orderByDesc('fecha')
                        ->orderByDesc('hora');
                },
            ])
            ->findOrFail($cliente);

        return view('nutriologo.cliente', compact('cliente'));
    }

    /**
     * Mostrar formulario clínico de un cliente.
     */
    public function mostrarFormulario(int $cliente)
    {
        $cliente = Cliente::query()
            ->with([
                'user',
                'formularioClinico',
            ])
            ->findOrFail($cliente);

        return view(
            'nutriologo.formulario-clinico',
            compact('cliente')
        );
    }

    /**
     * Mostrar todas las citas del nutriólogo.
     */
    public function citas(Request $request)
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $fecha = $request->input('fecha');

        $citas = $nutriologo->citas()
            ->with('cliente')
            ->when($fecha, function ($query) use ($fecha) {
                $query->whereDate('fecha', $fecha);
            })
            ->orderBy('fecha')
            ->orderBy('hora')
            ->paginate(20)
            ->withQueryString();

        return view('nutriologo.citas', compact(
            'citas',
            'fecha'
        ));
    }

    /**
     * Mostrar detalle de una cita.
     */
    public function mostrarCita(int $cita)
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $cita = $nutriologo->citas()
            ->with('cliente')
            ->findOrFail($cita);

        return view('nutriologo.cita', compact('cita'));
    }

    /**
     * Confirmar una cita.
     */
    public function confirmarCita(int $cita)
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $cita = $nutriologo->citas()
            ->findOrFail($cita);

        if ($cita->estado !== 'pendiente') {
            return back()->with(
                'error',
                'Solo se pueden confirmar citas pendientes.'
            );
        }

        $cita->update([
            'estado' => 'confirmada',
        ]);

        return back()->with(
            'success',
            'La cita fue confirmada correctamente.'
        );
    }

    /**
     * Cancelar una cita.
     */
    public function cancelarCita(int $cita)
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $cita = $nutriologo->citas()
            ->findOrFail($cita);

        if (in_array($cita->estado, ['atendida', 'cancelada'])) {
            return back()->with(
                'error',
                'Esta cita ya no puede ser cancelada.'
            );
        }

        $cita->update([
            'estado' => 'cancelada',
        ]);

        return back()->with(
            'success',
            'La cita fue cancelada correctamente.'
        );
    }

    /**
     * Marcar una cita como atendida.
     */
    public function marcarAtendida(int $cita)
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $cita = $nutriologo->citas()
            ->findOrFail($cita);

        $cita->update([
            'estado' => 'atendida',
        ]);

        return back()->with(
            'success',
            'La cita fue marcada como atendida.'
        );
    }

    /**
     * Marcar que el cliente no asistió.
     */
    public function marcarNoAsistio(int $cita)
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $cita = $nutriologo->citas()
            ->findOrFail($cita);

        $cita->update([
            'estado' => 'no_asistio',
        ]);

        return back()->with(
            'success',
            'La cita fue marcada como no asistió.'
        );
    }
}