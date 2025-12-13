<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Carrito;
use App\Domain\Lta\Models\Category;
use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Orden;
use App\Domain\Lta\Models\Payment;
use App\Domain\Lta\Models\Producto;
use App\Domain\Lta\Models\Proveedor;
use App\Domain\Lta\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReporteController extends AdminController
{
    public function index(Request $request)
    {
        $this->pageTitle = 'Reportes';

        // Obtener datos para los filtros
        $fundaciones = Fundacion::orderBy('name')->get();
        $proveedores = Proveedor::orderBy('name')->get();
        $categorias = Category::orderBy('name')->get();

        // Aplicar filtros
        $filtros = $this->aplicarFiltros($request);

        // Obtener estadísticas generales
        $estadisticas = $this->obtenerEstadisticas($filtros);

        return view('admin.reportes.index', $this->shareMeta([
            'fundaciones' => $fundaciones,
            'proveedores' => $proveedores,
            'categorias' => $categorias,
            'estadisticas' => $estadisticas,
            'filtros' => $filtros,
        ]));
    }

    public function exportarExcel(Request $request)
    {
        $tipoReporte = $request->input('tipo_reporte', 'ventas');
        $filtros = $this->aplicarFiltros($request);

        // Asegurar que el autoload esté cargado
        if (!class_exists(\PhpOffice\PhpSpreadsheet\Spreadsheet::class)) {
            require_once base_path('vendor/autoload.php');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        switch ($tipoReporte) {
            case 'ventas':
                $this->generarReporteVentasExcel($sheet, $filtros);
                $nombreArchivo = 'reporte_ventas_' . date('Y-m-d_His') . '.xlsx';
                break;
            case 'productos':
                $this->generarReporteProductosExcel($sheet, $filtros);
                $nombreArchivo = 'reporte_productos_' . date('Y-m-d_His') . '.xlsx';
                break;
            case 'ordenes':
                $this->generarReporteOrdenesExcel($sheet, $filtros);
                $nombreArchivo = 'reporte_ordenes_' . date('Y-m-d_His') . '.xlsx';
                break;
            case 'proveedores':
                $this->generarReporteProveedoresExcel($sheet, $filtros);
                $nombreArchivo = 'reporte_proveedores_' . date('Y-m-d_His') . '.xlsx';
                break;
            case 'fundaciones':
                $this->generarReporteFundacionesExcel($sheet, $filtros);
                $nombreArchivo = 'reporte_fundaciones_' . date('Y-m-d_His') . '.xlsx';
                break;
            default:
                $this->generarReporteVentasExcel($sheet, $filtros);
                $nombreArchivo = 'reporte_ventas_' . date('Y-m-d_His') . '.xlsx';
        }

        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportarPdf(Request $request)
    {
        $tipoReporte = $request->input('tipo_reporte', 'ventas');
        $filtros = $this->aplicarFiltros($request);

        // Asegurar que el autoload esté cargado
        if (!class_exists(\Dompdf\Dompdf::class)) {
            require_once base_path('vendor/autoload.php');
        }

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        $html = $this->generarHtmlReporte($tipoReporte, $filtros);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $nombreArchivo = 'reporte_' . $tipoReporte . '_' . date('Y-m-d_His') . '.pdf';
        
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"');
    }

    private function aplicarFiltros(Request $request): array
    {
        $filtros = [
            'fecha_desde' => $request->input('fecha_desde'),
            'fecha_hasta' => $request->input('fecha_hasta'),
            'fundacion_id' => $request->input('fundacion_id'),
            'proveedor_id' => $request->input('proveedor_id'),
            'categoria_id' => $request->input('categoria_id'),
            'estado_orden' => $request->input('estado_orden'),
            'estado_producto' => $request->input('estado_producto'),
            'estado_proveedor' => $request->input('estado_proveedor'),
            'activo' => $request->input('activo'),
        ];

        return $filtros;
    }

    private function obtenerEstadisticas(array $filtros): array
    {
        // Consulta base de órdenes
        $queryOrdenes = Orden::query()
            ->selectRaw('orders.*')
            ->join('carts', 'orders.cart_id', '=', 'carts.id')
            ->leftJoin('users', 'carts.user_id', '=', 'users.id')
            ->leftJoin('suppliers', 'carts.supplier_id', '=', 'suppliers.id')
            ->leftJoin('foundations', 'carts.foundation_id', '=', 'foundations.id');

        // Aplicar filtros de fecha
        if (!empty($filtros['fecha_desde'])) {
            $queryOrdenes->whereRaw("DATE(orders.created_at) >= ?", [$filtros['fecha_desde']]);
        }
        if (!empty($filtros['fecha_hasta'])) {
            $queryOrdenes->whereRaw("DATE(orders.created_at) <= ?", [$filtros['fecha_hasta']]);
        }

        // Aplicar filtros de fundación y proveedor
        if (!empty($filtros['fundacion_id'])) {
            $queryOrdenes->where('carts.foundation_id', $filtros['fundacion_id']);
        }
        if (!empty($filtros['proveedor_id'])) {
            $queryOrdenes->where('carts.supplier_id', $filtros['proveedor_id']);
        }
        if (!empty($filtros['estado_orden'])) {
            $queryOrdenes->where('orders.estado', $filtros['estado_orden']);
        }

        // Consulta base de productos
        $queryProductos = Producto::query()
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id');

        if (!empty($filtros['categoria_id'])) {
            $queryProductos->where('products.category_id', $filtros['categoria_id']);
        }
        if (!empty($filtros['proveedor_id'])) {
            $queryProductos->where('products.supplier_id', $filtros['proveedor_id']);
        }
        if (!empty($filtros['estado_producto'])) {
            $queryProductos->where('products.estado', $filtros['estado_producto']);
        }

        // Consulta base de proveedores
        $queryProveedores = Proveedor::query();
        if (!empty($filtros['fundacion_id'])) {
            $queryProveedores->where('fundacion_id', $filtros['fundacion_id']);
        }
        if (!empty($filtros['estado_proveedor'])) {
            $queryProveedores->where('estado', $filtros['estado_proveedor']);
        }
        if ($filtros['activo'] !== null) {
            $queryProveedores->where('activo', $filtros['activo']);
        }

        // Consulta base de fundaciones
        $queryFundaciones = Fundacion::query();
        if ($filtros['activo'] !== null) {
            $queryFundaciones->where('activa', $filtros['activo']);
        }

        return [
            'total_ventas' => $queryOrdenes->sum('orders.total_amount') ?? 0,
            'total_ordenes' => $queryOrdenes->count(),
            'ordenes_completadas' => (clone $queryOrdenes)->where('orders.estado', 'completada')->count(),
            'ordenes_pendientes' => (clone $queryOrdenes)->where('orders.estado', 'pendiente')->count(),
            'total_productos' => $queryProductos->count(),
            'productos_activos' => (clone $queryProductos)->where('products.estado', 'activo')->count(),
            'total_proveedores' => $queryProveedores->count(),
            'proveedores_activos' => (clone $queryProveedores)->where('activo', true)->count(),
            'total_fundaciones' => $queryFundaciones->count(),
            'fundaciones_activas' => (clone $queryFundaciones)->where('activa', true)->count(),
        ];
    }

    private function generarReporteVentasExcel($sheet, array $filtros): void
    {
        $query = Orden::query()
            ->select([
                'orders.id',
                'orders.total_amount',
                'orders.estado',
                'orders.created_at',
                'users.name as usuario',
                'suppliers.name as proveedor',
                'foundations.name as fundacion',
            ])
            ->join('carts', 'orders.cart_id', '=', 'carts.id')
            ->leftJoin('users', 'carts.user_id', '=', 'users.id')
            ->leftJoin('suppliers', 'carts.supplier_id', '=', 'suppliers.id')
            ->leftJoin('foundations', 'carts.foundation_id', '=', 'foundations.id');

        if (!empty($filtros['fecha_desde'])) {
            $query->whereRaw("DATE(orders.created_at) >= ?", [$filtros['fecha_desde']]);
        }
        if (!empty($filtros['fecha_hasta'])) {
            $query->whereRaw("DATE(orders.created_at) <= ?", [$filtros['fecha_hasta']]);
        }
        if (!empty($filtros['fundacion_id'])) {
            $query->where('carts.foundation_id', $filtros['fundacion_id']);
        }
        if (!empty($filtros['proveedor_id'])) {
            $query->where('carts.supplier_id', $filtros['proveedor_id']);
        }
        if (!empty($filtros['estado_orden'])) {
            $query->where('orders.estado', $filtros['estado_orden']);
        }

        $ordenes = $query->orderBy('orders.created_at', 'desc')->get();

        // Encabezados
        $sheet->setCellValue('A1', 'ID Orden');
        $sheet->setCellValue('B1', 'Usuario');
        $sheet->setCellValue('C1', 'Proveedor');
        $sheet->setCellValue('D1', 'Fundación');
        $sheet->setCellValue('E1', 'Total');
        $sheet->setCellValue('F1', 'Estado');
        $sheet->setCellValue('G1', 'Fecha');

        // Estilo encabezados
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

        // Datos
        $row = 2;
        foreach ($ordenes as $orden) {
            $sheet->setCellValue('A' . $row, $orden->id);
            $sheet->setCellValue('B' . $row, $orden->usuario ?? 'N/A');
            $sheet->setCellValue('C' . $row, $orden->proveedor ?? 'N/A');
            $sheet->setCellValue('D' . $row, $orden->fundacion ?? 'N/A');
            $sheet->setCellValue('E' . $row, number_format($orden->total_amount, 2));
            $sheet->setCellValue('F' . $row, ucfirst($orden->estado));
            
            // Manejar fecha correctamente
            $fecha = null;
            if (isset($orden->created_at)) {
                $fecha = is_string($orden->created_at) ? \Carbon\Carbon::parse($orden->created_at) : $orden->created_at;
            } elseif (isset($orden->attributes['created_at'])) {
                $fecha = \Carbon\Carbon::parse($orden->attributes['created_at']);
            }
            $sheet->setCellValue('G' . $row, $fecha ? $fecha->format('Y-m-d H:i:s') : 'N/A');
            $row++;
        }

        // Ajustar ancho de columnas
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function generarReporteProductosExcel($sheet, array $filtros): void
    {
        $query = Producto::query()
            ->select([
                'products.id',
                'products.name',
                'products.price',
                'products.stock',
                'products.estado',
                'categories.name as categoria',
                'suppliers.name as proveedor',
            ])
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id');

        if (!empty($filtros['categoria_id'])) {
            $query->where('products.category_id', $filtros['categoria_id']);
        }
        if (!empty($filtros['proveedor_id'])) {
            $query->where('products.supplier_id', $filtros['proveedor_id']);
        }
        if (!empty($filtros['estado_producto'])) {
            $query->where('products.estado', $filtros['estado_producto']);
        }

        $productos = $query->orderBy('products.name')->get();

        // Encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Categoría');
        $sheet->setCellValue('D1', 'Proveedor');
        $sheet->setCellValue('E1', 'Precio');
        $sheet->setCellValue('F1', 'Stock');
        $sheet->setCellValue('G1', 'Estado');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($productos as $producto) {
            $sheet->setCellValue('A' . $row, $producto->id);
            $sheet->setCellValue('B' . $row, $producto->name);
            $sheet->setCellValue('C' . $row, $producto->categoria ?? 'N/A');
            $sheet->setCellValue('D' . $row, $producto->proveedor ?? 'N/A');
            $sheet->setCellValue('E' . $row, number_format($producto->price, 2));
            $sheet->setCellValue('F' . $row, $producto->stock);
            $sheet->setCellValue('G' . $row, ucfirst($producto->estado ?? 'N/A'));
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function generarReporteOrdenesExcel($sheet, array $filtros): void
    {
        $this->generarReporteVentasExcel($sheet, $filtros);
    }

    private function generarReporteProveedoresExcel($sheet, array $filtros): void
    {
        $query = Proveedor::query()
            ->select([
                'suppliers.id',
                'suppliers.name',
                'suppliers.email',
                'suppliers.phone',
                'suppliers.estado',
                'suppliers.activo',
                'foundations.name as fundacion',
            ])
            ->leftJoin('foundations', 'suppliers.fundacion_id', '=', 'foundations.id');

        if (!empty($filtros['fundacion_id'])) {
            $query->where('suppliers.fundacion_id', $filtros['fundacion_id']);
        }
        if (!empty($filtros['estado_proveedor'])) {
            $query->where('suppliers.estado', $filtros['estado_proveedor']);
        }
        if ($filtros['activo'] !== null) {
            $query->where('suppliers.activo', $filtros['activo']);
        }

        $proveedores = $query->orderBy('suppliers.name')->get();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Teléfono');
        $sheet->setCellValue('E1', 'Fundación');
        $sheet->setCellValue('F1', 'Estado');
        $sheet->setCellValue('G1', 'Activo');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($proveedores as $proveedor) {
            $sheet->setCellValue('A' . $row, $proveedor->id);
            $sheet->setCellValue('B' . $row, $proveedor->name);
            $sheet->setCellValue('C' . $row, $proveedor->email ?? 'N/A');
            $sheet->setCellValue('D' . $row, $proveedor->phone ?? 'N/A');
            $sheet->setCellValue('E' . $row, $proveedor->fundacion ?? 'N/A');
            $sheet->setCellValue('F' . $row, ucfirst($proveedor->estado ?? 'N/A'));
            $sheet->setCellValue('G' . $row, $proveedor->activo ? 'Sí' : 'No');
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function generarReporteFundacionesExcel($sheet, array $filtros): void
    {
        $query = Fundacion::query();

        if ($filtros['activo'] !== null) {
            $query->where('activa', $filtros['activo']);
        }

        $fundaciones = $query->orderBy('name')->get();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Misión');
        $sheet->setCellValue('D1', 'Dirección');
        $sheet->setCellValue('E1', 'Verificada');
        $sheet->setCellValue('F1', 'Activa');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

        $row = 2;
        foreach ($fundaciones as $fundacion) {
            $sheet->setCellValue('A' . $row, $fundacion->id);
            $sheet->setCellValue('B' . $row, $fundacion->name);
            $sheet->setCellValue('C' . $row, $fundacion->mission ?? 'N/A');
            $sheet->setCellValue('D' . $row, $fundacion->address ?? 'N/A');
            $sheet->setCellValue('E' . $row, $fundacion->verified ? 'Sí' : 'No');
            $sheet->setCellValue('F' . $row, $fundacion->activa ? 'Sí' : 'No');
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function generarHtmlReporte(string $tipoReporte, array $filtros): string
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte ' . ucfirst($tipoReporte) . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; border-bottom: 2px solid #4472C4; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #4472C4; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .header-info { margin-bottom: 20px; }
        .header-info p { margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Reporte de ' . ucfirst($tipoReporte) . '</h1>
    <div class="header-info">
        <p><strong>Fecha de generación:</strong> ' . date('d/m/Y H:i:s') . '</p>';

        if (!empty($filtros['fecha_desde']) || !empty($filtros['fecha_hasta'])) {
            $html .= '<p><strong>Período:</strong> ';
            $html .= $filtros['fecha_desde'] ?? 'Inicio';
            $html .= ' - ';
            $html .= $filtros['fecha_hasta'] ?? 'Fin';
            $html .= '</p>';
        }

        $html .= '</div>';

        switch ($tipoReporte) {
            case 'ventas':
            case 'ordenes':
                $html .= $this->generarTablaVentasHtml($filtros);
                break;
            case 'productos':
                $html .= $this->generarTablaProductosHtml($filtros);
                break;
            case 'proveedores':
                $html .= $this->generarTablaProveedoresHtml($filtros);
                break;
            case 'fundaciones':
                $html .= $this->generarTablaFundacionesHtml($filtros);
                break;
        }

        $html .= '</body></html>';

        return $html;
    }

    private function generarTablaVentasHtml(array $filtros): string
    {
        $query = Orden::query()
            ->select([
                'orders.id',
                'orders.total_amount',
                'orders.estado',
                'orders.created_at',
                'users.name as usuario',
                'suppliers.name as proveedor',
                'foundations.name as fundacion',
            ])
            ->join('carts', 'orders.cart_id', '=', 'carts.id')
            ->leftJoin('users', 'carts.user_id', '=', 'users.id')
            ->leftJoin('suppliers', 'carts.supplier_id', '=', 'suppliers.id')
            ->leftJoin('foundations', 'carts.foundation_id', '=', 'foundations.id');

        if (!empty($filtros['fecha_desde'])) {
            $query->whereRaw("DATE(orders.created_at) >= ?", [$filtros['fecha_desde']]);
        }
        if (!empty($filtros['fecha_hasta'])) {
            $query->whereRaw("DATE(orders.created_at) <= ?", [$filtros['fecha_hasta']]);
        }
        if (!empty($filtros['fundacion_id'])) {
            $query->where('carts.foundation_id', $filtros['fundacion_id']);
        }
        if (!empty($filtros['proveedor_id'])) {
            $query->where('carts.supplier_id', $filtros['proveedor_id']);
        }
        if (!empty($filtros['estado_orden'])) {
            $query->where('orders.estado', $filtros['estado_orden']);
        }

        $ordenes = $query->orderBy('orders.created_at', 'desc')->get();

        $html = '<table>
            <thead>
                <tr>
                    <th>ID Orden</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Fundación</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($ordenes as $orden) {
            $html .= '<tr>
                <td>' . $orden->id . '</td>
                <td>' . ($orden->usuario ?? 'N/A') . '</td>
                <td>' . ($orden->proveedor ?? 'N/A') . '</td>
                <td>' . ($orden->fundacion ?? 'N/A') . '</td>
                <td>$' . number_format($orden->total_amount, 2) . '</td>
                <td>' . ucfirst($orden->estado) . '</td>
                <td>' . ($this->formatearFecha($orden->created_at ?? null)) . '</td>
            </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    private function generarTablaProductosHtml(array $filtros): string
    {
        $query = Producto::query()
            ->select([
                'products.id',
                'products.name',
                'products.price',
                'products.stock',
                'products.estado',
                'categories.name as categoria',
                'suppliers.name as proveedor',
            ])
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id');

        if (!empty($filtros['categoria_id'])) {
            $query->where('products.category_id', $filtros['categoria_id']);
        }
        if (!empty($filtros['proveedor_id'])) {
            $query->where('products.supplier_id', $filtros['proveedor_id']);
        }
        if (!empty($filtros['estado_producto'])) {
            $query->where('products.estado', $filtros['estado_producto']);
        }

        $productos = $query->orderBy('products.name')->get();

        $html = '<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($productos as $producto) {
            $html .= '<tr>
                <td>' . $producto->id . '</td>
                <td>' . $producto->name . '</td>
                <td>' . ($producto->categoria ?? 'N/A') . '</td>
                <td>' . ($producto->proveedor ?? 'N/A') . '</td>
                <td>$' . number_format($producto->price, 2) . '</td>
                <td>' . $producto->stock . '</td>
                <td>' . ucfirst($producto->estado ?? 'N/A') . '</td>
            </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    private function generarTablaProveedoresHtml(array $filtros): string
    {
        $query = Proveedor::query()
            ->select([
                'suppliers.id',
                'suppliers.name',
                'suppliers.email',
                'suppliers.phone',
                'suppliers.estado',
                'suppliers.activo',
                'foundations.name as fundacion',
            ])
            ->leftJoin('foundations', 'suppliers.fundacion_id', '=', 'foundations.id');

        if (!empty($filtros['fundacion_id'])) {
            $query->where('suppliers.fundacion_id', $filtros['fundacion_id']);
        }
        if (!empty($filtros['estado_proveedor'])) {
            $query->where('suppliers.estado', $filtros['estado_proveedor']);
        }
        if ($filtros['activo'] !== null) {
            $query->where('suppliers.activo', $filtros['activo']);
        }

        $proveedores = $query->orderBy('suppliers.name')->get();

        $html = '<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fundación</th>
                    <th>Estado</th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($proveedores as $proveedor) {
            $html .= '<tr>
                <td>' . $proveedor->id . '</td>
                <td>' . $proveedor->name . '</td>
                <td>' . ($proveedor->email ?? 'N/A') . '</td>
                <td>' . ($proveedor->phone ?? 'N/A') . '</td>
                <td>' . ($proveedor->fundacion ?? 'N/A') . '</td>
                <td>' . ucfirst($proveedor->estado ?? 'N/A') . '</td>
                <td>' . ($proveedor->activo ? 'Sí' : 'No') . '</td>
            </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    private function generarTablaFundacionesHtml(array $filtros): string
    {
        $query = Fundacion::query();

        if ($filtros['activo'] !== null) {
            $query->where('activa', $filtros['activo']);
        }

        $fundaciones = $query->orderBy('name')->get();

        $html = '<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Misión</th>
                    <th>Dirección</th>
                    <th>Verificada</th>
                    <th>Activa</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($fundaciones as $fundacion) {
            $html .= '<tr>
                <td>' . $fundacion->id . '</td>
                <td>' . $fundacion->name . '</td>
                <td>' . ($fundacion->mission ?? 'N/A') . '</td>
                <td>' . ($fundacion->address ?? 'N/A') . '</td>
                <td>' . ($fundacion->verified ? 'Sí' : 'No') . '</td>
                <td>' . ($fundacion->activa ? 'Sí' : 'No') . '</td>
            </tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    private function formatearFecha($fecha): string
    {
        if (empty($fecha)) {
            return 'N/A';
        }
        
        try {
            if (is_string($fecha)) {
                return \Carbon\Carbon::parse($fecha)->format('d/m/Y H:i');
            }
            if ($fecha instanceof \Carbon\Carbon) {
                return $fecha->format('d/m/Y H:i');
            }
            return 'N/A';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
}

