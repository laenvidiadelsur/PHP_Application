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
            <h3 class="card-title mb-0">Listado de fundaciones</h3>
            <a href="{{ route('admin.fundaciones.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Nueva fundación
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>NIT</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Área de acción</th>
                            <th class="text-center">Activa</th>
                            <th class="text-right pr-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fundaciones as $fundacion)
                            <tr>
                                <td>
                                    <strong>{{ $fundacion->nombre }}</strong>
                                    <p class="mb-0 text-muted small">{{ $fundacion->direccion }}</p>
                                </td>
                                <td>{{ $fundacion->nit }}</td>
                                <td>{{ $fundacion->email }}</td>
                                <td>{{ $fundacion->telefono }}</td>
                                <td>{{ $fundacion->area_accion }}</td>
                                <td class="text-center">
                                    @if ($fundacion->activa)
                                        <span class="badge badge-success">Sí</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                                <td class="text-right pr-4">
                                    <a href="{{ route('admin.fundaciones.edit', $fundacion) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.fundaciones.destroy', $fundacion) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar esta fundación? Esta acción no se puede deshacer.');">
                                            <i class="fas fa-trash"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    No hay fundaciones registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($fundaciones->hasPages())
            <div class="card-footer">
                {{ $fundaciones->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>


