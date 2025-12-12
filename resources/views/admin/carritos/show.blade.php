@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Detalle del Carrito #{{ $carrito->id }}</h2>
                <a href="{{ route('admin.carritos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información General</h3>
                </div>
                <div class="card-body">
                    <p><strong>Usuario:</strong> {{ $carrito->user->name ?? 'N/A' }}</p>
                    <p><strong>Proveedor:</strong> {{ $carrito->supplier->name ?? 'N/A' }}</p>
                    <p><strong>Fundación:</strong> {{ $carrito->foundation->name ?? 'N/A' }}</p>
                    <p><strong>Fecha de Creación:</strong> {{ $carrito->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Items del Carrito</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @forelse($carrito->items as $item)
                                @php 
                                    $subtotal = $item->quantity * ($item->product->price ?? 0);
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $item->product->name ?? 'Producto Eliminado' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->product->price ?? 0, 2) }}</td>
                                    <td>${{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">El carrito está vacío</td>
                                </tr>
                            @endforelse
                            @if($carrito->items->count() > 0)
                                <tr class="font-weight-bold">
                                    <td colspan="3" class="text-right">Total Estimado:</td>
                                    <td>${{ number_format($total, 2) }}</td>
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
