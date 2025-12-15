@extends('proveedor.layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Orden #{{ $orden->numero_orden }}
                </h2>
                <a href="{{ route('proveedor.ordenes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información de la Orden -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información de la Orden
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Estado Actual:</strong>
                        <div class="mt-2">
                            <span class="badge badge-{{ 
                                $orden->estado === 'completada' ? 'success' : 
                                ($orden->estado === 'procesando' ? 'info' : 
                                ($orden->estado === 'pendiente' ? 'warning' : 'danger')) 
                            }} badge-lg">
                                {{ ucfirst($orden->estado) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <strong><i class="fas fa-user mr-2"></i> Cliente:</strong><br>
                        {{ $orden->cart->user->name ?? 'N/A' }}
                    </div>

                    <div class="mb-2">
                        <strong><i class="fas fa-envelope mr-2"></i> Email:</strong><br>
                        {{ $orden->cart->user->email ?? 'N/A' }}
                    </div>

                    <div class="mb-2">
                        <strong><i class="fas fa-building mr-2"></i> Fundación:</strong><br>
                        {{ $orden->cart->foundation->name ?? 'N/A' }}
                    </div>

                    <hr>

                    <div class="mb-2">
                        <strong><i class="fas fa-calendar mr-2"></i> Fecha:</strong><br>
                        {{ $orden->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div class="mb-2">
                        <strong><i class="fas fa-money-bill-wave mr-2"></i> Total:</strong><br>
                        <span class="h4 text-primary">Bs {{ number_format($orden->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Cambiar Estado -->
            <div class="card mt-3">
                <div class="card-header bg-warning">
                    <h3 class="card-title text-white">
                        <i class="fas fa-edit mr-2"></i>
                        Cambiar Estado
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('proveedor.ordenes.update-estado', $orden) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="estado">Nuevo Estado <span class="text-danger">*</span></label>
                            <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror" required>
                                <option value="pendiente" {{ $orden->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="procesando" {{ $orden->estado === 'procesando' ? 'selected' : '' }}>Procesando</option>
                                <option value="completada" {{ $orden->estado === 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada" {{ $orden->estado === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-save mr-2"></i> Actualizar Estado
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Items de la Orden -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title text-white">
                        <i class="fas fa-boxes mr-2"></i>
                        Productos de esta Orden
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotalTotal = 0;
                                @endphp
                                @forelse($items as $item)
                                    @php 
                                        $subtotal = $item->quantity * ($item->product->price ?? 0);
                                        $subtotalTotal += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product->name ?? 'Producto Eliminado' }}</strong>
                                        </td>
                                        <td>{{ $item->product->category->name ?? 'Sin categoría' }}</td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $item->quantity }}</span>
                                        </td>
                                        <td>Bs {{ number_format($item->product->price ?? 0, 2) }}</td>
                                        <td><strong>Bs {{ number_format($subtotal, 2) }}</strong></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">No hay productos en esta orden</p>
                                        </td>
                                    </tr>
                                @endforelse
                                @if($items->count() > 0)
                                    <tr class="table-info font-weight-bold">
                                        <td colspan="4" class="text-right">Subtotal (solo productos de este proveedor):</td>
                                        <td>Bs {{ number_format($subtotalTotal, 2) }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

