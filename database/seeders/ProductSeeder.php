<?php

namespace Database\Seeders;

use App\Domain\Lta\Models\Category;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Proveedor::all();
        $categories = Category::all();
        
        if ($suppliers->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('No hay proveedores o categorías disponibles. Ejecuta SupplierSeeder y CategorySeeder primero.');
            return;
        }

        $products = [
            // Materiales
            ['name' => 'Cemento Portland 50kg', 'description' => 'Cemento de alta calidad para construcción', 'price' => 45.00, 'stock' => 150, 'category' => 'Materiales'],
            ['name' => 'Ladrillos Comunes x1000', 'description' => 'Ladrillos de arcilla para construcción', 'price' => 350.00, 'stock' => 80, 'category' => 'Materiales'],
            ['name' => 'Arena Fina m3', 'description' => 'Arena fina para construcción', 'price' => 120.00, 'stock' => 200, 'category' => 'Materiales'],
            ['name' => 'Piedra Triturada m3', 'description' => 'Piedra triturada para construcción', 'price' => 150.00, 'stock' => 100, 'category' => 'Materiales'],
            ['name' => 'Hierro Corrugado 1/2" x12m', 'description' => 'Varilla de hierro corrugado', 'price' => 85.00, 'stock' => 120, 'category' => 'Materiales'],
            ['name' => 'Alambre Galvanizado kg', 'description' => 'Alambre galvanizado para construcción', 'price' => 12.50, 'stock' => 300, 'category' => 'Materiales'],
            ['name' => 'Pintura Latex 20L', 'description' => 'Pintura látex de alta calidad', 'price' => 280.00, 'stock' => 50, 'category' => 'Materiales'],
            ['name' => 'Cal Hidratada 50kg', 'description' => 'Cal hidratada para construcción', 'price' => 35.00, 'stock' => 90, 'category' => 'Materiales'],
            
            // Equipos
            ['name' => 'Taladro Eléctrico', 'description' => 'Taladro eléctrico profesional 750W', 'price' => 450.00, 'stock' => 25, 'category' => 'Equipos'],
            ['name' => 'Martillo Demoledor', 'description' => 'Martillo demoledor eléctrico', 'price' => 1200.00, 'stock' => 8, 'category' => 'Equipos'],
            ['name' => 'Sierra Circular', 'description' => 'Sierra circular eléctrica profesional', 'price' => 680.00, 'stock' => 15, 'category' => 'Equipos'],
            ['name' => 'Compresor de Aire', 'description' => 'Compresor de aire portátil 50L', 'price' => 850.00, 'stock' => 12, 'category' => 'Equipos'],
            ['name' => 'Soldadora Eléctrica', 'description' => 'Soldadora eléctrica 200A', 'price' => 950.00, 'stock' => 10, 'category' => 'Equipos'],
            ['name' => 'Nivel Láser', 'description' => 'Nivel láser profesional', 'price' => 350.00, 'stock' => 20, 'category' => 'Equipos'],
            ['name' => 'Pulidora Angular', 'description' => 'Pulidora angular 7"', 'price' => 280.00, 'stock' => 18, 'category' => 'Equipos'],
            
            // Alimentos
            ['name' => 'Arroz Premium 50kg', 'description' => 'Arroz de primera calidad', 'price' => 180.00, 'stock' => 200, 'category' => 'Alimentos'],
            ['name' => 'Azúcar Blanca 50kg', 'description' => 'Azúcar blanca refinada', 'price' => 220.00, 'stock' => 150, 'category' => 'Alimentos'],
            ['name' => 'Aceite Vegetal 20L', 'description' => 'Aceite vegetal comestible', 'price' => 160.00, 'stock' => 100, 'category' => 'Alimentos'],
            ['name' => 'Fideos Variados x12', 'description' => 'Paquete de fideos variados', 'price' => 45.00, 'stock' => 500, 'category' => 'Alimentos'],
            ['name' => 'Harina de Trigo 50kg', 'description' => 'Harina de trigo para panadería', 'price' => 195.00, 'stock' => 120, 'category' => 'Alimentos'],
            ['name' => 'Leche en Polvo 25kg', 'description' => 'Leche en polvo entera', 'price' => 850.00, 'stock' => 60, 'category' => 'Alimentos'],
            ['name' => 'Frijol Negro 50kg', 'description' => 'Frijol negro de primera calidad', 'price' => 320.00, 'stock' => 80, 'category' => 'Alimentos'],
            ['name' => 'Sal de Mesa 50kg', 'description' => 'Sal de mesa refinada', 'price' => 45.00, 'stock' => 200, 'category' => 'Alimentos'],
            ['name' => 'Atún en Lata x24', 'description' => 'Lata de atún en agua', 'price' => 120.00, 'stock' => 300, 'category' => 'Alimentos'],
            ['name' => 'Sardinas en Lata x24', 'description' => 'Lata de sardinas en aceite', 'price' => 95.00, 'stock' => 250, 'category' => 'Alimentos'],
            
            // Gaseosas
            ['name' => 'Coca Cola 2.5L x12', 'description' => 'Pack de Coca Cola 2.5 litros', 'price' => 180.00, 'stock' => 200, 'category' => 'Gaseosas'],
            ['name' => 'Sprite 2.5L x12', 'description' => 'Pack de Sprite 2.5 litros', 'price' => 175.00, 'stock' => 180, 'category' => 'Gaseosas'],
            ['name' => 'Fanta Naranja 2.5L x12', 'description' => 'Pack de Fanta Naranja 2.5 litros', 'price' => 170.00, 'stock' => 150, 'category' => 'Gaseosas'],
            ['name' => 'Pepsi 2.5L x12', 'description' => 'Pack de Pepsi 2.5 litros', 'price' => 165.00, 'stock' => 160, 'category' => 'Gaseosas'],
            ['name' => 'Gaseosa Local 2L x24', 'description' => 'Pack de gaseosa local 2 litros', 'price' => 140.00, 'stock' => 300, 'category' => 'Gaseosas'],
            
            // Ropa
            ['name' => 'Pantalón Jeans x12', 'description' => 'Lote de pantalones jeans', 'price' => 480.00, 'stock' => 50, 'category' => 'Ropa'],
            ['name' => 'Camisetas Básicas x24', 'description' => 'Lote de camisetas básicas', 'price' => 360.00, 'stock' => 80, 'category' => 'Ropa'],
            ['name' => 'Zapatos Deportivos x12', 'description' => 'Lote de zapatos deportivos', 'price' => 720.00, 'stock' => 30, 'category' => 'Ropa'],
            ['name' => 'Chalecos Abrigadores x10', 'description' => 'Lote de chalecos abrigadores', 'price' => 450.00, 'stock' => 40, 'category' => 'Ropa'],
            
            // Medicinas
            ['name' => 'Paracetamol 500mg x100', 'description' => 'Caja de paracetamol 500mg', 'price' => 25.00, 'stock' => 500, 'category' => 'Medicinas'],
            ['name' => 'Ibuprofeno 400mg x100', 'description' => 'Caja de ibuprofeno 400mg', 'price' => 28.00, 'stock' => 400, 'category' => 'Medicinas'],
            ['name' => 'Amoxicilina 500mg x30', 'description' => 'Caja de amoxicilina 500mg', 'price' => 45.00, 'stock' => 200, 'category' => 'Medicinas'],
            ['name' => 'Alcohol Antiséptico 1L', 'description' => 'Botella de alcohol antiséptico', 'price' => 18.00, 'stock' => 300, 'category' => 'Medicinas'],
            ['name' => 'Gasas Estériles x10', 'description' => 'Paquete de gasas estériles', 'price' => 35.00, 'stock' => 250, 'category' => 'Medicinas'],
            
            // Educación
            ['name' => 'Cuadernos x100', 'description' => 'Lote de cuadernos escolares', 'price' => 280.00, 'stock' => 100, 'category' => 'Educación'],
            ['name' => 'Lápices x500', 'description' => 'Lote de lápices escolares', 'price' => 150.00, 'stock' => 200, 'category' => 'Educación'],
            ['name' => 'Borradores x200', 'description' => 'Lote de borradores', 'price' => 80.00, 'stock' => 300, 'category' => 'Educación'],
            ['name' => 'Reglas Escolares x100', 'description' => 'Lote de reglas escolares', 'price' => 120.00, 'stock' => 150, 'category' => 'Educación'],
            ['name' => 'Mochilas Escolares x20', 'description' => 'Lote de mochilas escolares', 'price' => 600.00, 'stock' => 50, 'category' => 'Educación'],
            
            // Otros
            ['name' => 'Detergente 5kg x12', 'description' => 'Pack de detergente 5kg', 'price' => 240.00, 'stock' => 100, 'category' => 'Otros'],
            ['name' => 'Jabón de Tocador x100', 'description' => 'Lote de jabón de tocador', 'price' => 180.00, 'stock' => 200, 'category' => 'Otros'],
            ['name' => 'Papel Higiénico x48', 'description' => 'Pack de papel higiénico', 'price' => 160.00, 'stock' => 150, 'category' => 'Otros'],
            ['name' => 'Baterías AA x100', 'description' => 'Lote de baterías AA', 'price' => 220.00, 'stock' => 120, 'category' => 'Otros'],
        ];

        foreach ($products as $productData) {
            $category = $categories->firstWhere('name', $productData['category']);
            $supplier = $suppliers->random();
            
            Producto::create([
                'supplier_id' => $supplier->id,
                'category_id' => $category?->id,
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'estado' => 'activo',
            ]);
        }

        $this->command->info('Productos creados exitosamente.');
    }
}

