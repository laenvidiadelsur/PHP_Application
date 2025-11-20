<x-layouts.admin :pageTitle="$pageTitle">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title mb-0">Listado de carritos</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha creación</th>
                            <th class="text-right pr-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($carritos as $carrito)
                            <tr>
                                <td>#{{ $carrito->id }}</td>
                                <td>{{ optional($carrito->usuario)->nombre ?? 'Anónimo' }}</td>
                                <td>{{ $carrito->items->count() }} items</td>
                                <td>Bs {{ number_format((float) $carrito->total, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-{{ $carrito->estado === 'activo' ? 'success' : ($carrito->estado === 'completado' ? 'info' : 'warning') }}">
                                        {{ ucfirst($carrito->estado) }}
                                    </span>
                                </td>
                                <td>{{ $carrito->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-right pr-4">
                                    <a href="{{ route('admin.carritos.show', $carrito) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="{{ route('admin.carritos.edit', $carrito) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.carritos.destroy', $carrito) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar este carrito?');">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No hay carritos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($carritos->hasPages())
            <div class="card-footer">
                {{ $carritos->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>

