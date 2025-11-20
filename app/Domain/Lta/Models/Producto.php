<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'producto';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'unidad',
        'stock',
        'categoria',
        'proveedor_id',
        'fundacion_id',
        'estado',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function fundacion(): BelongsTo
    {
        return $this->belongsTo(Fundacion::class);
    }
}


