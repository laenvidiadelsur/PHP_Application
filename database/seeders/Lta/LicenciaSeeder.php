<?php

namespace Database\Seeders\Lta;

use App\Domain\Lta\Models\Licencia;
use Illuminate\Database\Seeder;

class LicenciaSeeder extends Seeder
{
    public function run(): void
    {
        Licencia::factory()->count(10)->create();
    }
}

