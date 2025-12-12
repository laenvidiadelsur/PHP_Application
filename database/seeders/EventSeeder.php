<?php

namespace Database\Seeders;

use App\Domain\Lta\Models\Evento;
use App\Domain\Lta\Models\Fundacion;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foundations = Fundacion::where('activa', true)->get();
        
        if ($foundations->isEmpty()) {
            $this->command->warn('No hay fundaciones activas disponibles. Ejecuta FoundationSeeder primero.');
            return;
        }

        $events = [
            [
                'name' => 'Campaña de Donación de Alimentos',
                'description' => 'Gran campaña de recolección de alimentos no perecederos para familias necesitadas. Se recibirán donaciones de arroz, fideos, aceite, azúcar y otros productos básicos.',
                'start_date' => Carbon::now()->addDays(15)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(15)->setTime(18, 0),
                'location' => 'Plaza Principal, Santa Cruz de la Sierra',
                'capacity' => 500,
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Jornada Médica Gratuita',
                'description' => 'Jornada de atención médica gratuita para la comunidad. Se brindarán consultas generales, medicamentos básicos y vacunación.',
                'start_date' => Carbon::now()->addDays(20)->setTime(8, 0),
                'end_date' => Carbon::now()->addDays(20)->setTime(16, 0),
                'location' => 'Centro de Salud Comunitario, La Paz',
                'capacity' => 300,
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Taller de Emprendimiento para Mujeres',
                'description' => 'Taller práctico de emprendimiento dirigido a mujeres. Incluye capacitación en gestión de negocios, marketing y finanzas básicas.',
                'start_date' => Carbon::now()->addDays(25)->setTime(14, 0),
                'end_date' => Carbon::now()->addDays(25)->setTime(18, 0),
                'location' => 'Centro Empresarial Femenino, Cochabamba',
                'capacity' => 50,
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Campaña de Reforestación',
                'description' => 'Actividad de reforestación en áreas afectadas. Se plantarán árboles nativos y se brindará educación ambiental.',
                'start_date' => Carbon::now()->addDays(30)->setTime(7, 0),
                'end_date' => Carbon::now()->addDays(30)->setTime(13, 0),
                'location' => 'Parque Ecológico, Santa Cruz',
                'capacity' => 200,
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Feria de Materiales Escolares',
                'description' => 'Feria donde se distribuirán materiales escolares a precios accesibles para familias de escasos recursos.',
                'start_date' => Carbon::now()->addDays(10)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(10)->setTime(17, 0),
                'location' => 'Coliseo Municipal, Sucre',
                'capacity' => 400,
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Campaña de Vacunación',
                'description' => 'Campaña masiva de vacunación para niños y adultos. Se aplicarán vacunas contra diversas enfermedades.',
                'start_date' => Carbon::now()->addDays(5)->setTime(8, 0),
                'end_date' => Carbon::now()->addDays(5)->setTime(16, 0),
                'location' => 'Hospital Municipal, Tarija',
                'capacity' => 600,
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Festival Deportivo Comunitario',
                'description' => 'Festival deportivo con competencias de fútbol, básquet y atletismo para niños y jóvenes de la comunidad.',
                'start_date' => Carbon::now()->addDays(40)->setTime(8, 0),
                'end_date' => Carbon::now()->addDays(40)->setTime(20, 0),
                'location' => 'Complejo Deportivo Municipal, Potosí',
                'capacity' => 800,
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Taller de Nutrición Infantil',
                'description' => 'Taller educativo sobre nutrición infantil para padres y cuidadores. Incluye preparación de alimentos nutritivos.',
                'start_date' => Carbon::now()->addDays(18)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(18)->setTime(14, 0),
                'location' => 'Centro Comunitario, El Alto',
                'capacity' => 60,
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Campaña de Limpieza Comunitaria',
                'description' => 'Jornada de limpieza en barrios marginados. Se recolectará basura y se realizará educación sobre reciclaje.',
                'start_date' => Carbon::now()->addDays(12)->setTime(7, 0),
                'end_date' => Carbon::now()->addDays(12)->setTime(12, 0),
                'location' => 'Barrio Solidaridad, Cochabamba',
                'capacity' => 150,
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Concierto Benéfico',
                'description' => 'Concierto benéfico con artistas locales. Los fondos recaudados serán destinados a programas sociales.',
                'start_date' => Carbon::now()->addDays(35)->setTime(19, 0),
                'end_date' => Carbon::now()->addDays(35)->setTime(23, 0),
                'location' => 'Teatro Municipal, La Paz',
                'capacity' => 1000,
                'status' => 'active',
                'image_url' => null,
            ],
            // Eventos pasados
            [
                'name' => 'Campaña Navideña 2024',
                'description' => 'Campaña de recolección de juguetes y alimentos para familias necesitadas en Navidad.',
                'start_date' => Carbon::now()->subDays(30)->setTime(9, 0),
                'end_date' => Carbon::now()->subDays(30)->setTime(18, 0),
                'location' => 'Plaza Central, Santa Cruz',
                'capacity' => 500,
                'status' => 'completed',
                'image_url' => null,
            ],
            [
                'name' => 'Jornada de Salud Preventiva',
                'description' => 'Jornada de chequeos médicos preventivos y charlas sobre salud.',
                'start_date' => Carbon::now()->subDays(20)->setTime(8, 0),
                'end_date' => Carbon::now()->subDays(20)->setTime(16, 0),
                'location' => 'Centro de Salud, Cochabamba',
                'capacity' => 300,
                'status' => 'completed',
                'image_url' => null,
            ],
        ];

        foreach ($events as $eventData) {
            $eventData['foundation_id'] = $foundations->random()->id;
            // La tabla requiere 'title', usar 'name' como 'title' también
            $eventData['title'] = $eventData['name'];
            Evento::create($eventData);
        }

        $this->command->info('Eventos creados exitosamente.');
    }
}

