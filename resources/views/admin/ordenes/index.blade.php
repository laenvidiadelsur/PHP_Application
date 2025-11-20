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
            <h3 class="card-title mb-0">Listado de órdenes</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Número</th>
                            <th>Usuario</th>
                            <th>Total</th>
                            <th>Estado pago</th>
                            <th>Estado envío</th>
                            <th>Fecha</th>
                            <th class="text-right pr-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ordenes as $orden)
                            <tr>
                                <td><strong>{{ $orden->numero_orden }}</strong></td>
                                <td>{{ optional($orden->usuario)->nombre ?? 'N/A' }}</td>
                                <td>Bs {{ number_format((float) $orden->total, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-{{ $orden->estado_pago === 'completado' ? 'success' : ($orden->estado_pago === 'fallido' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($orden->estado_pago) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $orden->estado_envio === 'entregado' ? 'success' : ($orden->estado_envio === 'cancelado' ? 'danger' : 'info') }}">
                                        {{ ucfirst($orden->estado_envio) }}
                                    </span>
                                </td>
                                <td>{{ $orden->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-right pr-4">
                                    <a href="{{ route('admin.ordenes.show', $orden) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="{{ route('admin.ordenes.edit', $orden) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.ordenes.destroy', $orden) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Deseas eliminar esta orden?');">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No hay órdenes registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($ordenes->hasPages())
            <div class="card-footer">
                {{ $ordenes->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>

