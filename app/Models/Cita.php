<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nutriologo_id',
        'fecha',
        'hora',
        'estado',
        'motivo',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function nutriologo()
    {
        return $this->belongsTo(Nutriologo::class);
    }

    public function estaPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    public function estaConfirmada(): bool
    {
        return $this->estado === 'confirmada';
    }

    public function estaCancelada(): bool
    {
        return $this->estado === 'cancelada';
    }

    public function fueAtendida(): bool
    {
        return $this->estado === 'atendida';
    }

    public function noAsistio(): bool
    {
        return $this->estado === 'no_asistio';
    }
}