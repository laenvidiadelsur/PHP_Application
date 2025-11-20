<?php

namespace App\Domain\Lta\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;

class LicenciaData implements Arrayable
{
    public function __construct(
        public readonly string $numero,
        public readonly int $titularId,
        public readonly string $estado,
        public readonly string $vigenciaDesde,
        public readonly string $vigenciaHasta,
    ) {
    }

    public function toArray(): array
    {
        return [
            'numero' => $this->numero,
            'titular_id' => $this->titularId,
            'estado' => $this->estado,
            'vigencia_desde' => $this->vigenciaDesde,
            'vigencia_hasta' => $this->vigenciaHasta,
        ];
    }
}

