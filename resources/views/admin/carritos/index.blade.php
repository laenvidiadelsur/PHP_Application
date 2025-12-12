@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Carritos de Compra</h2>
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
                            <th>Proveedor</th>
                            <th>Fundación</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($carritos as $carrito)
                            <tr>
                                <td>{{ $carrito->id }}</td>
                                <td>{{ $carrito->user->name ?? 'N/A' }}</td>
                                <td>{{ $carrito->supplier->name ?? 'N/A' }}</td>
                                <td>{{ $carrito->foundation->name ?? 'N/A' }}</td>
                                <td>{{ $carrito->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.carritos.show', $carrito) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <form action="{{ route('admin.carritos.destroy', $carrito) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este carrito?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay carritos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $carritos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
