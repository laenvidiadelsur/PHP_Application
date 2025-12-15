<?php

namespace App\Http\Controllers\Proveedor;

use App\Domain\Lta\Models\Orden;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdenController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('home')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        // Obtener órdenes que contienen productos de este proveedor
        $query = Orden::whereHas('cart.items.product', function ($q) use ($proveedor) {
                $q->where('supplier_id', $proveedor->id);
            })
            ->with(['cart.user', 'cart.foundation', 'cart.items.product'])
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $ordenes = $query->paginate(15);

        return view('proveedor.ordenes.index', [
            'ordenes' => $ordenes,
            'pageTitle' => 'Mis Órdenes',
            'filters' => [
                'estado' => $request->input('estado'),
                'date_from' => $request->input('date_from'),
                'date_to' => $request->input('date_to'),
            ],
        ]);
    }

    public function show(Orden $orden)
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('home')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        // Verificar que la orden contiene productos de este proveedor
        $hasSupplierProducts = $orden->cart->items()
            ->whereHas('product', function ($q) use ($proveedor) {
                $q->where('supplier_id', $proveedor->id);
            })
            ->exists();

        if (!$hasSupplierProducts) {
            return redirect()->route('proveedor.ordenes.index')
                ->with('error', 'No tienes acceso a esta orden.');
        }

        // Cargar solo los items de este proveedor
        $items = $orden->cart->items()
            ->whereHas('product', function ($q) use ($proveedor) {
                $q->where('supplier_id', $proveedor->id);
            })
            ->with('product.category')
            ->get();

        $orden->load(['cart.user', 'cart.foundation', 'payments']);

        return view('proveedor.ordenes.show', [
            'orden' => $orden,
            'items' => $items,
            'pageTitle' => 'Detalle de Orden #' . $orden->numero_orden,
        ]);
    }

    public function updateEstado(Request $request, Orden $orden)
    {
        $user = Auth::user();
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('home')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        // Verificar que la orden contiene productos de este proveedor
        $hasSupplierProducts = $orden->cart->items()
            ->whereHas('product', function ($q) use ($proveedor) {
                $q->where('supplier_id', $proveedor->id);
            })
            ->exists();

        if (!$hasSupplierProducts) {
            return redirect()->route('proveedor.ordenes.index')
                ->with('error', 'No tienes acceso a esta orden.');
        }

        $validated = $request->validate([
            'estado' => 'required|string|in:pendiente,procesando,completada,cancelada',
        ], [
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ]);

        $orden->update([
            'estado' => $validated['estado'],
        ]);

        return redirect()->route('proveedor.ordenes.show', $orden)
            ->with('success', 'Estado de la orden actualizado exitosamente.');
    }
}

