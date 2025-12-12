<?php

namespace Database\Seeders;

use App\Domain\Lta\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Materiales',
                'description' => 'Materiales de construcción y suministros generales'
            ],
            [
                'name' => 'Equipos',
                'description' => 'Equipos y herramientas para diversas actividades'
            ],
            [
                'name' => 'Alimentos',
                'description' => 'Productos alimenticios y comestibles'
            ],
            [
                'name' => 'Gaseosas',
                'description' => 'Bebidas gaseosas y refrescos'
            ],
            [
                'name' => 'Ropa',
                'description' => 'Vestimenta y textiles'
            ],
            [
                'name' => 'Medicinas',
                'description' => 'Medicamentos y productos farmacéuticos'
            ],
            [
                'name' => 'Educación',
                'description' => 'Material educativo y escolar'
            ],
            [
                'name' => 'Otros',
                'description' => 'Otros productos diversos'
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }

        $this->command->info('Categorías creadas exitosamente.');
    }
}

