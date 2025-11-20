<x-layouts.admin :pageTitle="$pageTitle">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Detalle de la orden {{ $orden->numero_orden }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Proveedor</th>
                                    <th>Cantidad</th>
                                    <th>Precio unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orden->items as $item)
                                    <tr>
                                        <td>{{ $item->nombre ?? optional($item->producto)->nombre ?? 'N/A' }}</td>
                                        <td>{{ optional($item->proveedor)->nombre ?? 'N/A' }}</td>
                                        <td>{{ $item->cantidad }}</td>
                                        <td>Bs {{ number_format((float) $item->precio_unitario, 2, ',', '.') }}</td>
                                        <td>Bs {{ number_format((float) $item->subtotal, 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay items en esta orden.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Subtotal:</th>
                                    <th>Bs {{ number_format((float) $orden->subtotal, 2, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Impuestos:</th>
                                    <th>Bs {{ number_format((float) $orden->impuestos, 2, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Envío:</th>
                                    <th>Bs {{ number_format((float) $orden->envio, 2, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Total:</th>
                                    <th>Bs {{ number_format((float) $orden->total, 2, ',', '.') }}</th>
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
                    <p><strong>Usuario:</strong> {{ optional($orden->usuario)->nombre ?? 'N/A' }}</p>
                    <p><strong>Estado pago:</strong> 
                        <span class="badge badge-{{ $orden->estado_pago === 'completado' ? 'success' : 'warning' }}">
                            {{ ucfirst($orden->estado_pago) }}
                        </span>
                    </p>
                    <p><strong>Estado envío:</strong> 
                        <span class="badge badge-{{ $orden->estado_envio === 'entregado' ? 'success' : 'info' }}">
                            {{ ucfirst($orden->estado_envio) }}
                        </span>
                    </p>
                    <p><strong>Método pago:</strong> {{ ucfirst($orden->metodo_pago) }}</p>
                    <p><strong>Fecha creación:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>
                    @if ($orden->fecha_pago)
                        <p><strong>Fecha pago:</strong> {{ $orden->fecha_pago->format('d/m/Y H:i') }}</p>
                    @endif
                    @if ($orden->contacto_nombre)
                        <hr>
                        <p><strong>Contacto:</strong> {{ $orden->contacto_nombre }}</p>
                        <p><strong>Teléfono:</strong> {{ $orden->contacto_telefono }}</p>
                        <p><strong>Email:</strong> {{ $orden->contacto_email }}</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.ordenes.index') }}" class="btn btn-secondary">Volver</a>
                    <a href="{{ route('admin.ordenes.edit', $orden) }}" class="btn btn-primary">Editar</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>

