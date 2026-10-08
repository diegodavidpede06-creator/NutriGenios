<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PublicacionController extends Controller
{
    /**
     * Mostrar las publicaciones del nutriólogo.
     */
    public function index()
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $publicaciones = $nutriologo->publicaciones()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view(
            'nutriologo.publicaciones',
            compact('publicaciones')
        );
    }

    /**
     * Mostrar formulario para crear una publicación.
     */
    public function crear()
    {
        return view('nutriologo.publicaciones.crear');
    }

    /**
     * Guardar una nueva publicación.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:255',
            ],

            'resumen' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'contenido' => [
                'required',
                'string',
            ],

            'imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'publicada' => [
                'nullable',
                'boolean',
            ],
        ]);

        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $slugBase = Str::slug($datos['titulo']);

        $slug = $slugBase;
        $contador = 1;

        while (
            Publicacion::where('slug', $slug)->exists()
        ) {
            $slug = $slugBase . '-' . $contador;
            $contador++;
        }

        $publicada = $request->boolean('publicada');

        $imagen = null;

        if ($request->hasFile('imagen')) {
            $imagen = $request
                ->file('imagen')
                ->store('publicaciones', 'public');
        }

        $nutriologo->publicaciones()->create([
            'titulo' => $datos['titulo'],
            'slug' => $slug,
            'resumen' => $datos['resumen'] ?? null,
            'contenido' => $datos['contenido'],
            'imagen' => $imagen,
            'publicada' => $publicada,
            'publicada_en' => $publicada ? now() : null,
        ]);

        return redirect()
            ->route('nutriologo.publicaciones')
            ->with(
                'success',
                $publicada
                    ? 'La publicación fue creada y publicada correctamente.'
                    : 'La publicación fue guardada como borrador.'
            );
    }

    /**
     * Mostrar formulario para editar una publicación.
     */
    public function editar(int $publicacion)
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $publicacion = $nutriologo->publicaciones()
            ->findOrFail($publicacion);

        return view(
            'nutriologo.publicaciones.editar',
            compact('publicacion')
        );
    }

    /**
     * Actualizar una publicación.
     */
    public function update(
        Request $request,
        int $publicacion
    ) {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $publicacion = $nutriologo->publicaciones()
            ->findOrFail($publicacion);

        $datos = $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:255',
            ],

            'resumen' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'contenido' => [
                'required',
                'string',
            ],

            'imagen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'publicada' => [
                'nullable',
                'boolean',
            ],
        ]);

        $publicada = $request->boolean('publicada');

        $datosActualizar = [
            'titulo' => $datos['titulo'],
            'resumen' => $datos['resumen'] ?? null,
            'contenido' => $datos['contenido'],
            'publicada' => $publicada,
            'publicada_en' => $publicada
                ? ($publicacion->publicada_en ?? now())
                : null,
        ];

        if (
            $publicacion->titulo !== $datos['titulo']
        ) {
            $slugBase = Str::slug($datos['titulo']);

            $slug = $slugBase;
            $contador = 1;

            while (
                Publicacion::where('slug', $slug)
                    ->where('id', '!=', $publicacion->id)
                    ->exists()
            ) {
                $slug = $slugBase . '-' . $contador;
                $contador++;
            }

            $datosActualizar['slug'] = $slug;
        }

        if ($request->hasFile('imagen')) {
            $datosActualizar['imagen'] = $request
                ->file('imagen')
                ->store('publicaciones', 'public');
        }

        $publicacion->update($datosActualizar);

        return redirect()
            ->route('nutriologo.publicaciones')
            ->with(
                'success',
                'La publicación fue actualizada correctamente.'
            );
    }

    /**
     * Eliminar una publicación.
     */
    public function destroy(int $publicacion)
    {
        $nutriologo = Auth::user()
            ->nutriologo()
            ->firstOrFail();

        $publicacion = $nutriologo->publicaciones()
            ->findOrFail($publicacion);

        $publicacion->delete();

        return redirect()
            ->route('nutriologo.publicaciones')
            ->with(
                'success',
                'La publicación fue eliminada correctamente.'
            );
    }
}