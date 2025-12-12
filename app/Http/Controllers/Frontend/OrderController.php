<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Orden;
use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Obtener todas las órdenes del usuario a través de sus carritos
        $query = Orden::whereHas('cart', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->with(['cart.items.product.supplier.fundaciones', 'cart.items.product.category', 'cart.foundation', 'cart.supplier'])
        ->orderBy('created_at', 'desc');

        // Filtro por fundación
        if ($request->filled('fundacion_id')) {
            $query->whereHas('cart', function ($q) use ($request) {
                $q->where('foundation_id', $request->input('fundacion_id'));
            });
        }

        // Filtro por proveedor
        if ($request->filled('proveedor_id')) {
            $query->whereHas('cart.items.product', function ($q) use ($request) {
                $q->where('supplier_id', $request->input('proveedor_id'));
            });
        }

        $ordenes = $query->paginate(15);

        // Obtener fundaciones y proveedores para los filtros
        $fundaciones = Fundacion::where('activa', true)->orderBy('name')->get();
        $proveedores = Proveedor::where('activo', true)->orderBy('name')->get();

        return view('frontend.orders.index', [
            'ordenes' => $ordenes,
            'fundaciones' => $fundaciones,
            'proveedores' => $proveedores,
            'pageTitle' => 'Mis Órdenes',
            'filters' => [
                'fundacion_id' => $request->input('fundacion_id'),
                'proveedor_id' => $request->input('proveedor_id'),
            ],
        ]);
    }

    public function show(Orden $orden)
    {
        $user = Auth::user();

        // Verificar que la orden pertenece al usuario
        if ($orden->cart->user_id !== $user->id) {
            abort(403, 'No tienes permiso para ver esta orden.');
        }

        $orden->load(['cart.items.product.supplier', 'cart.items.product.category', 'cart.foundation', 'cart.supplier', 'payments']);

        return view('frontend.orders.show', [
            'orden' => $orden,
            'pageTitle' => 'Detalle de Orden #' . $orden->id,
        ]);
    }
}

