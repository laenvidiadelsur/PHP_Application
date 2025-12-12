<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'test.products';

    public $timestamps = false;

    protected $fillable = [
        'supplier_id',
        'category_id',
        'name',
        'description',
        'price',
        'estado',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'estado' => 'string',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'supplier_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CarritoItem::class, 'product_id');
    }
}
