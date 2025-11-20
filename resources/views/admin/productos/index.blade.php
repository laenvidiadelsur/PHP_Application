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
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Listado de productos</h3>
            <a href="{{ route('admin.productos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Nuevo producto
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Unidad</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Proveedor</th>
                            <th>Fundación</th>
                            <th class="text-center">Estado</th>
                            <th class="text-right pr-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                            <tr>
                                <td>
                                    <strong>{{ $producto->nombre }}</strong>
                                    <p class="mb-0 text-muted small">{{ \Illuminate\Support\Str::limit($producto->descripcion, 60) }}</p>
                                </td>
                                <td>{{ \Illuminate\Support\Str::ucfirst($producto->categoria) }}</td>
                                <td>{{ strtoupper($producto->unidad) }}</td>
                                <td>Bs {{ number_format((float) $producto->precio, 2, ',', '.') }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>{{ optional($producto->proveedor)->nombre ?? '—' }}</td>
                                <td>{{ optional($producto->fundacion)->nombre ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $producto->estado === 'activo' ? 'success' : 'secondary' }}">
                                        {{ \Illuminate\Support\Str::ucfirst($producto->estado) }}
                                    </span>
                                </td>
                                <td class="text-right pr-4">
                                    <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar este producto?');">
                                            <i class="fas fa-trash"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    No hay productos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($productos->hasPages())
            <div class="card-footer">
                {{ $productos->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>


