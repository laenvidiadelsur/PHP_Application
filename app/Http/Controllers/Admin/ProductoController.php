<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductoController extends AdminController
{
    private const UNIDADES = ['kg', 'unidad', 'litro', 'metro'];
    private const CATEGORIAS = ['materiales', 'equipos', 'alimentos', 'gaseosas', 'otros'];
    private const ESTADOS = ['activo', 'inactivo'];

    public function index(): View
    {
        $this->pageTitle = 'Productos';

        $productos = Producto::with(['proveedor', 'fundacion'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.productos.index', $this->shareMeta([
            'productos' => $productos,
        ]));
    }

    public function create(): View
    {
        $this->pageTitle = 'Nuevo producto';

        return view('admin.productos.create', $this->shareMeta([
            'producto' => new Producto(),
            'fundaciones' => Fundacion::orderBy('nombre')->get(),
            'proveedores' => Proveedor::with('fundacion')->orderBy('nombre')->get(),
            'unidades' => self::UNIDADES,
            'categorias' => self::CATEGORIAS,
            'estados' => self::ESTADOS,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if (!$this->proveedorPerteneceAFundacion($data['proveedor_id'], $data['fundacion_id'])) {
            return back()
                ->withErrors(['proveedor_id' => 'El proveedor seleccionado no está asociado a la fundación elegida.'])
                ->withInput();
        }

        Producto::create($data);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto): View
    {
        $this->pageTitle = 'Editar producto';

        return view('admin.productos.edit', $this->shareMeta([
            'producto' => $producto,
            'fundaciones' => Fundacion::orderBy('nombre')->get(),
            'proveedores' => Proveedor::with('fundacion')->orderBy('nombre')->get(),
            'unidades' => self::UNIDADES,
            'categorias' => self::CATEGORIAS,
            'estados' => self::ESTADOS,
        ]));
    }

    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $data = $this->validatedData($request, $producto->id);

        if (!$this->proveedorPerteneceAFundacion($data['proveedor_id'], $data['fundacion_id'])) {
            return back()
                ->withErrors(['proveedor_id' => 'El proveedor seleccionado no está asociado a la fundación elegida.'])
                ->withInput();
        }

        $producto->update($data);

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    private function validatedData(Request $request, ?int $productoId = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'unidad' => ['required', Rule::in(self::UNIDADES)],
            'stock' => ['required', 'integer', 'min:0'],
            'categoria' => ['required', Rule::in(self::CATEGORIAS)],
            'proveedor_id' => ['required', 'exists:proveedor,id'],
            'fundacion_id' => ['required', 'exists:fundacion,id'],
            'estado' => ['required', Rule::in(self::ESTADOS)],
        ]);
    }

    private function proveedorPerteneceAFundacion(int $proveedorId, int $fundacionId): bool
    {
        return Proveedor::whereKey($proveedorId)
            ->where('fundacion_id', $fundacionId)
            ->exists();
    }
}


