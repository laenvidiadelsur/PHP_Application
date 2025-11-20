<x-layouts.admin :pageTitle="$pageTitle">
    <!-- Sección: Estadísticas Generales -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Resumen General</h5>
                <p>Vista general de las entidades principales del sistema: Fundaciones, Proveedores y Productos.</p>
            </div>
        </div>
    </div>

    <!-- Small Boxes - Fundaciones -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3"><i class="fas fa-building text-primary"></i> Fundaciones</h4>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalFundaciones }}</h3>
                    <p>Total Fundaciones</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('admin.fundaciones.index') }}" class="small-box-footer">
                    Ver todas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $fundacionesActivas }}</h3>
                    <p>Fundaciones Activas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('admin.fundaciones.index') }}" class="small-box-footer">
                    Ver activas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $fundacionesInactivas }}</h3>
                    <p>Fundaciones Inactivas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-pause-circle"></i>
                </div>
                <a href="{{ route('admin.fundaciones.index') }}" class="small-box-footer">
                    Ver inactivas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $porcentajeFundacionesActivas }}<sup style="font-size: 20px">%</sup></h3>
                    <p>Tasa de Actividad</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="{{ route('admin.fundaciones.index') }}" class="small-box-footer">
                    Ver estadísticas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Small Boxes - Proveedores -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3"><i class="fas fa-handshake text-success"></i> Proveedores</h4>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalProveedores }}</h3>
                    <p>Total Proveedores</p>
                </div>
                <div class="icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <a href="{{ route('admin.proveedores.index') }}" class="small-box-footer">
                    Ver todos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $proveedoresActivos }}</h3>
                    <p>Proveedores Activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
                <a href="{{ route('admin.proveedores.index') }}" class="small-box-footer">
                    Ver activos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $proveedoresAprobados }}</h3>
                    <p>Proveedores Aprobados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-thumbs-up"></i>
                </div>
                <a href="{{ route('admin.proveedores.index') }}" class="small-box-footer">
                    Ver aprobados <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $proveedoresPendientes }}</h3>
                    <p>Pendientes de Aprobación</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('admin.proveedores.index') }}" class="small-box-footer">
                    Ver pendientes <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Small Boxes - Productos -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3"><i class="fas fa-boxes text-warning"></i> Productos</h4>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalProductos }}</h3>
                    <p>Total Productos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <a href="{{ route('admin.productos.index') }}" class="small-box-footer">
                    Ver todos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $productosActivos }}</h3>
                    <p>Productos Activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <a href="{{ route('admin.productos.index') }}" class="small-box-footer">
                    Ver activos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $productosBajoStock }}</h3>
                    <p>Bajo Stock (< 10)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('admin.productos.index') }}" class="small-box-footer">
                    Ver alertas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Bs {{ number_format((float) $valorTotalInventario, 2, ',', '.') }}</h3>
                    <p>Valor Total Inventario</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="{{ route('admin.productos.index') }}" class="small-box-footer">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Sección: Información Detallada -->
    <div class="row">
        <!-- Info Boxes - Fundaciones -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-building"></i> Fundaciones</h3>
                </div>
                <div class="card-body">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total</span>
                            <span class="info-box-number">{{ $totalFundaciones }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Activas</span>
                            <span class="info-box-number">{{ $fundacionesActivas }}</span>
                        </div>
                    </div>
                    <div class="progress-group">
                        Fundaciones Activas
                        <span class="float-right"><b>{{ $fundacionesActivas }}</b>/{{ $totalFundaciones }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: {{ $porcentajeFundacionesActivas }}%"></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.fundaciones.create') }}" class="btn btn-primary btn-sm btn-block">
                            <i class="fas fa-plus"></i> Nueva Fundación
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Boxes - Proveedores -->
        <div class="col-md-4">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-handshake"></i> Proveedores</h3>
                </div>
                <div class="card-body">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success"><i class="fas fa-handshake"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total</span>
                            <span class="info-box-number">{{ $totalProveedores }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary"><i class="fas fa-thumbs-up"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Aprobados</span>
                            <span class="info-box-number">{{ $proveedoresAprobados }}</span>
                        </div>
                    </div>
                    <div class="progress-group">
                        Tasa de Aprobación
                        <span class="float-right"><b>{{ $proveedoresAprobados }}</b>/{{ $totalProveedores }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width: {{ $porcentajeProveedoresAprobados }}%"></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.proveedores.create') }}" class="btn btn-success btn-sm btn-block">
                            <i class="fas fa-plus"></i> Nuevo Proveedor
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Boxes - Productos -->
        <div class="col-md-4">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-boxes"></i> Productos</h3>
                </div>
                <div class="card-body">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning"><i class="fas fa-boxes"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total</span>
                            <span class="info-box-number">{{ $totalProductos }}</span>
                        </div>
                    </div>
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Bajo Stock</span>
                            <span class="info-box-number">{{ $productosBajoStock }}</span>
                        </div>
                    </div>
                    <div class="progress-group">
                        Productos Activos
                        <span class="float-right"><b>{{ $productosActivos }}</b>/{{ $totalProductos }}</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: {{ $porcentajeProductosActivos }}%"></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.productos.create') }}" class="btn btn-warning btn-sm btn-block">
                            <i class="fas fa-plus"></i> Nuevo Producto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección: Distribución y Análisis -->
    <div class="row mt-4">
        <!-- Productos por Categoría -->
        <div class="col-md-6">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie"></i> Productos por Categoría</h3>
                </div>
                <div class="card-body">
                    @forelse ($productosPorCategoria as $categoria)
                        <div class="progress-group mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span><strong>{{ ucfirst($categoria->categoria) }}</strong></span>
                                <span><b>{{ $categoria->total }}</b> productos</span>
                            </div>
                            <div class="progress progress-sm">
                                @php
                                    $porcentaje = $totalProductos > 0 ? round(($categoria->total / $totalProductos) * 100, 1) : 0;
                                @endphp
                                <div class="progress-bar bg-info" style="width: {{ $porcentaje }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No hay productos registrados.</p>
                    @endforelse
                    <div class="mt-3">
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-info btn-sm btn-block">
                            <i class="fas fa-eye"></i> Ver Todos los Productos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos por Fundación -->
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-sitemap"></i> Productos por Fundación</h3>
                </div>
                <div class="card-body">
                    @forelse ($productosPorFundacion as $item)
                        <div class="progress-group mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span><strong>{{ $item['fundacion'] }}</strong></span>
                                <span><b>{{ $item['total'] }}</b> productos</span>
                            </div>
                            <div class="progress progress-sm">
                                @php
                                    $porcentaje = $totalProductos > 0 ? round(($item['total'] / $totalProductos) * 100, 1) : 0;
                                @endphp
                                <div class="progress-bar bg-primary" style="width: {{ $porcentaje }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No hay productos distribuidos por fundación.</p>
                    @endforelse
                    <div class="mt-3">
                        <a href="{{ route('admin.fundaciones.index') }}" class="btn btn-primary btn-sm btn-block">
                            <i class="fas fa-eye"></i> Ver Todas las Fundaciones
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección: Top Proveedores -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-trophy"></i> Top 5 Proveedores por Cantidad de Productos</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Proveedor</th>
                                <th>Fundación</th>
                                <th>Estado</th>
                                <th class="text-center">Productos</th>
                                <th class="text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topProveedores as $index => $proveedor)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $proveedor->nombre }}</strong></td>
                                    <td>{{ optional($proveedor->fundacion)->nombre ?? '—' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $proveedor->estado === 'aprobado' ? 'success' : ($proveedor->estado === 'pendiente' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($proveedor->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info">{{ $proveedor->productos_count }}</span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.proveedores.edit', $proveedor) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3">No hay proveedores registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.proveedores.index') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-list"></i> Ver Todos los Proveedores
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección: Registros Recientes -->
    <div class="row mt-4">
        <!-- Fundaciones Recientes -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clock"></i> Fundaciones Recientes</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse ($fundacionesRecientes as $fundacion)
                            <li class="item">
                                <div class="product-img">
                                    <i class="fas fa-building fa-2x text-primary"></i>
                                </div>
                                <div class="product-info">
                                    <a href="{{ route('admin.fundaciones.edit', $fundacion) }}" class="product-title">
                                        {{ $fundacion->nombre }}
                                        <span class="badge badge-{{ $fundacion->activa ? 'success' : 'secondary' }} float-right">
                                            {{ $fundacion->activa ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </a>
                                    <span class="product-description">
                                        {{ $fundacion->area_accion }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item p-3 text-center text-muted">No hay fundaciones recientes.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.fundaciones.index') }}" class="uppercase">Ver todas las fundaciones</a>
                </div>
            </div>
        </div>

        <!-- Proveedores Recientes -->
        <div class="col-md-4">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clock"></i> Proveedores Recientes</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse ($proveedoresRecientes as $proveedor)
                            <li class="item">
                                <div class="product-img">
                                    <i class="fas fa-handshake fa-2x text-success"></i>
                                </div>
                                <div class="product-info">
                                    <a href="{{ route('admin.proveedores.edit', $proveedor) }}" class="product-title">
                                        {{ $proveedor->nombre }}
                                        <span class="badge badge-{{ $proveedor->estado === 'aprobado' ? 'success' : ($proveedor->estado === 'pendiente' ? 'warning' : 'danger') }} float-right">
                                            {{ ucfirst($proveedor->estado) }}
                                        </span>
                                    </a>
                                    <span class="product-description">
                                        {{ optional($proveedor->fundacion)->nombre ?? 'Sin fundación' }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item p-3 text-center text-muted">No hay proveedores recientes.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.proveedores.index') }}" class="uppercase">Ver todos los proveedores</a>
                </div>
            </div>
        </div>

        <!-- Productos Recientes -->
        <div class="col-md-4">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clock"></i> Productos Recientes</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse ($productosRecientes as $producto)
                            <li class="item">
                                <div class="product-img">
                                    <i class="fas fa-box fa-2x text-warning"></i>
                                </div>
                                <div class="product-info">
                                    <a href="{{ route('admin.productos.edit', $producto) }}" class="product-title">
                                        {{ $producto->nombre }}
                                        <span class="badge badge-{{ $producto->estado === 'activo' ? 'success' : 'secondary' }} float-right">
                                            Bs {{ number_format((float) $producto->precio, 2, ',', '.') }}
                                        </span>
                                    </a>
                                    <span class="product-description">
                                        {{ ucfirst($producto->categoria) }} - Stock: {{ $producto->stock }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item p-3 text-center text-muted">No hay productos recientes.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.productos.index') }}" class="uppercase">Ver todos los productos</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección: Acciones Rápidas -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bolt"></i> Acciones Rápidas</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.fundaciones.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i><br>
                                Nueva Fundación
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.proveedores.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-plus"></i><br>
                                Nuevo Proveedor
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.productos.create') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-plus"></i><br>
                                Nuevo Producto
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.fundaciones.index') }}" class="btn btn-info btn-block">
                                <i class="fas fa-list"></i><br>
                                Ver Todos los CRUDs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
