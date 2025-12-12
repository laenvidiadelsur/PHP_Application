@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Editar Orden #{{ $orden->id }}</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.ordenes.update', $orden) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="status">Estado <span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="pending" {{ old('status', $orden->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="completed" {{ old('status', $orden->status) === 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="cancelled" {{ old('status', $orden->status) === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        <option value="refunded" {{ old('status', $orden->status) === 'refunded' ? 'selected' : '' }}>Reembolsado</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="total_amount">Monto Total <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control @error('total_amount') is-invalid @enderror" 
                           id="total_amount" name="total_amount" value="{{ old('total_amount', $orden->total_amount) }}" required>
                    @error('total_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('admin.ordenes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
