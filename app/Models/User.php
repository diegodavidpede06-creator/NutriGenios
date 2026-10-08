<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function nutriologo()
    {
        return $this->hasOne(Nutriologo::class);
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    public function esNutriologo(): bool
    {
        return $this->role === 'nutriologo';
    }

    public function esCliente(): bool
    {
        return $this->role === 'cliente';
    }

    public function estaActivo(): bool
    {
        return $this->activo;
    }
}