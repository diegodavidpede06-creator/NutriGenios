<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'telefono',
        'genero',
        'direccion',
        'contacto_emergencia',
        'telefono_emergencia',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function formularioClinico()
    {
        return $this->hasOne(FormularioClinico::class);
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