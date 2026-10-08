<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'nutriologo_id',
        'titulo',
        'slug',
        'resumen',
        'contenido',
        'imagen',
        'publicada',
        'publicada_en',
    ];

    protected function casts(): array
    {
        return [
            'publicada' => 'boolean',
            'publicada_en' => 'datetime',
        ];
    }

    public function nutriologo()
    {
        return $this->belongsTo(Nutriologo::class);
    }
}