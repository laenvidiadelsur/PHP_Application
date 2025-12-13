<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoundationVote extends Model
{
    protected $table = 'foundation_votes';
    public $timestamps = false; // We only have created_at handled by DB or manually if needed, but migration uses timestamp('created_at')->useCurrent()

    protected $fillable = [
        'user_id',
        'foundation_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function foundation(): BelongsTo
    {
        return $this->belongsTo(Fundacion::class, 'foundation_id');
    }
}
