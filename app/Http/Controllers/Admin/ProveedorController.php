<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Proveedor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProveedorController extends AdminController
{
    public function index(): View
    {
        $this->pageTitle = 'Proveedores';

        $proveedores = Proveedor::with('fundacion')
            ->orderBy('nombre')
            ->paginate(12);

        return view('admin.proveedores.index', $this->shareMeta([
            'proveedores' => $proveedores,
        ]));
    }

    public function create(): View
    {
        $this->pageTitle = 'Nuevo proveedor';

        return view('admin.proveedores.create', $this->shareMeta([
            'proveedor' => new Proveedor(),
            'fundaciones' => Fundacion::orderBy('nombre')->get(),
            'estados' => ['pendiente', 'aprobado', 'rechazado'],
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Proveedor::create($data);

        return redirect()
            ->route('admin.proveedores.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function edit(Proveedor $proveedor): View
    {
        $this->pageTitle = 'Editar proveedor';

        return view('admin.proveedores.edit', $this->shareMeta([
            'proveedor' => $proveedor,
            'fundaciones' => Fundacion::orderBy('nombre')->get(),
            'estados' => ['pendiente', 'aprobado', 'rechazado'],
        ]));
    }

    public function update(Request $request, Proveedor $proveedor): RedirectResponse
    {
        $data = $this->validatedData($request, $proveedor->id);

        $proveedor->update($data);

        return redirect()
            ->route('admin.proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor): RedirectResponse
    {
        if ($proveedor->productos()->exists()) {
            return redirect()
                ->route('admin.proveedores.index')
                ->with('error', 'No se puede eliminar un proveedor con productos asociados.');
        }

        $proveedor->delete();

        return redirect()
            ->route('admin.proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }

    private function validatedData(Request $request, ?int $proveedorId = null): array
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'nit' => [
                'required',
                'string',
                'max:50',
                Rule::unique('proveedor', 'nit')->ignore($proveedorId),
            ],
            'direccion' => ['required', 'string', 'max:200'],
            'telefono' => ['required', 'string', 'max:30'],
            'email' => [
                'required',
                'email',
                'max:120',
                Rule::unique('proveedor', 'email')->ignore($proveedorId),
            ],
            'representante_nombre' => ['required', 'string', 'max:120'],
            'representante_ci' => ['required', 'string', 'max:40'],
            'tipo_servicio' => ['required', 'string', 'max:120'],
            'fundacion_id' => ['required', 'exists:fundacion,id'],
            'estado' => ['required', Rule::in(['pendiente', 'aprobado', 'rechazado'])],
            'activo' => ['nullable', 'boolean'],
        ], [], [
            'nit' => 'NIT',
        ]);

        $data['activo'] = $request->boolean('activo');

        return $data;
    }
}


