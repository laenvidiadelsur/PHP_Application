<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'suppliers';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'address',
        'image_url',
        'tax_id',
        'fundacion_id',
        'activo',
        'estado',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'activo' => 'boolean',
        'estado' => 'string',
    ];

    public function fundacion(): BelongsTo
    {
        return $this->belongsTo(Fundacion::class, 'fundacion_id');
    }

    /**
     * Fundaciones a las que este proveedor puede proveer (relación muchos a muchos).
     */
    public function fundaciones(): BelongsToMany
    {
        return $this->belongsToMany(
            Fundacion::class,
            'foundation_supplier',
            'supplier_id',
            'foundation_id'
        );
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'supplier_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Carrito::class, 'supplier_id');
    }

    /**
     * Verifica si el proveedor tiene información completa
     */
    public function hasCompleteInfo(): bool
    {
        return !empty($this->name) 
            && !empty($this->contact_name) 
            && !empty($this->email) 
            && !empty($this->phone) 
            && !empty($this->address);
    }
}
