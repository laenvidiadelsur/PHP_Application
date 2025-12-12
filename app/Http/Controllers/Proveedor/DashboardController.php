<?php

namespace App\Http\Controllers\Proveedor;

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
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('home')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        // Get filter parameters
        $dateFrom = request('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = request('date_to', now()->format('Y-m-d'));
        $categoryFilter = request('category_id');
        $foundationFilter = request('foundation_id');

        // Estadísticas del proveedor (with filters)
        $productosCount = Producto::where('supplier_id', $proveedor->id)
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                return $query->where('category_id', $categoryFilter);
            })
            ->count();
        $productosActivos = Producto::where('supplier_id', $proveedor->id)
            ->where('estado', 'activo')
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                return $query->where('category_id', $categoryFilter);
            })
            ->count();
        $stockTotal = Producto::where('supplier_id', $proveedor->id)
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                return $query->where('category_id', $categoryFilter);
            })
            ->sum('stock');

        // Productos recientes (with filters)
        $productosRecientes = Producto::where('supplier_id', $proveedor->id)
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                return $query->where('category_id', $categoryFilter);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top 5 Products by Sales (with filters)
        $topProductos = Producto::where('supplier_id', $proveedor->id)
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                return $query->where('category_id', $categoryFilter);
            })
            ->select('test.products.*')
            ->selectSub(function ($query) use ($foundationFilter) {
                $query->from('test.cart_items')
                    ->join('test.carts', 'test.cart_items.cart_id', '=', 'test.carts.id')
                    ->join('test.orders', 'test.carts.id', '=', 'test.orders.cart_id')
                    ->whereColumn('test.cart_items.product_id', 'test.products.id')
                    ->when($foundationFilter, function ($q) use ($foundationFilter) {
                        return $q->where('test.carts.foundation_id', $foundationFilter);
                    })
                    ->selectRaw('COUNT(*)');
            }, 'sales_count')
            ->with('category')
            ->orderByDesc('sales_count')
            ->limit(5)
            ->get();

        // Product Stock Status
        $productosBajoStock = Producto::where('supplier_id', $proveedor->id)
            ->where('stock', '<', 10)
            ->where('estado', 'activo')
            ->count();

        $productosSinStock = Producto::where('supplier_id', $proveedor->id)
            ->where('stock', '=', 0)
            ->where('estado', 'activo')
            ->count();

        // Monthly Sales Trends (filtered by date range and foundation)
        $monthlySales = \App\Domain\Lta\Models\CarritoItem::whereHas('product', function ($query) use ($proveedor, $categoryFilter) {
                $query->where('supplier_id', $proveedor->id)
                    ->when($categoryFilter, function ($q) use ($categoryFilter) {
                        return $q->where('category_id', $categoryFilter);
                    });
            })
            ->whereHas('cart.order')
            ->join('test.carts', 'test.cart_items.cart_id', '=', 'test.carts.id')
            ->join('test.orders', 'test.carts.id', '=', 'test.orders.cart_id')
            ->when($foundationFilter, function ($query) use ($foundationFilter) {
                return $query->where('test.carts.foundation_id', $foundationFilter);
            })
            ->selectRaw('EXTRACT(YEAR FROM test.orders.created_at) as year, EXTRACT(MONTH FROM test.orders.created_at) as month, SUM(test.cart_items.quantity) as quantity')
            ->whereBetween('test.orders.created_at', [$dateFrom, $dateTo])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'quantity' => $item->quantity,
                ];
            });

        // Revenue by Foundation
        $revenueByFoundation = \App\Domain\Lta\Models\Orden::whereHas('cart.items.product', function ($query) use ($proveedor) {
                $query->where('supplier_id', $proveedor->id);
            })
            ->with('cart.foundation')
            ->where('estado', 'completado')
            ->get()
            ->groupBy('cart.foundation.nombre')
            ->map(function ($orders, $foundation) {
                return [
                    'foundation' => $foundation ?? 'Sin fundación',
                    'revenue' => $orders->sum('total_amount'),
                    'orders' => $orders->count(),
                ];
            })
            ->sortByDesc('revenue')
            ->take(5)
            ->values();

        // Total Revenue (from completed orders, with filters)
        $totalRevenue = \App\Domain\Lta\Models\Orden::whereHas('cart.items.product', function ($query) use ($proveedor, $categoryFilter) {
                $query->where('supplier_id', $proveedor->id)
                    ->when($categoryFilter, function ($q) use ($categoryFilter) {
                        return $q->where('category_id', $categoryFilter);
                    });
            })
            ->when($foundationFilter, function ($query) use ($foundationFilter) {
                return $query->whereHas('cart', function ($q) use ($foundationFilter) {
                    $q->where('foundation_id', $foundationFilter);
                });
            })
            ->where('estado', 'completado')
            ->sum('total_amount') ?? 0;

        return view('proveedor.dashboard.index', [
            'proveedor' => $proveedor,
            'productosCount' => $productosCount,
            'productosActivos' => $productosActivos,
            'stockTotal' => $stockTotal,
            'productosRecientes' => $productosRecientes,
            
            // Analytics & Trends
            'topProductos' => $topProductos,
            'productosBajoStock' => $productosBajoStock,
            'productosSinStock' => $productosSinStock,
            'monthlySales' => $monthlySales,
            'revenueByFoundation' => $revenueByFoundation,
            'totalRevenue' => $totalRevenue,
            
            // Filters
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'categoryFilter' => $categoryFilter,
            'foundationFilter' => $foundationFilter,
        ]);
    }
}

