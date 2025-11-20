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
            <h3 class="card-title mb-0">Listado de licencias</h3>
            <a href="{{ route('admin.licencias.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Nueva licencia
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Número</th>
                            <th>Titular</th>
                            <th>Estado</th>
                            <th>Vigencia desde</th>
                            <th>Vigencia hasta</th>
                            <th class="text-right pr-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($licencias as $licencia)
                            <tr>
                                <td><strong>{{ $licencia->numero }}</strong></td>
                                <td>{{ optional($licencia->titular)->nombre ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $licencia->estado === 'activa' ? 'success' : ($licencia->estado === 'vencida' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($licencia->estado) }}
                                    </span>
                                </td>
                                <td>{{ $licencia->vigencia_desde->format('d/m/Y') }}</td>
                                <td>{{ $licencia->vigencia_hasta ? $licencia->vigencia_hasta->format('d/m/Y') : '—' }}</td>
                                <td class="text-right pr-4">
                                    <a href="{{ route('admin.licencias.edit', $licencia) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.licencias.destroy', $licencia) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar esta licencia?');">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No hay licencias registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($licencias->hasPages())
            <div class="card-footer">
                {{ $licencias->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>

