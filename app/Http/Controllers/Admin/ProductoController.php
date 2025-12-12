<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Category;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['supplier', 'category'])->orderBy('name')->paginate(15);
        $pageTitle = 'Productos';
        return view('admin.productos.index', compact('productos', 'pageTitle'));
    }

    public function create()
    {
        $proveedores = Proveedor::orderBy('name')->get();
        $categorias = Category::orderBy('name')->get();
        $pageTitle = 'Nuevo Producto';
        $producto = new Producto();
        return view('admin.productos.create', compact('proveedores', 'categorias', 'pageTitle', 'producto'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|string|max:30',
            'supplier_id' => 'required|exists:test.suppliers,id',
            'category_id' => 'nullable|exists:test.categories,id',
        ]);

        Producto::create($validated);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        $proveedores = Proveedor::orderBy('name')->get();
        $categorias = Category::orderBy('name')->get();
        $pageTitle = 'Editar Producto';
        return view('admin.productos.edit', compact('producto', 'proveedores', 'categorias', 'pageTitle'));
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|string|max:30',
            'supplier_id' => 'required|exists:test.suppliers,id',
            'category_id' => 'nullable|exists:test.categories,id',
        ]);

        $producto->update($validated);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
