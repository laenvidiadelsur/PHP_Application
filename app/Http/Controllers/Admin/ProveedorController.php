<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::orderBy('name')->paginate(15);
        $pageTitle = 'Proveedores';
        return view('admin.proveedores.index', compact('proveedores', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Nuevo Proveedor';
        $proveedor = new Proveedor();
        return view('admin.proveedores.create', compact('pageTitle', 'proveedor'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'contact_name' => 'nullable|string|max:100',
            'email' => 'nullable|string|email|max:150',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50|unique:suppliers,tax_id',
        ]);

        Proveedor::create($validated);

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor creado exitosamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        $pageTitle = 'Editar Proveedor';
        return view('admin.proveedores.edit', compact('proveedor', 'pageTitle'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'contact_name' => 'nullable|string|max:100',
            'email' => 'nullable|string|email|max:150',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50|unique:suppliers,tax_id,' . $proveedor->id,
        ]);

        $proveedor->update($validated);

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor eliminado exitosamente.');
    }
}
