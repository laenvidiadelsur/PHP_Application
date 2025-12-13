<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Carrito extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'supplier_id',
        'foundation_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'supplier_id');
    }

    public function foundation(): BelongsTo
    {
        return $this->belongsTo(Fundacion::class, 'foundation_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CarritoItem::class, 'cart_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Orden::class, 'cart_id');
    }
}
