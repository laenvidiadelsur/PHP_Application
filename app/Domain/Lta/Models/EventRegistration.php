<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domain\Lta\Models\Evento;

class EventRegistration extends Model
{
    protected $table = 'test.event_registrations';

    // Status constants
    const STATUS_REGISTERED = 'registered';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_ATTENDED = 'attended';

    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class, 'event_id');
    }

    /**
     * Check if registration is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_REGISTERED;
    }

    /**
     * Check if registration is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /**
     * Check if user attended
     */
    public function isAttended(): bool
    {
        return $this->status === self::STATUS_ATTENDED;
    }
}
