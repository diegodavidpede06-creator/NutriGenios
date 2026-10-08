<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Nutriologo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    /**
     * Mostrar formulario para solicitar una cita.
     */
    public function crear()
    {
        $nutriologo = Nutriologo::firstOrFail();

        return view('cliente.citas.crear', compact('nutriologo'));
    }

    /**
     * Consultar horarios disponibles para una fecha.
     */
    public function disponibilidad(Request $request)
    {
        $datos = $request->validate([
            'fecha' => ['required', 'date'],
        ]);

        $fecha = Carbon::parse($datos['fecha'])->startOfDay();
        $hoy = now()->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | Validar fecha
        |--------------------------------------------------------------------------
        */

        if ($fecha->isWeekend()) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'El consultorio no atiende sábados ni domingos.',
                'horarios' => [],
            ]);
        }

        if ($fecha->lt($hoy)) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'No puedes consultar horarios de fechas anteriores.',
                'horarios' => [],
            ]);
        }

        $nutriologo = Nutriologo::firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Generar horarios del consultorio
        |--------------------------------------------------------------------------
        */

        $horarios = $this->generarHorarios();

        /*
        |--------------------------------------------------------------------------
        | Obtener horarios ocupados
        |--------------------------------------------------------------------------
        */

        $ocupados = Cita::query()
            ->where('nutriologo_id', $nutriologo->id)
            ->whereDate('fecha', $fecha->toDateString())
            ->whereNotIn('estado', ['cancelada'])
            ->pluck('hora')
            ->map(function ($hora) {
                return Carbon::parse($hora)->format('H:i');
            })
            ->values()
            ->all();

        /*
        |--------------------------------------------------------------------------
        | Marcar disponibilidad
        |--------------------------------------------------------------------------
        */

        $ahora = now();

        $horariosDisponibles = collect($horarios)
            ->map(function ($hora) use ($ocupados, $fecha, $ahora) {

                $ocupado = in_array($hora, $ocupados, true);

                $horaPasada = false;

                /*
                 * Si la fecha seleccionada es hoy,
                 * no permitimos seleccionar horarios que ya pasaron.
                 */
                if ($fecha->isSameDay($ahora)) {
                    $fechaHora = Carbon::createFromFormat(
                        'Y-m-d H:i',
                        $fecha->format('Y-m-d') . ' ' . $hora
                    );

                    $horaPasada = $fechaHora->lte($ahora);
                }

                return [
                    'hora' => $hora,
                    'disponible' => !$ocupado && !$horaPasada,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Respuesta
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'disponible' => true,
            'fecha' => $fecha->toDateString(),
            'horarios' => $horariosDisponibles,
        ]);
    }

    /**
     * Guardar una nueva cita.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'fecha' => ['required', 'date'],
            'hora' => ['required', 'date_format:H:i'],
            'motivo' => ['nullable', 'string', 'max:1000'],
        ]);

        $fecha = Carbon::parse($datos['fecha'])->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | Validar fecha
        |--------------------------------------------------------------------------
        */

        if ($fecha->isWeekend()) {
            return back()
                ->withErrors([
                    'fecha' => 'Las citas solamente están disponibles de lunes a viernes.',
                ])
                ->withInput();
        }

        if ($fecha->lt(now()->startOfDay())) {
            return back()
                ->withErrors([
                    'fecha' => 'No puedes agendar una cita en una fecha pasada.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Validar hora
        |--------------------------------------------------------------------------
        */

        if (!in_array($datos['hora'], $this->generarHorarios(), true)) {
            return back()
                ->withErrors([
                    'hora' => 'El horario seleccionado no está disponible.',
                ])
                ->withInput();
        }

        $hora = Carbon::createFromFormat(
            'H:i',
            $datos['hora']
        );

        /*
        |--------------------------------------------------------------------------
        | No permitir una hora pasada
        |--------------------------------------------------------------------------
        */

        $fechaHoraCita = Carbon::createFromFormat(
            'Y-m-d H:i',
            $fecha->format('Y-m-d') . ' ' . $hora->format('H:i')
        );

        if ($fechaHoraCita->lte(now())) {
            return back()
                ->withErrors([
                    'hora' => 'No puedes agendar una cita en un horario que ya pasó.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Obtener nutriólogo
        |--------------------------------------------------------------------------
        */

        $nutriologo = Nutriologo::firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Verificar que el horario no esté ocupado
        |--------------------------------------------------------------------------
        */

        $ocupada = Cita::query()
            ->where('nutriologo_id', $nutriologo->id)
            ->whereDate('fecha', $fecha->toDateString())
            ->where('hora', $hora->format('H:i:s'))
            ->whereNotIn('estado', ['cancelada'])
            ->exists();

        if ($ocupada) {
            return back()
                ->withErrors([
                    'hora' => 'Ese horario ya está ocupado. Selecciona otro.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Obtener cliente autenticado
        |--------------------------------------------------------------------------
        */

        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Crear cita
        |--------------------------------------------------------------------------
        */

        Cita::create([
            'cliente_id' => $cliente->id,
            'nutriologo_id' => $nutriologo->id,
            'fecha' => $fecha->toDateString(),
            'hora' => $hora->format('H:i:s'),
            'estado' => 'pendiente',
            'motivo' => $datos['motivo'] ?? null,
        ]);

        return redirect()
            ->route('cliente.citas')
            ->with(
                'success',
                'Tu cita fue solicitada correctamente.'
            );
    }

    /**
     * Mostrar una cita del cliente.
     */
    public function mostrar(int $cita)
    {
        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        $cita = $cliente->citas()
            ->with('nutriologo')
            ->findOrFail($cita);

        return view(
            'cliente.citas.mostrar',
            compact('cita')
        );
    }

    /**
     * Cancelar una cita del cliente.
     */
    public function cancelar(int $cita)
    {
        $cliente = Auth::user()
            ->cliente()
            ->firstOrFail();

        $cita = $cliente->citas()
            ->findOrFail($cita);

        /*
        |--------------------------------------------------------------------------
        | No permitir cancelar citas finalizadas
        |--------------------------------------------------------------------------
        */

        if (in_array($cita->estado, [
            'atendida',
            'cancelada',
            'no_asistio',
        ], true)) {
            return back()->with(
                'error',
                'Esta cita ya no puede ser cancelada.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cancelar cita
        |--------------------------------------------------------------------------
        */

        $cita->update([
            'estado' => 'cancelada',
        ]);

        return back()->with(
            'success',
            'La cita fue cancelada correctamente.'
        );
    }

    /**
     * Generar los horarios del consultorio.
     *
     * Lunes a viernes.
     * 08:00 a 16:00.
     * Intervalos de 30 minutos.
     */
    private function generarHorarios(): array
    {
        $horarios = [];

        $inicio = Carbon::createFromTime(8, 0);
        $fin = Carbon::createFromTime(16, 0);

        while ($inicio->lessThanOrEqualTo($fin)) {
            $horarios[] = $inicio->format('H:i');

            $inicio->addMinutes(30);
        }

        return $horarios;
    }
}