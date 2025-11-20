<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fundacion extends Model
{
    protected $table = 'fundacion';

    protected $fillable = [
        'nombre',
        'nit',
        'direccion',
        'telefono',
        'email',
        'representante_nombre',
        'representante_ci',
        'mision',
        'fecha_creacion',
        'area_accion',
        'cuenta_bancaria',
        'logo',
        'descripcion',
        'activa',
    ];

    protected $casts = [
        'fecha_creacion' => 'date',
        'activa' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function proveedores(): HasMany
    {
        return $this->hasMany(Proveedor::class);
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }
}


