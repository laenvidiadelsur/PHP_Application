<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Demo',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $this->call([
            // \Database\Seeders\Lta\LicenciaSeeder::class, // Comentado - modelo no existe
            \Database\Seeders\AdminUserSeeder::class,
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\FoundationSeeder::class,
            \Database\Seeders\SupplierSeeder::class,
            \Database\Seeders\ProductSeeder::class,
            \Database\Seeders\EventSeeder::class,
            \Database\Seeders\UserSeeder::class,
            \Database\Seeders\CartAndOrderSeeder::class,
        ]);
    }
}
