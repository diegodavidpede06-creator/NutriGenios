<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;

class PublicController extends Controller
{
    /**
     * Página principal.
     */
    public function inicio()
    {
        $publicaciones = Publicacion::query()
            ->where('publicada', true)
            ->orderByDesc('publicada_en')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('public.inicio', compact('publicaciones'));
    }

    /**
     * Información del consultorio.
     */
    public function consultorio()
    {
        return view('public.consultorio');
    }

    /**
     * Lista pública de publicaciones.
     */
    public function publicaciones()
    {
        $publicaciones = Publicacion::query()
            ->where('publicada', true)
            ->orderByDesc('publicada_en')
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('public.publicaciones', compact('publicaciones'));
    }

    /**
     * Mostrar una publicación individual.
     */
    public function mostrarPublicacion(string $slug)
    {
        $publicacion = Publicacion::query()
            ->where('slug', $slug)
            ->where('publicada', true)
            ->firstOrFail();

        return view('public.publicacion', compact('publicacion'));
    }

    /**
     * Página de contacto.
     */
    public function contacto()
    {
        return view('public.contacto');
    }
}