<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedor';

    protected $fillable = [
        'nombre',
        'nit',
        'direccion',
        'telefono',
        'email',
        'representante_nombre',
        'representante_ci',
        'tipo_servicio',
        'fundacion_id',
        'estado',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function fundacion(): BelongsTo
    {
        return $this->belongsTo(Fundacion::class);
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}


