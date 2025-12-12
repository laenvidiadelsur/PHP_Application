<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoundationRating extends Model
{
    protected $table = 'test.foundation_ratings';

    protected $fillable = [
        'user_id',
        'foundation_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function fundacion(): BelongsTo
    {
        return $this->belongsTo(Fundacion::class, 'foundation_id');
    }

    /**
     * Validation rules
     */
    public static function validationRules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ];
    }
}
