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
            <h3 class="card-title mb-0">Listado de usuarios</h3>
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Nuevo usuario
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Fundación/Proveedor</th>
                            <th class="text-center">Activo</th>
                            <th class="text-right pr-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                            <tr>
                                <td><strong>{{ $usuario->nombre }}</strong></td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    <span class="badge badge-info">{{ ucfirst($usuario->rol) }}</span>
                                </td>
                                <td>
                                    @if ($usuario->fundacion)
                                        {{ $usuario->fundacion->nombre }}
                                    @elseif ($usuario->proveedor)
                                        {{ $usuario->proveedor->nombre }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($usuario->activo)
                                        <span class="badge badge-success">Sí</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>
                                <td class="text-right pr-4">
                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar este usuario?');">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($usuarios->hasPages())
            <div class="card-footer">
                {{ $usuarios->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>

