<?php

namespace Database\Seeders;

use App\Domain\Lta\Models\Fundacion;
use Illuminate\Database\Seeder;

class FoundationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foundations = [
            [
                'name' => 'Fundación Ayuda a los Niños',
                'mission' => 'Brindar apoyo integral a niños en situación de vulnerabilidad, proporcionando educación, alimentación y atención médica.',
                'description' => 'Organización sin fines de lucro dedicada a mejorar la calidad de vida de niños y adolescentes en situación de riesgo social. Trabajamos en comunidades vulnerables proporcionando programas educativos, nutricionales y de salud.',
                'address' => 'Av. Principal #123, Santa Cruz de la Sierra',
                'verified' => true,
                'activa' => true,
            ],
            [
                'name' => 'Fundación Esperanza Verde',
                'mission' => 'Promover el cuidado del medio ambiente y la conservación de recursos naturales mediante programas educativos y de reforestación.',
                'description' => 'Organización comprometida con la protección del medio ambiente y la educación ambiental. Desarrollamos proyectos de reforestación, reciclaje y concientización ecológica.',
                'address' => 'Calle Ecológica #456, La Paz',
                'verified' => true,
                'activa' => true,
            ],
            [
                'name' => 'Fundación Manos Solidarias',
                'mission' => 'Apoyar a familias en situación de pobreza extrema mediante programas de alimentación, vivienda y capacitación laboral.',
                'description' => 'Trabajamos directamente con comunidades marginadas proporcionando ayuda inmediata y programas de desarrollo a largo plazo. Nuestro enfoque incluye alimentación, vivienda digna y capacitación para el trabajo.',
                'address' => 'Barrio Solidaridad, Cochabamba',
                'verified' => true,
                'activa' => true,
            ],
            [
                'name' => 'Fundación Educación para Todos',
                'mission' => 'Garantizar el acceso a la educación de calidad para niños y jóvenes de escasos recursos.',
                'description' => 'Organización dedicada a eliminar las barreras educativas. Proporcionamos materiales escolares, becas, tutorías y apoyo a escuelas rurales.',
                'address' => 'Av. Educación #789, Sucre',
                'verified' => true,
                'activa' => true,
            ],
            [
                'name' => 'Fundación Salud Comunitaria',
                'mission' => 'Mejorar el acceso a servicios de salud en comunidades rurales y urbanas marginadas.',
                'description' => 'Brindamos atención médica básica, medicamentos, campañas de vacunación y educación en salud preventiva a comunidades que no tienen acceso fácil a servicios de salud.',
                'address' => 'Calle Salud #321, Tarija',
                'verified' => true,
                'activa' => true,
            ],
            [
                'name' => 'Fundación Ancianos Dignos',
                'mission' => 'Proporcionar cuidado y apoyo integral a adultos mayores en situación de abandono o vulnerabilidad.',
                'description' => 'Dedicada a mejorar la calidad de vida de adultos mayores mediante programas de atención médica, alimentación, actividades recreativas y apoyo emocional.',
                'address' => 'Residencial Dignidad, Oruro',
                'verified' => false,
                'activa' => true,
            ],
            [
                'name' => 'Fundación Deportes para la Vida',
                'mission' => 'Promover el deporte como herramienta de desarrollo social y prevención de problemas juveniles.',
                'description' => 'Utilizamos el deporte como medio para desarrollar valores, habilidades sociales y prevenir problemas como la delincuencia juvenil. Organizamos ligas deportivas y programas de entrenamiento.',
                'address' => 'Complejo Deportivo Municipal, Potosí',
                'verified' => true,
                'activa' => true,
            ],
            [
                'name' => 'Fundación Mujeres Emprendedoras',
                'mission' => 'Empoderar a mujeres mediante programas de capacitación, microcréditos y apoyo para emprendimientos.',
                'description' => 'Trabajamos con mujeres de todas las edades proporcionando capacitación en habilidades empresariales, acceso a microcréditos y apoyo para iniciar sus propios negocios.',
                'address' => 'Centro Empresarial Femenino, El Alto',
                'verified' => true,
                'activa' => true,
            ],
            [
                'name' => 'Fundación Animales Sin Hogar',
                'mission' => 'Rescatar, rehabilitar y encontrar hogares para animales abandonados.',
                'description' => 'Organización dedicada al bienestar animal. Rescatamos animales de la calle, los rehabilitamos y buscamos familias adoptivas responsables.',
                'address' => 'Refugio Animal, Trinidad',
                'verified' => false,
                'activa' => true,
            ],
            [
                'name' => 'Fundación Arte y Cultura',
                'mission' => 'Promover y preservar la cultura local mediante talleres artísticos y eventos culturales.',
                'description' => 'Fomentamos el arte y la cultura en comunidades marginadas. Organizamos talleres de música, danza, pintura y teatro para niños y jóvenes.',
                'address' => 'Centro Cultural Comunitario, Riberalta',
                'verified' => true,
                'activa' => false,
            ],
        ];

        foreach ($foundations as $foundation) {
            Fundacion::updateOrCreate(
                ['name' => $foundation['name']],
                $foundation
            );
        }

        $this->command->info('Fundaciones creadas exitosamente.');
    }
}

