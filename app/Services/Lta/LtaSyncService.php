<?php

namespace App\Services\Lta;

use App\Domain\Lta\Models\Licencia;
use Illuminate\Support\Collection;

class LtaSyncService
{
    public function syncPending(): Collection
    {
        // Implementar sincronización con fuente externa de LTA.
        return Licencia::query()->where('estado', 'pendiente')->get();
    }
}

