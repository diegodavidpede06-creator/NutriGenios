<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClienteMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Debes iniciar sesión para continuar.');
        }

        $usuario = auth()->user();

        if (!$usuario->activo) {
            auth()->logout();

            return redirect()
                ->route('login')
                ->with('error', 'Tu cuenta se encuentra desactivada.');
        }

        if (!$usuario->esCliente()) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}