<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'test.suppliers';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'address',
        'tax_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'supplier_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Carrito::class, 'supplier_id');
    }
}
