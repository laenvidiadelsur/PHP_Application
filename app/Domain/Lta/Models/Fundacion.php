<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fundacion extends Model
{
    protected $table = 'foundations';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'mission',
        'description',
        'address',
        'image_url',
        'verified',
        'activa',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'created_at' => 'datetime',
        'activa' => 'boolean',
    ];

    public function proveedores(): HasMany
    {
        return $this->hasMany(Proveedor::class, 'fundacion_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Carrito::class, 'foundation_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(FoundationVote::class, 'foundation_id');
    }

    public function isVotedByUser($userId): bool
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }

    /**
     * Verifica si la fundación tiene información completa
     */
    public function hasCompleteInfo(): bool
    {
        return !empty($this->name) 
            && !empty($this->mission) 
            && !empty($this->description) 
            && !empty($this->address);
    }
}
