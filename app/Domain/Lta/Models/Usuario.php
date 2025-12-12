<?php

namespace App\Domain\Lta\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use App\Domain\Lta\Models\Evento;

class Usuario extends Authenticatable
{
    protected $table = 'test.users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'rol',
        'fundacion_id',
        'proveedor_id',
        'rol_model',
        'approval_status',
        'activo',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_admin' => 'boolean',
        'activo' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Constantes para roles
    const ROL_ADMIN = 'admin';
    const ROL_FUNDACION = 'fundacion';
    const ROL_PROVEEDOR = 'proveedor';
    const ROL_COMPRADOR = 'comprador';

    // Constantes para estado de aprobación
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function carritos(): HasMany
    {
        return $this->hasMany(Carrito::class, 'user_id');
    }

    public function ordenes(): HasMany
    {
        return $this->hasMany(Orden::class, 'user_id');
    }

    public function fundacion(): BelongsTo
    {
        return $this->belongsTo(Fundacion::class, 'fundacion_id');
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'user_id');
    }

    public function registeredEvents(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'test.event_registrations', 'user_id', 'event_id')
            ->withPivot('status', 'registered_at')
            ->withTimestamps()
            ->orderBy('start_date', 'asc');
    }

    public function foundationRatings(): HasMany
    {
        return $this->hasMany(FoundationRating::class, 'user_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(FoundationVote::class, 'user_id');
    }

    public function setPasswordAttribute($value): void
    {
        // Solo hashear si el valor no está ya hasheado
        if (!empty($value) && !preg_match('/^\$2[ayb]\$.{56}$/', $value)) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    // Helpers para verificar roles
    public function isAdmin(): bool
    {
        return ($this->is_admin === true) || ($this->rol === self::ROL_ADMIN);
    }

    public function isFundacion(): bool
    {
        return $this->rol === self::ROL_FUNDACION;
    }

    public function isProveedor(): bool
    {
        return $this->rol === self::ROL_PROVEEDOR;
    }

    public function isComprador(): bool
    {
        return $this->rol === self::ROL_COMPRADOR || ($this->rol === null && !$this->isAdmin());
    }

    public function isApproved(): bool
    {
        return $this->approval_status === self::STATUS_APPROVED;
    }

    public function isPending(): bool
    {
        return $this->approval_status === self::STATUS_PENDING;
    }

    public function isRejected(): bool
    {
        return $this->approval_status === self::STATUS_REJECTED;
    }
}
