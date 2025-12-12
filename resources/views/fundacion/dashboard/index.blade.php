@extends('fundacion.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Filtros -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter"></i> Filtros</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('fundacion.dashboard') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_from">Fecha Desde</label>
                                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ $dateFrom }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_to">Fecha Hasta</label>
                                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ $dateTo }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="supplier_id">Proveedor</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                        <option value="">Todos los proveedores</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" {{ $supplierFilter == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Estado de Orden</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Todos los estados</option>
                                        <option value="pendiente" {{ $statusFilter == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completada" {{ $statusFilter == 'completada' ? 'selected' : '' }}>Completada</option>
                                        <option value="cancelada" {{ $statusFilter == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                        <option value="procesando" {{ $statusFilter == 'procesando' ? 'selected' : '' }}>Procesando</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                                <a href="{{ route('fundacion.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Limpiar Filtros
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs Principales -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $proveedoresCount }}</h3>
                    <p>Proveedores</p>
                </div>
                <div class="icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <a href="{{ route('fundacion.proveedores.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $productosCount }}</h3>
                    <p>Productos Disponibles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($totalRevenue, 2) }}</h3>
                    <p>Ingresos Totales (Bs.)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalOrders }}</h3>
                    <p>Total de Órdenes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos Principales -->
    <div class="row">
        <!-- Tendencias de Órdenes Mensuales -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Tendencias de Órdenes Mensuales
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="monthlyOrdersChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribución de Órdenes por Estado -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Órdenes por Estado
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="ordersStatusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top 5 Proveedores por Órdenes -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Top 5 Proveedores por Órdenes
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="topSuppliersChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribución de Productos por Categoría -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Distribución de Productos por Categoría
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="productsCategoryChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Proveedores Recientes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Proveedores Recientes</h3>
                </div>
                <div class="card-body">
                    @if($proveedoresRecientes->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Órdenes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proveedoresRecientes as $proveedor)
                                    <tr>
                                        <td>{{ $proveedor->name }}</td>
                                        <td>{{ $proveedor->email ?? 'N/A' }}</td>
                                        <td>{{ $proveedor->phone ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $proveedor->activo ? 'success' : 'danger' }}">
                                                {{ $proveedor->activo ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $ordersCount = $topProveedores->firstWhere('id', $proveedor->id)->orders_count ?? 0;
                                            @endphp
                                            {{ $ordersCount }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center py-4">No hay proveedores registrados aún.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos para los gráficos
    const monthlyOrdersData = @json($monthlyOrders);
    const ordersStatusData = @json($ordenesPorEstado);
    const topSuppliersData = @json($topProveedores);
    const productsCategoryData = @json($productosPorCategoria);

    // Gráfico de Tendencias de Órdenes Mensuales
    const monthlyOrdersCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
    const monthlyOrdersChart = new Chart(monthlyOrdersCtx, {
        type: 'line',
        data: {
            labels: monthlyOrdersData.map(item => item.month),
            datasets: [
                {
                    label: 'Número de Órdenes',
                    data: monthlyOrdersData.map(item => item.count),
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Ingresos (Bs.)',
                    data: monthlyOrdersData.map(item => parseFloat(item.revenue || 0)),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Número de Órdenes'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Ingresos (Bs.)'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    // Gráfico de Distribución de Órdenes por Estado
    const ordersStatusCtx = document.getElementById('ordersStatusChart').getContext('2d');
    const ordersStatusChart = new Chart(ordersStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ordersStatusData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1)),
            datasets: [{
                data: ordersStatusData.map(item => item.count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Top 5 Proveedores por Órdenes
    const topSuppliersCtx = document.getElementById('topSuppliersChart').getContext('2d');
    const topSuppliersChart = new Chart(topSuppliersCtx, {
        type: 'bar',
        data: {
            labels: topSuppliersData.map(item => item.name),
            datasets: [{
                label: 'Número de Órdenes',
                data: topSuppliersData.map(item => item.orders_count || 0),
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Órdenes: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico de Distribución de Productos por Categoría
    const productsCategoryCtx = document.getElementById('productsCategoryChart').getContext('2d');
    const productsCategoryChart = new Chart(productsCategoryCtx, {
        type: 'pie',
        data: {
            labels: productsCategoryData.map(item => item.categoria),
            datasets: [{
                data: productsCategoryData.map(item => item.total),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(199, 199, 199, 0.8)',
                    'rgba(83, 102, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' productos (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
