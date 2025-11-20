<x-layouts.admin :pageTitle="$pageTitle">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Listado de proveedores</h3>
            <a href="{{ route('admin.proveedores.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Nuevo proveedor
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Proveedor</th>
                            <th>NIT</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Tipo servicio</th>
                            <th>Fundación</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Activo</th>
                            <th class="text-right pr-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($proveedores as $proveedor)
                            <tr>
                                <td>
                                    <strong>{{ $proveedor->nombre }}</strong>
                                    <p class="mb-0 text-muted small">{{ $proveedor->direccion }}</p>
                                </td>
                                <td>{{ $proveedor->nit }}</td>
                                <td>{{ $proveedor->email }}</td>
                                <td>{{ $proveedor->telefono }}</td>
                                <td>{{ $proveedor->tipo_servicio }}</td>
                                <td>{{ optional($proveedor->fundacion)->nombre ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $proveedor->estado === 'aprobado' ? 'success' : ($proveedor->estado === 'rechazado' ? 'danger' : 'warning') }}">
                                        {{ \Illuminate\Support\Str::ucfirst($proveedor->estado) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if ($proveedor->activo)
                                        <span class="badge badge-success">Sí</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                                <td class="text-right pr-4">
                                    <a href="{{ route('admin.proveedores.edit', $proveedor) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.proveedores.destroy', $proveedor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar este proveedor?');">
                                            <i class="fas fa-trash"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    No hay proveedores registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($proveedores->hasPages())
            <div class="card-footer">
                {{ $proveedores->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>


