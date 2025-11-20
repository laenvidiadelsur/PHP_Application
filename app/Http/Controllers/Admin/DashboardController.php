<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use Illuminate\View\View;

class DashboardController extends AdminController
{
    public function __invoke(): View
    {
        $this->pageTitle = 'Panel Administrativo';

        // Estadísticas de Fundaciones
        $totalFundaciones = Fundacion::count();
        $fundacionesActivas = Fundacion::where('activa', true)->count();
        $fundacionesInactivas = Fundacion::where('activa', false)->count();
        $fundacionesRecientes = Fundacion::orderByDesc('created_at')->limit(5)->get();

        // Estadísticas de Proveedores
        $totalProveedores = Proveedor::count();
        $proveedoresActivos = Proveedor::where('activo', true)->count();
        $proveedoresAprobados = Proveedor::where('estado', 'aprobado')->count();
        $proveedoresPendientes = Proveedor::where('estado', 'pendiente')->count();
        $proveedoresRecientes = Proveedor::with('fundacion')->orderByDesc('created_at')->limit(5)->get();

        // Estadísticas de Productos
        $totalProductos = Producto::count();
        $productosActivos = Producto::where('estado', 'activo')->count();
        $productosInactivos = Producto::where('estado', 'inactivo')->count();
        $productosPorCategoria = Producto::selectRaw('categoria, COUNT(*) as total')
            ->groupBy('categoria')
            ->get();
        $productosBajoStock = Producto::where('stock', '<', 10)->where('estado', 'activo')->count();
        $valorTotalInventario = Producto::where('estado', 'activo')
            ->selectRaw('SUM(precio * stock) as total')
            ->value('total') ?? 0;
        $productosRecientes = Producto::with(['proveedor', 'fundacion'])->orderByDesc('created_at')->limit(5)->get();

        // Distribución por fundación
        $productosPorFundacion = Producto::with('fundacion')
            ->selectRaw('fundacion_id, COUNT(*) as total')
            ->groupBy('fundacion_id')
            ->get()
            ->map(function ($item) {
                return [
                    'fundacion' => $item->fundacion?->nombre ?? 'Sin fundación',
                    'total' => $item->total,
                ];
            });

        // Top proveedores por cantidad de productos
        $topProveedores = Proveedor::withCount('productos')
            ->orderByDesc('productos_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', $this->shareMeta([
            // Fundaciones
            'totalFundaciones' => $totalFundaciones,
            'fundacionesActivas' => $fundacionesActivas,
            'fundacionesInactivas' => $fundacionesInactivas,
            'fundacionesRecientes' => $fundacionesRecientes,
            'porcentajeFundacionesActivas' => $totalFundaciones > 0 ? round(($fundacionesActivas / $totalFundaciones) * 100, 1) : 0,
            
            // Proveedores
            'totalProveedores' => $totalProveedores,
            'proveedoresActivos' => $proveedoresActivos,
            'proveedoresAprobados' => $proveedoresAprobados,
            'proveedoresPendientes' => $proveedoresPendientes,
            'proveedoresRecientes' => $proveedoresRecientes,
            'porcentajeProveedoresAprobados' => $totalProveedores > 0 ? round(($proveedoresAprobados / $totalProveedores) * 100, 1) : 0,
            
            // Productos
            'totalProductos' => $totalProductos,
            'productosActivos' => $productosActivos,
            'productosInactivos' => $productosInactivos,
            'productosPorCategoria' => $productosPorCategoria,
            'productosBajoStock' => $productosBajoStock,
            'valorTotalInventario' => $valorTotalInventario,
            'productosRecientes' => $productosRecientes,
            'productosPorFundacion' => $productosPorFundacion,
            'topProveedores' => $topProveedores,
            'porcentajeProductosActivos' => $totalProductos > 0 ? round(($productosActivos / $totalProductos) * 100, 1) : 0,
        ]));
    }
}

