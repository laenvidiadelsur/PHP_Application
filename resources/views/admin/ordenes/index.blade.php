@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Órdenes</h2>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ordenes as $orden)
                            <tr>
                                <td>{{ $orden->id }}</td>
                                <td>{{ $orden->cart->user->name ?? 'N/A' }}</td>
                                <td>${{ number_format($orden->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $orden->estado === 'completada' ? 'success' : ($orden->estado === 'pendiente' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($orden->estado) }}
                                    </span>
                                </td>
                                <td>N/A</td>
                                <td>
                                    <a href="{{ route('admin.ordenes.show', $orden) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="{{ route('admin.ordenes.edit', $orden) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.ordenes.destroy', $orden) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar esta orden?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay órdenes registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $ordenes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
