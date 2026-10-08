<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Mostrar formulario de inicio de sesión
    public function mostrarLogin()
    {
        if (Auth::check()) {
            return $this->redirigirSegunRol();
        }

        return view('auth.login');
    }

    // Procesar inicio de sesión
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credenciales)) {
            return back()
                ->withErrors([
                    'email' => 'El correo o la contraseña son incorrectos.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $usuario = Auth::user();

        if (!$usuario->activo) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Tu cuenta se encuentra desactivada.',
                ]);
        }

        return $this->redirigirSegunRol();
    }

    // Mostrar formulario de registro
    public function mostrarRegistro()
    {
        if (Auth::check()) {
            return $this->redirigirSegunRol();
        }

        return view('auth.registro');
    }

    // Registrar un nuevo cliente
    public function registro(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'apellido_paterno' => ['required', 'string', 'max:100'],
            'apellido_materno' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $usuario = DB::transaction(function () use ($datos) {
            $nombreCompleto = trim(
                $datos['nombre'] . ' ' .
                $datos['apellido_paterno'] . ' ' .
                ($datos['apellido_materno'] ?? '')
            );

            $usuario = User::create([
                'name' => $nombreCompleto,
                'email' => $datos['email'],
                'password' => Hash::make($datos['password']),
                'role' => 'cliente',
                'activo' => true,
            ]);

            Cliente::create([
                'user_id' => $usuario->id,
                'nombre' => $datos['nombre'],
                'apellido_paterno' => $datos['apellido_paterno'],
                'apellido_materno' => $datos['apellido_materno'] ?? null,
            ]);

            return $usuario;
        });

        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()
            ->route('cliente.dashboard')
            ->with('success', 'Tu cuenta fue creada correctamente.');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('inicio')
            ->with('success', 'Has cerrado sesión correctamente.');
    }

    // Redirigir según el tipo de usuario
    private function redirigirSegunRol()
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login');
        }

        if (!$usuario->activo) {
            Auth::logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Tu cuenta se encuentra desactivada.',
                ]);
        }

        if ($usuario->esNutriologo()) {
            return redirect()->route('nutriologo.dashboard');
        }

        if ($usuario->esCliente()) {
            return redirect()->route('cliente.dashboard');
        }

        abort(403, 'Tu cuenta no tiene un rol válido.');
    }
}