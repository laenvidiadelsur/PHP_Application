<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenItem extends Model
{
    protected $table = 'orden_item';

    protected $fillable = [
        'orden_id',
        'producto_id',
        'proveedor_id',
        'nombre',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }
}

