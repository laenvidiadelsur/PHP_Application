<x-layouts.admin :pageTitle="$pageTitle">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Detalle del carrito #{{ $carrito->id }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($carrito->items as $item)
                                    <tr>
                                        <td>{{ optional($item->producto)->nombre ?? 'N/A' }}</td>
                                        <td>{{ $item->cantidad }}</td>
                                        <td>Bs {{ number_format((float) $item->precio_unitario, 2, ',', '.') }}</td>
                                        <td>Bs {{ number_format((float) $item->subtotal, 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay items en este carrito.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total:</th>
                                    <th>Bs {{ number_format((float) $carrito->total, 2, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">Información</h3>
                </div>
                <div class="card-body">
                    <p><strong>Usuario:</strong> {{ optional($carrito->usuario)->nombre ?? 'Anónimo' }}</p>
                    <p><strong>Estado:</strong> 
                        <span class="badge badge-{{ $carrito->estado === 'activo' ? 'success' : 'warning' }}">
                            {{ ucfirst($carrito->estado) }}
                        </span>
                    </p>
                    <p><strong>Fecha creación:</strong> {{ $carrito->created_at->format('d/m/Y H:i') }}</p>
                    @if ($carrito->fecha_expiracion)
                        <p><strong>Fecha expiración:</strong> {{ $carrito->fecha_expiracion->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.carritos.index') }}" class="btn btn-secondary">Volver</a>
                    <a href="{{ route('admin.carritos.edit', $carrito) }}" class="btn btn-primary">Editar</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>

