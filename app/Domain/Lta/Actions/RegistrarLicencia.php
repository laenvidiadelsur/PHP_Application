<?php

namespace App\Domain\Lta\Actions;

use App\Domain\Lta\DataTransferObjects\LicenciaData;
use App\Domain\Lta\Models\Licencia;

class RegistrarLicencia
{
    public function __invoke(LicenciaData $data): Licencia
    {
        return Licencia::create($data->toArray());
    }
}

