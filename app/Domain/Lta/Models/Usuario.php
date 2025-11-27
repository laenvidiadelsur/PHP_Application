<?php

namespace App\Domain\Lta\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    protected $table = 'test.users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function carritos(): HasMany
    {
        return $this->hasMany(Carrito::class, 'user_id');
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
