<?php

namespace Database\Seeders;

use App\Domain\Lta\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // No usar Hash::make aquí porque el modelo Usuario tiene setPasswordAttribute
        // que hashea automáticamente la contraseña
        $admin = Usuario::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => 'password', // El modelo lo hasheará automáticamente
                'is_admin' => true,
                'rol' => Usuario::ROL_ADMIN,
                'activo' => true,
                'approval_status' => Usuario::STATUS_APPROVED,
            ]
        );
        
        // Si el usuario ya existía, actualizar la contraseña también
        if ($admin->wasRecentlyCreated === false) {
            $admin->password = 'password';
            $admin->save();
        }
    }
}
