<?php

namespace App\Http\Controllers\Fundacion;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $fundacion = $user->fundacion;

        if (!$fundacion) {
            return redirect()->route('home')
                ->with('error', 'No tienes una fundación asociada.');
        }

        // Si el usuario está aprobado pero la fundación no tiene información completa,
        // redirigir al formulario de completado de información
        if ($user->isApproved() && !$fundacion->hasCompleteInfo()) {
            return redirect()->route('fundacion.complete-info')
                ->with('info', 'Por favor, completa la información de tu fundación para continuar.');
        }

        // Get filter parameters
        $dateFrom = request('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = request('date_to', now()->format('Y-m-d'));
        $supplierFilter = request('supplier_id');
        $statusFilter = request('status');

        // Estadísticas de la fundación
        $proveedoresCount = Proveedor::where('fundacion_id', $fundacion->id)->count();
        $productosCount = Producto::whereHas('supplier', function ($query) use ($fundacion) {
            $query->where('fundacion_id', $fundacion->id);
        })->count();

        // Proveedores recientes
        $proveedoresRecientes = Proveedor::where('fundacion_id', $fundacion->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top 5 Suppliers by Orders
        $topProveedores = Proveedor::where('fundacion_id', $fundacion->id)
            ->when($supplierFilter, function ($query) use ($supplierFilter) {
                return $query->where('id', $supplierFilter);
            })
            ->select('suppliers.*')
            ->selectSub(function ($query) use ($statusFilter) {
                $subQuery = $query->from('products')
                    ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                    ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
                    ->join('orders', 'carts.id', '=', 'orders.cart_id')
                    ->whereColumn('products.supplier_id', 'suppliers.id');
                
                if ($statusFilter) {
                    $subQuery->where('orders.estado', $statusFilter);
                }
                
                return $subQuery->selectRaw('COUNT(DISTINCT orders.id)');
            }, 'orders_count')
            ->orderByDesc('orders_count')
            ->limit(5)
            ->get();

        // Product Category Breakdown
        $productosPorCategoria = Producto::whereHas('supplier', function ($query) use ($fundacion, $supplierFilter) {
                $query->where('fundacion_id', $fundacion->id);
                if ($supplierFilter) {
                    $query->where('id', $supplierFilter);
                }
            })
            ->with('category')
            ->selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                return [
                    'categoria' => $item->category?->name ?? 'Sin categoría',
                    'total' => $item->total,
                ];
            });

        // Monthly Order Trends (filtered by date range)
        $monthlyOrders = \App\Domain\Lta\Models\Orden::whereHas('cart', function ($query) use ($fundacion, $supplierFilter) {
                $query->where('foundation_id', $fundacion->id);
                if ($supplierFilter) {
                    $query->whereHas('items.product', function ($q) use ($supplierFilter) {
                        $q->where('supplier_id', $supplierFilter);
                    });
                }
            })
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->when($statusFilter, function ($query) use ($statusFilter) {
                return $query->where('estado', $statusFilter);
            })
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'count' => $item->count,
                    'revenue' => $item->revenue,
                ];
            });

        // Order Status Breakdown
        $ordenesPorEstado = \App\Domain\Lta\Models\Orden::whereHas('cart', function ($query) use ($fundacion, $supplierFilter) {
                $query->where('foundation_id', $fundacion->id);
                if ($supplierFilter) {
                    $query->whereHas('items.product', function ($q) use ($supplierFilter) {
                        $q->where('supplier_id', $supplierFilter);
                    });
                }
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->selectRaw('estado as status, COUNT(*) as count')
            ->groupBy('estado')
            ->get();

        // Revenue Statistics
        $totalRevenue = \App\Domain\Lta\Models\Orden::whereHas('cart', function ($query) use ($fundacion) {
                $query->where('foundation_id', $fundacion->id);
            })
            ->where('estado', 'completada')
            ->sum('total_amount') ?? 0;

        $totalOrders = \App\Domain\Lta\Models\Orden::whereHas('cart', function ($query) use ($fundacion) {
                $query->where('foundation_id', $fundacion->id);
            })
            ->count();

        $pendingOrders = \App\Domain\Lta\Models\Orden::whereHas('cart', function ($query) use ($fundacion) {
                $query->where('foundation_id', $fundacion->id);
            })
            ->where('estado', 'pendiente')
            ->count();

        $completedOrders = \App\Domain\Lta\Models\Orden::whereHas('cart', function ($query) use ($fundacion) {
                $query->where('foundation_id', $fundacion->id);
            })
            ->where('estado', 'completada')
            ->count();

        // Obtener lista de proveedores para el filtro
        $proveedores = Proveedor::where('fundacion_id', $fundacion->id)
            ->orderBy('name')
            ->get();

        return view('fundacion.dashboard.index', [
            'fundacion' => $fundacion,
            'proveedoresCount' => $proveedoresCount,
            'productosCount' => $productosCount,
            'proveedoresRecientes' => $proveedoresRecientes,
            
            // Analytics & Trends
            'topProveedores' => $topProveedores,
            'productosPorCategoria' => $productosPorCategoria,
            'monthlyOrders' => $monthlyOrders,
            'ordenesPorEstado' => $ordenesPorEstado,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            
            // Filters
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'supplierFilter' => $supplierFilter,
            'statusFilter' => $statusFilter,
            'proveedores' => $proveedores,
        ]);
    }
}

