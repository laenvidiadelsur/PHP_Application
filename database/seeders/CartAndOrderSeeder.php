<?php

namespace Database\Seeders;

use App\Domain\Lta\Models\Carrito;
use App\Domain\Lta\Models\CarritoItem;
use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Orden;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Usuario;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CartAndOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buyers = Usuario::where('rol', 'comprador')->get();
        $foundations = Fundacion::where('activa', true)->get();
        $products = Producto::where('estado', 'activo')->get();
        
        if ($buyers->isEmpty() || $foundations->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No hay compradores, fundaciones o productos disponibles. Ejecuta los seeders anteriores primero.');
            return;
        }

        $orderStatuses = ['pendiente', 'completada', 'completada', 'completada', 'procesando', 'cancelada'];
        
        // Crear órdenes de los últimos 6 meses
        for ($month = 0; $month < 6; $month++) {
            $ordersPerMonth = rand(15, 30);
            
            for ($i = 0; $i < $ordersPerMonth; $i++) {
                $buyer = $buyers->random();
                $foundation = $foundations->random();
                $supplier = $foundation->proveedores()->inRandomOrder()->first();
                
                if (!$supplier) {
                    continue;
                }
                
                // Crear carrito
                $cart = Carrito::create([
                    'user_id' => $buyer->id,
                    'supplier_id' => $supplier->id,
                    'foundation_id' => $foundation->id,
                    'created_at' => Carbon::now()->subMonths($month)->subDays(rand(0, 29))->setTime(rand(8, 20), rand(0, 59)),
                ]);

                // Agregar productos al carrito
                $totalAmount = 0;
                $numItems = rand(2, 6);
                
                $availableProducts = $products->where('supplier_id', $supplier->id)->take(10);
                
                if ($availableProducts->isEmpty()) {
                    $cart->delete();
                    continue;
                }
                
                foreach ($availableProducts->random(min($numItems, $availableProducts->count())) as $product) {
                    $quantity = rand(1, 5);
                    $price = $product->price;
                    
                    CarritoItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                    ]);
                    
                    $totalAmount += $price * $quantity;
                }
                
                if ($totalAmount == 0) {
                    $cart->delete();
                    continue;
                }

                // Crear orden
                $status = $orderStatuses[array_rand($orderStatuses)];
                $createdAt = $cart->created_at->copy()->addHours(rand(1, 48));
                
                Orden::create([
                    'cart_id' => $cart->id,
                    'total_amount' => $totalAmount,
                    'estado' => $status,
                    'created_at' => $createdAt,
                ]);
            }
        }

        // Crear algunos carritos sin orden (carritos activos)
        for ($i = 0; $i < 10; $i++) {
            $buyer = $buyers->random();
            $foundation = $foundations->random();
            $supplier = $foundation->proveedores()->inRandomOrder()->first();
            
            if (!$supplier) {
                continue;
            }
            
            $availableProducts = $products->where('supplier_id', $supplier->id)->take(5);
            
            if ($availableProducts->isEmpty()) {
                continue;
            }
            
            $cart = Carrito::create([
                'user_id' => $buyer->id,
                'supplier_id' => $supplier->id,
                'foundation_id' => $foundation->id,
                'created_at' => Carbon::now()->subDays(rand(0, 7)),
            ]);

            foreach ($availableProducts->random(rand(1, min(3, $availableProducts->count()))) as $product) {
                CarritoItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                ]);
            }
        }

        $this->command->info('Carritos y órdenes creados exitosamente.');
    }
}

