<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    protected $table = 'test.orders';

    public $timestamps = false;

    protected $fillable = [
        'cart_id',
        'total_amount',
        'estado',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Carrito::class, 'cart_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function user()
    {
        return $this->hasOneThrough(
            Usuario::class,
            Carrito::class,
            'id', // Foreign key on carts table
            'id', // Foreign key on users table
            'cart_id', // Local key on orders table
            'user_id' // Local key on carts table
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(CarritoItem::class, 'cart_id', 'cart_id');
    }

    public function getTotalAttribute()
    {
        return $this->total_amount;
    }

    public function getNumeroOrdenAttribute()
    {
        return str_pad($this->id, 8, '0', STR_PAD_LEFT);
    }
}
