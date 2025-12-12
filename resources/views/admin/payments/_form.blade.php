<div class="form-group">
    <label for="order_id">Orden <span class="text-danger">*</span></label>
    <select class="form-control @error('order_id') is-invalid @enderror" 
            id="order_id" name="order_id" required>
        <option value="">Seleccione una orden</option>
        @foreach($orders as $order)
            <option value="{{ $order->id }}" {{ old('order_id', $payment->order_id ?? '') == $order->id ? 'selected' : '' }}>
                Orden #{{ $order->id }} - ${{ number_format($order->total_amount, 2) }}
            </option>
        @endforeach
    </select>
    @error('order_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="payment_method">Método de Pago <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('payment_method') is-invalid @enderror" 
           id="payment_method" name="payment_method" value="{{ old('payment_method', $payment->payment_method ?? '') }}" required>
    @error('payment_method')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="estado">Estado <span class="text-danger">*</span></label>
    <select class="form-control @error('estado') is-invalid @enderror" 
            id="estado" name="estado" required>
        <option value="pendiente" {{ old('estado', $payment->estado ?? '') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="completado" {{ old('estado', $payment->estado ?? '') === 'completado' ? 'selected' : '' }}>Completado</option>
        <option value="fallido" {{ old('estado', $payment->estado ?? '') === 'fallido' ? 'selected' : '' }}>Fallido</option>
    </select>
    @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="transaction_ref">Referencia de Transacción</label>
    <input type="text" class="form-control @error('transaction_ref') is-invalid @enderror" 
           id="transaction_ref" name="transaction_ref" value="{{ old('transaction_ref', $payment->transaction_ref ?? '') }}">
    @error('transaction_ref')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar
    </button>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>
