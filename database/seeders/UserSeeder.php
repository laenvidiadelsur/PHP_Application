<?php

namespace Database\Seeders;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Proveedor;
use App\Domain\Lta\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foundations = Fundacion::all();
        $suppliers = Proveedor::all();
        
        if ($foundations->isEmpty() || $suppliers->isEmpty()) {
            $this->command->warn('No hay fundaciones o proveedores disponibles. Ejecuta FoundationSeeder y SupplierSeeder primero.');
            return;
        }

        // Usuarios Administradores
        Usuario::updateOrCreate(
            ['email' => 'admin@lta.com'],
            [
                'name' => 'Administrador Principal',
                'email' => 'admin@lta.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'rol' => 'admin',
                'approval_status' => 'approved',
                'activo' => true,
            ]
        );

        // Usuarios de Fundaciones
        $foundationUsers = [
            ['name' => 'María González', 'email' => 'maria@fundacionayuda.com', 'foundation' => 'Fundación Ayuda a los Niños'],
            ['name' => 'Juan Pérez', 'email' => 'juan@fundacionesperanza.com', 'foundation' => 'Fundación Esperanza Verde'],
            ['name' => 'Carmen López', 'email' => 'carmen@fundacionmanos.com', 'foundation' => 'Fundación Manos Solidarias'],
            ['name' => 'Roberto Martínez', 'email' => 'roberto@fundacioneducacion.com', 'foundation' => 'Fundación Educación para Todos'],
            ['name' => 'Ana Sánchez', 'email' => 'ana@fundacionsalud.com', 'foundation' => 'Fundación Salud Comunitaria'],
        ];

        foreach ($foundationUsers as $userData) {
            $foundation = $foundations->firstWhere('name', $userData['foundation']);
            if ($foundation) {
                Usuario::updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => Hash::make('password'),
                        'is_admin' => false,
                        'rol' => 'fundacion',
                        'fundacion_id' => $foundation->id,
                        'rol_model' => 'Fundacion',
                        'approval_status' => 'approved',
                        'activo' => true,
                    ]
                );
            }
        }

        // Usuarios Proveedores
        $supplierUsers = [];
        foreach ($suppliers->take(8) as $index => $supplier) {
            $supplierUsers[] = [
                'name' => $supplier->contact_name ?? "Proveedor {$supplier->name}",
                'email' => "proveedor{$index}@lta.com",
                'supplier_id' => $supplier->id,
            ];
        }

        foreach ($supplierUsers as $userData) {
            Usuario::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password'),
                    'is_admin' => false,
                    'rol' => 'proveedor',
                    'proveedor_id' => $userData['supplier_id'],
                    'rol_model' => 'Proveedor',
                    'approval_status' => 'approved',
                    'activo' => true,
                ]
            );
        }

        // Usuarios Compradores
        $buyerUsers = [
            ['name' => 'Carlos Ramírez', 'email' => 'carlos@comprador.com'],
            ['name' => 'Laura Fernández', 'email' => 'laura@comprador.com'],
            ['name' => 'Diego Morales', 'email' => 'diego@comprador.com'],
            ['name' => 'Patricia Vargas', 'email' => 'patricia@comprador.com'],
            ['name' => 'Fernando Castro', 'email' => 'fernando@comprador.com'],
            ['name' => 'Sofía Jiménez', 'email' => 'sofia@comprador.com'],
            ['name' => 'Luis Hernández', 'email' => 'luis@comprador.com'],
            ['name' => 'Andrea Torres', 'email' => 'andrea@comprador.com'],
            ['name' => 'Miguel Ruiz', 'email' => 'miguel@comprador.com'],
            ['name' => 'Gabriela Silva', 'email' => 'gabriela@comprador.com'],
        ];

        foreach ($buyerUsers as $userData) {
            Usuario::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password'),
                    'is_admin' => false,
                    'rol' => 'comprador',
                    'approval_status' => 'approved',
                    'activo' => true,
                ]
            );
        }

        $this->command->info('Usuarios creados exitosamente.');
    }
}

