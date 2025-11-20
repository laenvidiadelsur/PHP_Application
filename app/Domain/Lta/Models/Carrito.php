<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrito extends Model
{
    protected $table = 'carrito';

    protected $fillable = [
        'usuario_id',
        'total',
        'estado',
        'fecha_expiracion',
        'session_id',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'fecha_expiracion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CarritoItem::class);
    }
}

