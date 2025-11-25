@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Detalle del Pago</h2>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Información del Pago</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td>{{ $payment->id }}</td>
                        </tr>
                        <tr>
                            <th>Orden ID</th>
                            <td>{{ $payment->order_id }}</td>
                        </tr>
                        <tr>
                            <th>Método de Pago</th>
                            <td>{{ $payment->payment_method }}</td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>
                                <span class="badge badge-{{ $payment->status === 'pending' ? 'warning' : 'success' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Referencia de Transacción</th>
                            <td>{{ $payment->transaction_ref ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de Creación</th>
                            <td>{{ $payment->created_at?->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5>Información de la Orden</h5>
                    @if($payment->order)
                        <table class="table table-bordered">
                            <tr>
                                <th>ID de Orden</th>
                                <td>{{ $payment->order->id }}</td>
                            </tr>
                            <tr>
                                <th>Monto Total</th>
                                <td>${{ number_format($payment->order->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Estado de Orden</th>
                                <td>{{ ucfirst($payment->order->status) }}</td>
                            </tr>
                        </table>
                    @else
                        <p>No hay información de orden disponible</p>
                    @endif
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-info">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este pago?')">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
