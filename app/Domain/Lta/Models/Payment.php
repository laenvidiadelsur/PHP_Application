<?php

namespace App\Domain\Lta\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'test.payments';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'payment_method',
        'estado',
        'transaction_ref',
    ];


    public function order(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'order_id');
    }
}
