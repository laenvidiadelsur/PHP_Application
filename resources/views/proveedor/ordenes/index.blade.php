@extends('proveedor.layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-shopping-cart mr-2"></i>
                Mis Órdenes
            </h3>
        </div>
        <div class="card-body">
            <!-- Filtros -->
            <form method="GET" action="{{ route('proveedor.ordenes.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="procesando" {{ request('estado') === 'procesando' ? 'selected' : '' }}>Procesando</option>
                                <option value="completada" {{ request('estado') === 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from">Desde</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to">Hasta</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-filter mr-2"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Tabla de órdenes -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th># Orden</th>
                            <th>Cliente</th>
                            <th>Fundación</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ordenes as $orden)
                            <tr>
                                <td>#{{ str_pad($orden->id, 8, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $orden->cart->user->name ?? 'N/A' }}</td>
                                <td>{{ $orden->cart->foundation->name ?? 'N/A' }}</td>
                                <td>Bs {{ number_format($orden->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $orden->estado === 'completada' ? 'success' : 
                                        ($orden->estado === 'procesando' ? 'info' : 
                                        ($orden->estado === 'pendiente' ? 'warning' : 'danger')) 
                                    }}">
                                        {{ ucfirst($orden->estado) }}
                                    </span>
                                </td>
                                <td>{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('proveedor.ordenes.show', $orden) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay órdenes registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-3">
                {{ $ordenes->links() }}
            </div>
        </div>
    </div>
@endsection

