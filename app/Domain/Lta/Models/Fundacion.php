<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fundacion extends Model
{
    protected $table = 'test.foundations';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'mission',
        'description',
        'address',
        'verified',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function carts(): HasMany
    {
        return $this->hasMany(Carrito::class, 'foundation_id');
    }
}
