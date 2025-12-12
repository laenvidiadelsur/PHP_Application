<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Orden;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    public function index()
    {
        $ordenes = Orden::with(['cart.user'])->orderBy('id', 'desc')->paginate(15);
        $pageTitle = 'Ordenes';
        return view('admin.ordenes.index', compact('ordenes', 'pageTitle'));
    }

    public function show(Orden $orden)
    {
        $orden->load(['cart.items.product', 'payments']);
        $pageTitle = 'Detalle de Orden';
        return view('admin.ordenes.show', compact('orden', 'pageTitle'));
    }

    public function edit(Orden $orden)
    {
        $pageTitle = 'Editar Orden';
        return view('admin.ordenes.edit', compact('orden', 'pageTitle'));
    }

    public function update(Request $request, Orden $orden)
    {
        $validated = $request->validate([
            'estado' => 'required|string|max:30',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $orden->update($validated);

        return redirect()->route('admin.ordenes.index')
            ->with('success', 'Orden actualizada exitosamente.');
    }

    public function destroy(Orden $orden)
    {
        $orden->delete();

        return redirect()->route('admin.ordenes.index')
            ->with('success', 'Orden eliminada exitosamente.');
    }
}
