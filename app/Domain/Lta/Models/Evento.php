<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evento extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'name',

        'description',
        'start_date',
        'end_date',
        'location',
        'capacity',
        'status', // active, cancelled, completed
        'image_url',
        'foundation_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->start_date > now();
    }
}
