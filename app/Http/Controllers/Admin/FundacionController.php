<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Fundacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FundacionController extends Controller
{
    public function index()
    {
        $fundaciones = Fundacion::orderBy('name')->paginate(15);
        $pageTitle = 'Fundaciones';
        return view('admin.fundaciones.index', compact('fundaciones', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Nueva Fundación';
        $fundacion = new Fundacion();
        return view('admin.fundaciones.create', compact('pageTitle', 'fundacion'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'mission' => 'nullable|string',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'verified' => 'boolean',
            'activa' => 'boolean',
        ]);

        $validated['verified'] = $request->has('verified');
        $validated['activa'] = $request->has('activa');

        Fundacion::create($validated);

        return redirect()->route('admin.fundaciones.index')
            ->with('success', 'Fundación creada exitosamente.');
    }

    public function edit(Fundacion $fundacion)
    {
        $pageTitle = 'Editar Fundación';
        return view('admin.fundaciones.edit', compact('fundacion', 'pageTitle'));
    }

    public function update(Request $request, Fundacion $fundacion)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'mission' => 'nullable|string',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'verified' => 'boolean',
            'activa' => 'boolean',
        ]);

        $validated['verified'] = $request->has('verified');
        $validated['activa'] = $request->has('activa');

        $fundacion->update($validated);

        return redirect()->route('admin.fundaciones.index')
            ->with('success', 'Fundación actualizada exitosamente.');
    }

    public function destroy(Fundacion $fundacion)
    {
        $fundacion->delete();

        return redirect()->route('admin.fundaciones.index')
            ->with('success', 'Fundación eliminada exitosamente.');
    }
}
