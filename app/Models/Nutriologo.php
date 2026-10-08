<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutriologo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'cedula_profesional',
        'telefono',
        'especialidad',
        'biografia',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim(
            $this->nombre . ' ' .
            $this->apellido_paterno . ' ' .
            ($this->apellido_materno ?? '')
        );
    }
}