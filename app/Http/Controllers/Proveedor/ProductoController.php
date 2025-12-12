<?php

namespace App\Http\Controllers\Proveedor;

use App\Domain\Lta\Models\Category;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('proveedor.dashboard')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        $productos = Producto::where('supplier_id', $proveedor->id)
            ->with('category')
            ->orderBy('name')
            ->paginate(15);
        
        $pageTitle = 'Mis Productos';
        return view('proveedor.productos.index', compact('productos', 'pageTitle'));
    }

    public function create()
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('proveedor.dashboard')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        $categorias = Category::orderBy('name')->get();
        $pageTitle = 'Nuevo Producto';
        $producto = new Producto();
        return view('proveedor.productos.create', compact('categorias', 'pageTitle', 'producto'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('proveedor.dashboard')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|string|max:30',
            'category_id' => 'nullable',
        ]);

        // Validar que la categoría existe si se proporciona
        if ($request->filled('category_id')) {
            $categoryTable = (new Category())->getTable();
            $categoryExists = DB::table($categoryTable)->where('id', $request->input('category_id'))->exists();
            if (!$categoryExists) {
                return back()->withErrors(['category_id' => 'La categoría seleccionada no existe.'])->withInput();
            }
        }

        $validated['supplier_id'] = $proveedor->id;
        Producto::create($validated);

        return redirect()->route('proveedor.productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;

        if (!$proveedor || $producto->supplier_id !== $proveedor->id) {
            return redirect()->route('proveedor.productos.index')
                ->with('error', 'No tienes permiso para editar este producto.');
        }

        $categorias = Category::orderBy('name')->get();
        $pageTitle = 'Editar Producto';
        return view('proveedor.productos.edit', compact('producto', 'categorias', 'pageTitle'));
    }

    public function update(Request $request, Producto $producto)
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;

        if (!$proveedor || $producto->supplier_id !== $proveedor->id) {
            return redirect()->route('proveedor.productos.index')
                ->with('error', 'No tienes permiso para editar este producto.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|string|max:30',
            'category_id' => 'nullable',
        ]);

        // Validar que la categoría existe si se proporciona
        if ($request->filled('category_id')) {
            $categoryTable = (new Category())->getTable();
            $categoryExists = DB::table($categoryTable)->where('id', $request->input('category_id'))->exists();
            if (!$categoryExists) {
                return back()->withErrors(['category_id' => 'La categoría seleccionada no existe.'])->withInput();
            }
        }

        $producto->update($validated);

        return redirect()->route('proveedor.productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;

        if (!$proveedor || $producto->supplier_id !== $proveedor->id) {
            return redirect()->route('proveedor.productos.index')
                ->with('error', 'No tienes permiso para eliminar este producto.');
        }

        $producto->delete();

        return redirect()->route('proveedor.productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}

