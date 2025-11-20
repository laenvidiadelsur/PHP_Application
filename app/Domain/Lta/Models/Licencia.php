<?php

namespace App\Domain\Lta\Models;

use Database\Factories\LicenciaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 */
class Licencia extends Model
{
    /** @use HasFactory<LicenciaFactory> */
    use HasFactory;

    protected $table = 'licencias';

    protected static function newFactory(): LicenciaFactory
    {
        return LicenciaFactory::new();
    }

    protected $fillable = [
        'numero',
        'titular_id',
        'estado',
        'vigencia_desde',
        'vigencia_hasta',
    ];

    protected $casts = [
        'vigencia_desde' => 'date',
        'vigencia_hasta' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function titular(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'titular_id');
    }
}

