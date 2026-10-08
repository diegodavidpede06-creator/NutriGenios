<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularioClinico extends Model
{
    use HasFactory;

    protected $table = 'formularios_clinicos';

    protected $fillable = [
        'cliente_id',
        'peso',
        'estatura',
        'objetivo_nutricional',
        'antecedentes_medicos',
        'alergias',
        'medicamentos',
        'enfermedades',
        'cirugias',
        'alimentacion_actual',
        'actividad_fisica',
        'consumo_agua',
        'habitos_sueno',
        'observaciones',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}