<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Carrito;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carritos = Carrito::with(['user', 'supplier', 'foundation'])->orderBy('created_at', 'desc')->paginate(15);
        $pageTitle = 'Carritos';
        return view('admin.carritos.index', compact('carritos', 'pageTitle'));
    }

    public function show(Carrito $carrito)
    {
        $carrito->load(['items.product', 'user', 'supplier', 'foundation']);
        $pageTitle = 'Detalle de Carrito';
        return view('admin.carritos.show', compact('carrito', 'pageTitle'));
    }

    public function edit(Carrito $carrito)
    {
        // Implementación futura si se requiere editar carritos
        return redirect()->route('admin.carritos.show', $carrito);
    }

    public function update(Request $request, Carrito $carrito)
    {
        // Implementación futura
        return redirect()->route('admin.carritos.show', $carrito);
    }

    public function destroy(Carrito $carrito)
    {
        $carrito->delete();

        return redirect()->route('admin.carritos.index')
            ->with('success', 'Carrito eliminado exitosamente.');
    }
}
