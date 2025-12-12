@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
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
                        <li class="breadcrumb-item active">Reportes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Filtros -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter"></i> Filtros de Búsqueda
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reportes.index') }}" id="filtrosForm">
                        <div class="row">
                            <!-- Filtros de Fecha -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_desde">Fecha Desde</label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="fecha_desde" 
                                           name="fecha_desde" 
                                           value="{{ request('fecha_desde') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_hasta">Fecha Hasta</label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="fecha_hasta" 
                                           name="fecha_hasta" 
                                           value="{{ request('fecha_hasta') }}">
                                </div>
                            </div>

                            <!-- Filtro de Fundación -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fundacion_id">Fundación</label>
                                    <select class="form-control select2" 
                                            id="fundacion_id" 
                                            name="fundacion_id" 
                                            style="width: 100%;">
                                        <option value="">Todas las fundaciones</option>
                                        @foreach($fundaciones as $fundacion)
                                            <option value="{{ $fundacion->id }}" 
                                                    {{ request('fundacion_id') == $fundacion->id ? 'selected' : '' }}>
                                                {{ $fundacion->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Filtro de Proveedor -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="proveedor_id">Proveedor</label>
                                    <select class="form-control select2" 
                                            id="proveedor_id" 
                                            name="proveedor_id" 
                                            style="width: 100%;">
                                        <option value="">Todos los proveedores</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" 
                                                    {{ request('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Filtro de Categoría -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="categoria_id">Categoría</label>
                                    <select class="form-control select2" 
                                            id="categoria_id" 
                                            name="categoria_id" 
                                            style="width: 100%;">
                                        <option value="">Todas las categorías</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" 
                                                    {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Filtro de Estado de Orden -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="estado_orden">Estado de Orden</label>
                                    <select class="form-control" id="estado_orden" name="estado_orden">
                                        <option value="">Todos los estados</option>
                                        <option value="pendiente" {{ request('estado_orden') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completada" {{ request('estado_orden') == 'completada' ? 'selected' : '' }}>Completada</option>
                                        <option value="cancelada" {{ request('estado_orden') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Filtro de Estado de Producto -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="estado_producto">Estado de Producto</label>
                                    <select class="form-control" id="estado_producto" name="estado_producto">
                                        <option value="">Todos los estados</option>
                                        <option value="activo" {{ request('estado_producto') == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ request('estado_producto') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Filtro de Estado de Proveedor -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="estado_proveedor">Estado de Proveedor</label>
                                    <select class="form-control" id="estado_proveedor" name="estado_proveedor">
                                        <option value="">Todos los estados</option>
                                        <option value="pendiente" {{ request('estado_proveedor') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="aprobado" {{ request('estado_proveedor') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                        <option value="rechazado" {{ request('estado_proveedor') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Filtro de Activo -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="activo">Estado Activo</label>
                                    <select class="form-control" id="activo" name="activo">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Aplicar Filtros
                                </button>
                                <a href="{{ route('admin.reportes.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Limpiar Filtros
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>${{ number_format($estadisticas['total_ventas'], 2) }}</h3>
                            <p>Total de Ventas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $estadisticas['total_ordenes'] }}</h3>
                            <p>Total de Órdenes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $estadisticas['ordenes_pendientes'] }}</h3>
                            <p>Órdenes Pendientes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $estadisticas['ordenes_completadas'] }}</h3>
                            <p>Órdenes Completadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-primary">
                        <div class="inner">
                            <h3>{{ $estadisticas['total_productos'] }}</h3>
                            <p>Total de Productos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-success">
                        <div class="inner">
                            <h3>{{ $estadisticas['productos_activos'] }}</h3>
                            <p>Productos Activos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-info">
                        <div class="inner">
                            <h3>{{ $estadisticas['total_proveedores'] }}</h3>
                            <p>Total de Proveedores</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-warning">
                        <div class="inner">
                            <h3>{{ $estadisticas['total_fundaciones'] }}</h3>
                            <p>Total de Fundaciones</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exportación de Reportes -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-export"></i> Exportar Reportes
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted">Seleccione el tipo de reporte y el formato de exportación. Los filtros aplicados se incluirán en el reporte.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_reporte">Tipo de Reporte</label>
                                <select class="form-control" id="tipo_reporte" name="tipo_reporte">
                                    <option value="ventas">Reporte de Ventas</option>
                                    <option value="ordenes">Reporte de Órdenes</option>
                                    <option value="productos">Reporte de Productos</option>
                                    <option value="proveedores">Reporte de Proveedores</option>
                                    <option value="fundaciones">Reporte de Fundaciones</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success btn-lg mr-2" onclick="exportarExcel()">
                                <i class="fas fa-file-excel"></i> Exportar a Excel
                            </button>
                            <button type="button" class="btn btn-danger btn-lg" onclick="exportarPdf()">
                                <i class="fas fa-file-pdf"></i> Exportar a PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<style>
    .small-box {
        border-radius: 0.25rem;
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        display: block;
        margin-bottom: 20px;
        position: relative;
    }
    .small-box > .inner {
        padding: 10px;
    }
    .small-box > .small-box-footer {
        background-color: rgba(0,0,0,.1);
        color: rgba(255,255,255,.8);
        display: block;
        padding: 3px 0;
        position: relative;
        text-align: center;
        text-decoration: none;
        z-index: 10;
    }
    .small-box .icon {
        color: rgba(0,0,0,.15);
        z-index: 0;
    }
    .small-box .icon > i {
        font-size: 70px;
        position: absolute;
        right: 15px;
        top: 15px;
        transition: -webkit-transform .3s linear;
        transition: transform .3s linear;
        transition: transform .3s linear,-webkit-transform .3s linear;
    }
</style>
@endpush

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    // Inicializar Select2
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Seleccione una opción',
            allowClear: true
        });
    });

    function exportarExcel() {
        const tipoReporte = document.getElementById('tipo_reporte').value;
        const form = document.getElementById('filtrosForm');
        const formData = new FormData(form);
        formData.append('tipo_reporte', tipoReporte);
        formData.append('_token', '{{ csrf_token() }}');

        // Crear un formulario temporal para enviar la solicitud
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = '{{ route("admin.reportes.exportar.excel") }}';
        tempForm.style.display = 'none';

        // Agregar todos los campos del formulario de filtros
        for (const [key, value] of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            tempForm.appendChild(input);
        }

        document.body.appendChild(tempForm);
        tempForm.submit();
        document.body.removeChild(tempForm);
    }

    function exportarPdf() {
        const tipoReporte = document.getElementById('tipo_reporte').value;
        const form = document.getElementById('filtrosForm');
        const formData = new FormData(form);
        formData.append('tipo_reporte', tipoReporte);
        formData.append('_token', '{{ csrf_token() }}');

        // Crear un formulario temporal para enviar la solicitud
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = '{{ route("admin.reportes.exportar.pdf") }}';
        tempForm.style.display = 'none';

        // Agregar todos los campos del formulario de filtros
        for (const [key, value] of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            tempForm.appendChild(input);
        }

        document.body.appendChild(tempForm);
        tempForm.submit();
        document.body.removeChild(tempForm);
    }
</script>
@endpush
@endsection

