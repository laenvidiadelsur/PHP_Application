<?php

namespace App\Http\Controllers\Fundacion;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $fundacion = $user->fundacion;

        if (!$fundacion) {
            return redirect()->route('fundacion.dashboard')
                ->with('error', 'No tienes una fundación asociada.');
        }

        $proveedores = Proveedor::where('fundacion_id', $fundacion->id)
            ->orderBy('name')
            ->paginate(15);
        
        $pageTitle = 'Mis Proveedores';
        return view('fundacion.proveedores.index', compact('proveedores', 'pageTitle'));
    }

    public function create()
    {
        $user = Auth::user();
        $fundacion = $user->fundacion;

        if (!$fundacion) {
            return redirect()->route('fundacion.dashboard')
                ->with('error', 'No tienes una fundación asociada.');
        }

        $pageTitle = 'Nuevo Proveedor';
        $proveedor = new Proveedor();
        return view('fundacion.proveedores.create', compact('pageTitle', 'proveedor'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $fundacion = $user->fundacion;

        if (!$fundacion) {
            return redirect()->route('fundacion.dashboard')
                ->with('error', 'No tienes una fundación asociada.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'contact_name' => 'nullable|string|max:100',
            'email' => 'nullable|string|email|max:150',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
        ]);

        // Validar que el tax_id sea único si se proporciona
        if ($request->filled('tax_id')) {
            $taxIdExists = DB::table((new Proveedor())->getTable())
                ->where('tax_id', $request->input('tax_id'))
                ->exists();
            if ($taxIdExists) {
                return back()->withErrors(['tax_id' => 'El NIT/Tax ID ya está registrado.'])->withInput();
            }
        }

        $validated['fundacion_id'] = $fundacion->id;
        $validated['estado'] = 'pendiente';
        $validated['activo'] = true;

        Proveedor::create($validated);

        return redirect()->route('fundacion.proveedores.index')
            ->with('success', 'Proveedor creado exitosamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        $user = Auth::user();
        $fundacion = $user->fundacion;

        if (!$fundacion || $proveedor->fundacion_id !== $fundacion->id) {
            return redirect()->route('fundacion.proveedores.index')
                ->with('error', 'No tienes permiso para editar este proveedor.');
        }

        $pageTitle = 'Editar Proveedor';
        return view('fundacion.proveedores.edit', compact('proveedor', 'pageTitle'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $user = Auth::user();
        $fundacion = $user->fundacion;

        if (!$fundacion || $proveedor->fundacion_id !== $fundacion->id) {
            return redirect()->route('fundacion.proveedores.index')
                ->with('error', 'No tienes permiso para editar este proveedor.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'contact_name' => 'nullable|string|max:100',
            'email' => 'nullable|string|email|max:150',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
        ]);

        // Validar que el tax_id sea único si se proporciona (excepto el actual)
        if ($request->filled('tax_id')) {
            $taxIdExists = DB::table((new Proveedor())->getTable())
                ->where('tax_id', $request->input('tax_id'))
                ->where('id', '!=', $proveedor->id)
                ->exists();
            if ($taxIdExists) {
                return back()->withErrors(['tax_id' => 'El NIT/Tax ID ya está registrado.'])->withInput();
            }
        }

        $proveedor->update($validated);

        return redirect()->route('fundacion.proveedores.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $user = Auth::user();
        $fundacion = $user->fundacion;

        if (!$fundacion || $proveedor->fundacion_id !== $fundacion->id) {
            return redirect()->route('fundacion.proveedores.index')
                ->with('error', 'No tienes permiso para eliminar este proveedor.');
        }

        $proveedor->delete();

        return redirect()->route('fundacion.proveedores.index')
            ->with('success', 'Proveedor eliminado exitosamente.');
    }
}

