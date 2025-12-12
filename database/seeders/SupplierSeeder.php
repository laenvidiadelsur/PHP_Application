<?php

namespace Database\Seeders;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Proveedor;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foundations = Fundacion::all();
        
        if ($foundations->isEmpty()) {
            $this->command->warn('No hay fundaciones disponibles. Ejecuta FoundationSeeder primero.');
            return;
        }

        $suppliers = [
            [
                'name' => 'Distribuidora San Miguel',
                'contact_name' => 'Juan Pérez',
                'email' => 'contacto@sanmiguel.com.bo',
                'phone' => '+591 3 1234567',
                'address' => 'Av. Industrial #100, Santa Cruz',
                'tax_id' => '1234567890123',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Alimentos del Valle SRL',
                'contact_name' => 'María González',
                'email' => 'ventas@alimentosvalle.com.bo',
                'phone' => '+591 4 2345678',
                'address' => 'Zona Industrial, Cochabamba',
                'tax_id' => '2345678901234',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Materiales Constructores',
                'contact_name' => 'Carlos Rodríguez',
                'email' => 'info@materialesconstructores.com.bo',
                'phone' => '+591 2 3456789',
                'address' => 'Av. Constructor #200, La Paz',
                'tax_id' => '3456789012345',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Equipos y Herramientas SA',
                'contact_name' => 'Ana Martínez',
                'email' => 'contacto@equiposherramientas.com.bo',
                'phone' => '+591 7 4567890',
                'address' => 'Parque Industrial, Santa Cruz',
                'tax_id' => '4567890123456',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Bebidas Refrescantes',
                'contact_name' => 'Luis Fernández',
                'email' => 'ventas@bebidasrefrescantes.com.bo',
                'phone' => '+591 3 5678901',
                'address' => 'Calle Comercial #50, Santa Cruz',
                'tax_id' => '5678901234567',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Textiles del Sur',
                'contact_name' => 'Patricia López',
                'email' => 'info@textilessur.com.bo',
                'phone' => '+591 4 6789012',
                'address' => 'Zona Textil, Cochabamba',
                'tax_id' => '6789012345678',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Farmacia Comunitaria',
                'contact_name' => 'Roberto Sánchez',
                'email' => 'contacto@farmaciacomunitaria.com.bo',
                'phone' => '+591 2 7890123',
                'address' => 'Av. Salud #75, La Paz',
                'tax_id' => '7890123456789',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Material Educativo Plus',
                'contact_name' => 'Carmen Vargas',
                'email' => 'ventas@materialeducativo.com.bo',
                'phone' => '+591 4 8901234',
                'address' => 'Centro Educativo, Cochabamba',
                'tax_id' => '8901234567890',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Suministros Generales',
                'contact_name' => 'Diego Morales',
                'email' => 'info@suministrosgenerales.com.bo',
                'phone' => '+591 3 9012345',
                'address' => 'Mercado Central, Santa Cruz',
                'tax_id' => '9012345678901',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Productos Orgánicos Naturales',
                'contact_name' => 'Laura Jiménez',
                'email' => 'contacto@organicosnaturales.com.bo',
                'phone' => '+591 2 0123456',
                'address' => 'Zona Ecológica, La Paz',
                'tax_id' => '0123456789012',
                'fundacion_id' => $foundations->random()->id,
                'activo' => false,
                'estado' => 'pendiente',
            ],
            [
                'name' => 'Distribuidora Rápida',
                'contact_name' => 'Fernando Castro',
                'email' => 'ventas@distribuidorarapida.com.bo',
                'phone' => '+591 7 1234509',
                'address' => 'Av. Comercial #300, Santa Cruz',
                'tax_id' => '1234509876543',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
            [
                'name' => 'Equipamiento Deportivo',
                'contact_name' => 'Sofía Ramírez',
                'email' => 'info@equipamientodeportivo.com.bo',
                'phone' => '+591 4 2345098',
                'address' => 'Complejo Deportivo, Cochabamba',
                'tax_id' => '2345098765432',
                'fundacion_id' => $foundations->random()->id,
                'activo' => true,
                'estado' => 'aprobado',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Proveedor::updateOrCreate(
                ['tax_id' => $supplier['tax_id']],
                $supplier
            );
        }

        $this->command->info('Proveedores creados exitosamente.');
    }
}

