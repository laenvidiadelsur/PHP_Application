<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Category;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Producto::with(['supplier', 'category'])
            ->where('estado', 'activo');
        
        // Filtros
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('supplier') && $request->supplier) {
            $query->where('supplier_id', $request->supplier);
        }
        
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        $productos = $query->orderBy('name')->paginate(12);
        $categorias = Category::orderBy('name')->get();
        $proveedores = Proveedor::where('activo', true)->orderBy('name')->get();
        
        return view('frontend.products.index', [
            'pageTitle' => 'Productos',
            'productos' => $productos,
            'categorias' => $categorias,
            'proveedores' => $proveedores,
        ]);
    }
    
    public function show(Producto $producto): View
    {
        $producto->load(['supplier', 'category']);
        
        return view('frontend.products.show', [
            'pageTitle' => $producto->name,
            'producto' => $producto,
        ]);
    }
}

