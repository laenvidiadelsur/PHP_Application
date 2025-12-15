<?php

namespace App\Http\Controllers\Proveedor;

use App\Domain\Lta\Models\Category;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|string|in:activo,inactivo',
            'category_id' => 'nullable|integer',
        ], [
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'La imagen debe ser de tipo: JPEG, JPG, PNG, GIF o WEBP.',
            'image.max' => 'La imagen no debe pesar más de 5MB.',
            'image.dimensions' => 'La imagen debe tener entre 100x100 y 5000x5000 píxeles.',
        ]);

        // Validar que la categoría existe si se proporciona
        if ($request->filled('category_id')) {
            $categoryTable = (new Category())->getTable();
            $categoryExists = DB::table($categoryTable)->where('id', $request->input('category_id'))->exists();
            if (!$categoryExists) {
                return back()->withErrors(['category_id' => 'La categoría seleccionada no existe.'])->withInput();
            }
        }

        // Manejar la subida de imagen
        if ($request->hasFile('image')) {
            try {
                // Asegurar que el directorio existe
                if (!Storage::disk('public')->exists('products')) {
                    Storage::disk('public')->makeDirectory('products');
                }

                // Validar que el archivo se subió correctamente
                if (!$request->file('image')->isValid()) {
                    return back()->withErrors(['image' => 'Error al subir la imagen. Por favor, intenta nuevamente.'])->withInput();
                }

                // Generar nombre único para evitar conflictos
                $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $imagePath = $request->file('image')->storeAs('products', $imageName, 'public');
                
                if (!$imagePath) {
                    return back()->withErrors(['image' => 'Error al guardar la imagen. Por favor, intenta nuevamente.'])->withInput();
                }

                $validated['image_url'] = $imagePath;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Error al procesar la imagen: ' . $e->getMessage()])->withInput();
            }
        }

        $validated['supplier_id'] = $proveedor->id;
        unset($validated['image']); // Remover 'image' del array ya que no es un campo de la BD
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
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|string|in:activo,inactivo',
            'category_id' => 'nullable|integer',
        ], [
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'La imagen debe ser de tipo: JPEG, JPG, PNG, GIF o WEBP.',
            'image.max' => 'La imagen no debe pesar más de 5MB.',
            'image.dimensions' => 'La imagen debe tener entre 100x100 y 5000x5000 píxeles.',
        ]);

        // Validar que la categoría existe si se proporciona
        if ($request->filled('category_id')) {
            $categoryTable = (new Category())->getTable();
            $categoryExists = DB::table($categoryTable)->where('id', $request->input('category_id'))->exists();
            if (!$categoryExists) {
                return back()->withErrors(['category_id' => 'La categoría seleccionada no existe.'])->withInput();
            }
        }

        // Manejar la subida de imagen
        if ($request->hasFile('image')) {
            try {
                // Asegurar que el directorio existe
                if (!Storage::disk('public')->exists('products')) {
                    Storage::disk('public')->makeDirectory('products');
                }

                // Validar que el archivo se subió correctamente
                if (!$request->file('image')->isValid()) {
                    return back()->withErrors(['image' => 'Error al subir la imagen. Por favor, intenta nuevamente.'])->withInput();
                }

                // Eliminar imagen anterior si existe
                if ($producto->image_url && Storage::disk('public')->exists($producto->image_url)) {
                    Storage::disk('public')->delete($producto->image_url);
                }

                // Generar nombre único para evitar conflictos
                $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $imagePath = $request->file('image')->storeAs('products', $imageName, 'public');
                
                if (!$imagePath) {
                    return back()->withErrors(['image' => 'Error al guardar la imagen. Por favor, intenta nuevamente.'])->withInput();
                }

                $validated['image_url'] = $imagePath;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Error al procesar la imagen: ' . $e->getMessage()])->withInput();
            }
        }

        unset($validated['image']); // Remover 'image' del array ya que no es un campo de la BD
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

        // Eliminar imagen asociada si existe
        if ($producto->image_url && Storage::disk('public')->exists($producto->image_url)) {
            Storage::disk('public')->delete($producto->image_url);
        }

        $producto->delete();

        return redirect()->route('proveedor.productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}

