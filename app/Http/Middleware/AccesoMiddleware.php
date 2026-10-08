<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccesoMiddleware
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

        return $next($request);
    }
}