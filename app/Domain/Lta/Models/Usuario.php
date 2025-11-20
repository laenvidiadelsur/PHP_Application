<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model
{
    protected $table = 'usuario';

    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
        'rol',
        'fundacion_id',
        'proveedor_id',
        'rol_model',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function fundacion(): BelongsTo
    {
        return $this->belongsTo(Fundacion::class);
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function carritos(): HasMany
    {
        return $this->hasMany(Carrito::class);
    }

    public function ordenes(): HasMany
    {
        return $this->hasMany(Orden::class);
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }
}

