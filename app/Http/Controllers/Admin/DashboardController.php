<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Carrito;
use App\Domain\Lta\Models\Category;
use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Orden;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use App\Domain\Lta\Models\Usuario;
use Illuminate\View\View;

class DashboardController extends AdminController
{
    public function __invoke(): View
    {
        $this->pageTitle = 'Panel Administrativo';

        // Get filter parameters
        $dateFrom = request('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = request('date_to', now()->format('Y-m-d'));
        $foundationFilter = request('foundation_id');
        $supplierFilter = request('supplier_id');
        $statusFilter = request('status');

        // Estadísticas de Fundaciones
        $totalFundaciones = Fundacion::count();
        $fundacionesActivas = Fundacion::where('activa', true)->count();
        $fundacionesInactivas = Fundacion::where('activa', false)->count();
        $fundacionesVerificadas = Fundacion::where('verified', true)->count();
        $fundacionesRecientes = Fundacion::orderByDesc('id')->limit(5)->get();

        // Estadísticas de Proveedores
        $totalProveedores = Proveedor::count();
        $proveedoresActivos = Proveedor::where('activo', true)->count();
        $proveedoresInactivos = Proveedor::where('activo', false)->count();
        $proveedoresRecientes = Proveedor::orderByDesc('id')->limit(5)->get();

        // Estadísticas de Productos
        $totalProductos = Producto::count();
        $productosActivos = Producto::where('estado', 'activo')->count();
        $productosInactivos = Producto::where('estado', 'inactivo')->count();
        $productosPorCategoria = Producto::with('category')
            ->selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                return [
                    'categoria' => $item->category?->name ?? 'Sin categoría',
                    'total' => $item->total,
                ];
            });
        $productosBajoStock = Producto::where('stock', '<', 10)->where('estado', 'activo')->count();
        $valorTotalInventario = Producto::where('estado', 'activo')
            ->selectRaw('SUM(price * stock) as total')
            ->value('total') ?? 0;
        $productosRecientes = Producto::with(['supplier', 'category'])->orderByDesc('id')->limit(5)->get();

        // Top proveedores por cantidad de productos
        $topProveedores = Proveedor::withCount('productos')
            ->orderByDesc('productos_count')
            ->limit(5)
            ->get();

        // Estadísticas de Categorías
        $totalCategorias = Category::count();
        $categoriasConProductos = Category::has('products')->count();

        // Estadísticas de Usuarios
        $totalUsuarios = Usuario::count();
        $usuariosRecientes = Usuario::orderByDesc('created_at')->limit(5)->get();

        // Estadísticas de Carritos
        $totalCarritos = Carrito::count();
        $carritosActivos = Carrito::whereDoesntHave('order')->count();
        $carritosRecientes = Carrito::with(['user', 'supplier', 'foundation'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Estadísticas de Órdenes
        $totalOrdenes = Orden::count();
        $totalIngresos = Orden::sum('total_amount') ?? 0;
        $ordenesPendientes = Orden::where('estado', 'pendiente')->count();
        $ordenesCompletadas = Orden::where('estado', 'completada')->count();
        $ordenesRecientes = Orden::with(['cart.user'])
            ->orderByDesc('id')
            ->limit(5)
            ->get();
            
        $ordenesPorEstado = Orden::selectRaw('estado as status, COUNT(*) as count')
            ->groupBy('estado')
            ->get();

        // Monthly Revenue Trends (filtered by date range)
        $monthlyRevenue = Orden::selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, SUM(total_amount) as revenue')
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
                    'revenue' => $item->revenue,
                ];
            });

        // Top 5 Products by Sales
        $topProductos = Producto::select('test.products.*')
            ->selectSub(function ($query) {
                $query->from('test.cart_items')
                    ->join('test.carts', 'test.cart_items.cart_id', '=', 'test.carts.id')
                    ->join('test.orders', 'test.carts.id', '=', 'test.orders.cart_id')
                    ->whereColumn('test.cart_items.product_id', 'test.products.id')
                    ->selectRaw('COUNT(*)');
            }, 'sales_count')
            ->with('supplier')
            ->orderByDesc('sales_count')
            ->limit(5)
            ->get();

        // Top 5 Foundations by Orders
        $topFundaciones = Fundacion::withCount(['carts as orders_count' => function ($query) {
                $query->has('order');
            }])
            ->orderByDesc('orders_count')
            ->limit(5)
            ->get();

        // User Registration Trends (filtered by date range)
        $userTrends = Usuario::selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
                    'count' => $item->count,
                ];
            });

        return view('admin.dashboard.index', $this->shareMeta([
            // Fundaciones
            'totalFundaciones' => $totalFundaciones,
            'fundacionesActivas' => $fundacionesActivas,
            'fundacionesInactivas' => $fundacionesInactivas,
            'fundacionesVerificadas' => $fundacionesVerificadas,
            'fundacionesRecientes' => $fundacionesRecientes,
            'porcentajeFundacionesActivas' => $totalFundaciones > 0 ? round(($fundacionesActivas / $totalFundaciones) * 100, 1) : 0,
            
            // Proveedores
            'totalProveedores' => $totalProveedores,
            'proveedoresActivos' => $proveedoresActivos,
            'proveedoresInactivos' => $proveedoresInactivos,
            'proveedoresRecientes' => $proveedoresRecientes,
            'porcentajeProveedoresActivos' => $totalProveedores > 0 ? round(($proveedoresActivos / $totalProveedores) * 100, 1) : 0,
            
            // Productos
            'totalProductos' => $totalProductos,
            'productosActivos' => $productosActivos,
            'productosInactivos' => $productosInactivos,
            'productosPorCategoria' => $productosPorCategoria,
            'productosBajoStock' => $productosBajoStock,
            'valorTotalInventario' => $valorTotalInventario,
            'productosRecientes' => $productosRecientes,
            'topProveedores' => $topProveedores,
            'porcentajeProductosActivos' => $totalProductos > 0 ? round(($productosActivos / $totalProductos) * 100, 1) : 0,

            // Categorías
            'totalCategorias' => $totalCategorias,
            'categoriasConProductos' => $categoriasConProductos,

            // Usuarios
            'totalUsuarios' => $totalUsuarios,
            'usuariosRecientes' => $usuariosRecientes,

            // Carritos
            'totalCarritos' => $totalCarritos,
            'carritosActivos' => $carritosActivos,
            'carritosRecientes' => $carritosRecientes,

            // Órdenes
            'totalOrdenes' => $totalOrdenes,
            'totalIngresos' => $totalIngresos,
            'ordenesPendientes' => $ordenesPendientes,
            'ordenesCompletadas' => $ordenesCompletadas,
            'ordenesRecientes' => $ordenesRecientes,
            'ordenesPorEstado' => $ordenesPorEstado,
            
            // Analytics & Trends
            'monthlyRevenue' => $monthlyRevenue,
            'topProductos' => $topProductos,
            'topFundaciones' => $topFundaciones,
            'userTrends' => $userTrends,
            
            // Filters
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'foundationFilter' => $foundationFilter,
            'supplierFilter' => $supplierFilter,
            'statusFilter' => $statusFilter,
        ]));
    }
}

