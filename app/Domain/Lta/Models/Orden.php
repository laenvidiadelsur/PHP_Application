<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    protected $table = 'orden';

    protected $fillable = [
        'numero_orden',
        'usuario_id',
        'subtotal',
        'impuestos',
        'envio',
        'total',
        'direccion_calle',
        'direccion_ciudad',
        'direccion_estado',
        'direccion_codigo_postal',
        'direccion_pais',
        'coord_latitud',
        'coord_longitud',
        'contacto_nombre',
        'contacto_telefono',
        'contacto_email',
        'estado_pago',
        'estado_envio',
        'metodo_pago',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'stripe_marca',
        'stripe_ultimos4',
        'stripe_tipo',
        'fecha_pago',
        'notas',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'impuestos' => 'decimal:2',
        'envio' => 'decimal:2',
        'total' => 'decimal:2',
        'coord_latitud' => 'decimal:6',
        'coord_longitud' => 'decimal:6',
        'fecha_pago' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrdenItem::class);
    }
}

