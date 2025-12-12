<x-layouts.admin :pageTitle="$pageTitle">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $pageTitle }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Fundaciones Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-building mr-2"></i>Fundaciones
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.fundaciones.index') }}" class="btn btn-sm btn-primary">
                                    Ver todas <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $totalFundaciones }}</h3>
                                            <p>Total Fundaciones</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <a href="{{ route('admin.fundaciones.index') }}" class="small-box-footer">
                                            Más información <i class="fas fa-arrow-circle-right"></i>
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
                                            Más información <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ $fundacionesVerificadas }}</h3>
                                            <p>Fundaciones Verificadas</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <a href="{{ route('admin.fundaciones.index') }}" class="small-box-footer">
                                            Más información <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1">
                                            <i class="fas fa-percent"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">% Activas</span>
                                            <span class="info-box-number">{{ $porcentajeFundacionesActivas }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($fundacionesRecientes->count() > 0)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>Fundaciones Recientes</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Estado</th>
                                                    <th>Verificada</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($fundacionesRecientes as $fundacion)
                                                <tr>
                                                    <td>{{ $fundacion->name }}</td>
                                                    <td>
                                                        @if($fundacion->activa)
                                                            <span class="badge badge-success">Activa</span>
                                                        @else
                                                            <span class="badge badge-secondary">Inactiva</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($fundacion->verified)
                                                            <span class="badge badge-info">Verificada</span>
                                                        @else
                                                            <span class="badge badge-warning">No verificada</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Proveedores Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-handshake mr-2"></i>Proveedores
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.proveedores.index') }}" class="btn btn-sm btn-primary">
                                    Ver todos <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3>{{ $totalProveedores }}</h3>
                                            <p>Total Proveedores</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-handshake"></i>
                                        </div>
                                        <a href="{{ route('admin.proveedores.index') }}" class="small-box-footer">
                                            Más información <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $proveedoresActivos }}</h3>
                                            <p>Proveedores Activos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <a href="{{ route('admin.proveedores.index') }}" class="small-box-footer">
                                            Más información <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-primary elevation-1">
                                            <i class="fas fa-percent"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">% Activos</span>
                                            <span class="info-box-number">{{ $porcentajeProveedoresActivos }}%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success elevation-1">
                                            <i class="fas fa-boxes"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Top Proveedor</span>
                                            <span class="info-box-number">
                                                @if($topProveedores->count() > 0)
                                                    {{ $topProveedores->first()->productos_count }} productos
                                                @else
                                                    0
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($proveedoresRecientes->count() > 0)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>Proveedores Recientes</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Contacto</th>
                                                    <th>Email</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($proveedoresRecientes as $proveedor)
                                                <tr>
                                                    <td>{{ $proveedor->name }}</td>
                                                    <td>{{ $proveedor->contact_name ?? 'N/A' }}</td>
                                                    <td>{{ $proveedor->email ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($proveedor->activo)
                                                            <span class="badge badge-success">Activo</span>
                                                        @else
                                                            <span class="badge badge-secondary">Inactivo</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-boxes mr-2"></i>Productos
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.productos.index') }}" class="btn btn-sm btn-primary">
                                    Ver todos <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $totalProductos }}</h3>
                                            <p>Total Productos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-boxes"></i>
                                        </div>
                                        <a href="{{ route('admin.productos.index') }}" class="small-box-footer">
                                            Más información <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $productosActivos }}</h3>
                                            <p>Productos Activos</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <a href="{{ route('admin.productos.index') }}" class="small-box-footer">
                                            Más información <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ $productosBajoStock }}</h3>
                                            <p>Bajo Stock (< 10)</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <a href="{{ route('admin.productos.index') }}" class="small-box-footer">
                                            Más información <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success elevation-1">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Valor Inventario</span>
                                            <span class="info-box-number">${{ number_format($valorTotalInventario, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Productos por Categoría</h3>
                                        </div>
                                        <div class="card-body">
                                            @if($productosPorCategoria->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Categoría</th>
                                                                <th>Cantidad</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($productosPorCategoria as $item)
                                                            <tr>
                                                                <td>{{ $item['categoria'] }}</td>
                                                                <td><span class="badge badge-primary">{{ $item['total'] }}</span></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">No hay productos categorizados</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Top Proveedores</h3>
                                        </div>
                                        <div class="card-body">
                                            @if($topProveedores->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Proveedor</th>
                                                                <th>Productos</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($topProveedores as $proveedor)
                                                            <tr>
                                                                <td>{{ $proveedor->name }}</td>
                                                                <td><span class="badge badge-success">{{ $proveedor->productos_count }}</span></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">No hay proveedores con productos</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($productosRecientes->count() > 0)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>Productos Recientes</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Proveedor</th>
                                                    <th>Categoría</th>
                                                    <th>Precio</th>
                                                    <th>Stock</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($productosRecientes as $producto)
                                                <tr>
                                                    <td>{{ $producto->name }}</td>
                                                    <td>{{ $producto->supplier->name ?? 'N/A' }}</td>
                                                    <td>{{ $producto->category->name ?? 'Sin categoría' }}</td>
                                                    <td>${{ number_format($producto->price, 2) }}</td>
                                                    <td>
                                                        @if($producto->stock < 10)
                                                            <span class="badge badge-warning">{{ $producto->stock }}</span>
                                                        @else
                                                            <span class="badge badge-success">{{ $producto->stock }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $producto->estado === 'activo' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($producto->estado) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Órdenes y Carritos Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-invoice mr-2"></i>Órdenes
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.ordenes.index') }}" class="btn btn-sm btn-primary">
                                    Ver todas <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1">
                                            <i class="fas fa-shopping-cart"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Órdenes</span>
                                            <span class="info-box-number">{{ $totalOrdenes }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success elevation-1">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Ingresos Totales</span>
                                            <span class="info-box-number">${{ number_format($totalIngresos, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning elevation-1">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Pendientes</span>
                                            <span class="info-box-number">{{ $ordenesPendientes }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success elevation-1">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Completadas</span>
                                            <span class="info-box-number">{{ $ordenesCompletadas }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($ordenesPorEstado->count() > 0)
                            <div class="mt-3">
                                <h6>Órdenes por Estado</h6>
                                @foreach($ordenesPorEstado as $estado)
                                <div class="progress-group">
                                    <span class="progress-text">{{ ucfirst($estado->status) }}</span>
                                    <span class="float-right"><b>{{ $estado->count }}</b></span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: {{ $totalOrdenes > 0 ? ($estado->count / $totalOrdenes * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-shopping-cart mr-2"></i>Carritos
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.carritos.index') }}" class="btn btn-sm btn-primary">
                                    Ver todos <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-primary elevation-1">
                                            <i class="fas fa-shopping-cart"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Carritos</span>
                                            <span class="info-box-number">{{ $totalCarritos }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning elevation-1">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Carritos Activos</span>
                                            <span class="info-box-number">{{ $carritosActivos }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuarios y Categorías Section -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-2"></i>Usuarios
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-sm btn-primary">
                                    Ver todos <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="fas fa-users"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Usuarios</span>
                                    <span class="info-box-number">{{ $totalUsuarios }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-tags mr-2"></i>Categorías
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-primary">
                                    Ver todas <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success elevation-1">
                                            <i class="fas fa-tags"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Categorías</span>
                                            <span class="info-box-number">{{ $totalCategorias }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-primary elevation-1">
                                            <i class="fas fa-boxes"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Con Productos</span>
                                            <span class="info-box-number">{{ $categoriasConProductos }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.admin>
