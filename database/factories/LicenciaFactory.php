<?php

namespace Database\Factories;

use App\Domain\Lta\Models\Licencia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Licencia>
 */
class LicenciaFactory extends Factory
{
    protected $model = Licencia::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 years', 'now');
        $end = (clone $start)->modify('+4 years');

        return [
            'numero' => Str::upper($this->faker->bothify('LTA-#####')),
            'titular_id' => $this->faker->numberBetween(1, 1000),
            'estado' => $this->faker->randomElement(['vigente', 'pendiente', 'suspendida']),
            'vigencia_desde' => $start,
            'vigencia_hasta' => $end,
        ];
    }
}

