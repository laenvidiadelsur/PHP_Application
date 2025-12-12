@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Detalle de Orden #{{ $orden->id }}</h2>
                <a href="{{ route('admin.ordenes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información de la Orden</h3>
                </div>
                <div class="card-body">
                    <p><strong>Estado:</strong> 
                        <span class="badge badge-{{ $orden->status === 'completed' ? 'success' : ($orden->status === 'pending' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($orden->status) }}
                        </span>
                    </p>
                    <p><strong>Total:</strong> ${{ number_format($orden->total_amount, 2) }}</p>
                    <p><strong>Fecha:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>
                    <hr>
                    <p><strong>Usuario:</strong> {{ $orden->cart->user->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $orden->cart->user->email ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Pagos</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Método</th>
                                <th>Estado</th>
                                <th>Ref</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orden->payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_method }}</td>
                                    <td>{{ ucfirst($payment->status) }}</td>
                                    <td>{{ $payment->transaction_ref }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No hay pagos registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Items de la Orden</h3>
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
                            @forelse($orden->cart->items as $item)
                                @php 
                                    $subtotal = $item->quantity * ($item->product->price ?? 0);
                                @endphp
                                <tr>
                                    <td>{{ $item->product->name ?? 'Producto Eliminado' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->product->price ?? 0, 2) }}</td>
                                    <td>${{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay items en esta orden</td>
                                </tr>
                            @endforelse
                            <tr class="font-weight-bold">
                                <td colspan="3" class="text-right">Total:</td>
                                <td>${{ number_format($orden->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
