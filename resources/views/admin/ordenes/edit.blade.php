<x-layouts.admin :pageTitle="$pageTitle">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Editar orden {{ $orden->numero_orden }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ordenes.update', $orden) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usuario_id">Usuario <span class="text-danger">*</span></label>
                            <select class="form-control @error('usuario_id') is-invalid @enderror" id="usuario_id" name="usuario_id" required>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('usuario_id', $orden->usuario_id) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->nombre }} ({{ $usuario->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('usuario_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado_pago">Estado pago <span class="text-danger">*</span></label>
                            <select class="form-control @error('estado_pago') is-invalid @enderror" id="estado_pago" name="estado_pago" required>
                                @foreach ($estadosPago as $estado)
                                    <option value="{{ $estado }}" {{ old('estado_pago', $orden->estado_pago) == $estado ? 'selected' : '' }}>
                                        {{ ucfirst($estado) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_pago')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado_envio">Estado envío <span class="text-danger">*</span></label>
                            <select class="form-control @error('estado_envio') is-invalid @enderror" id="estado_envio" name="estado_envio" required>
                                @foreach ($estadosEnvio as $estado)
                                    <option value="{{ $estado }}" {{ old('estado_envio', $orden->estado_envio) == $estado ? 'selected' : '' }}>
                                        {{ ucfirst($estado) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_envio')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="subtotal">Subtotal <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('subtotal') is-invalid @enderror" id="subtotal" name="subtotal" value="{{ old('subtotal', $orden->subtotal) }}" required>
                            @error('subtotal')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="impuestos">Impuestos <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('impuestos') is-invalid @enderror" id="impuestos" name="impuestos" value="{{ old('impuestos', $orden->impuestos) }}" required>
                            @error('impuestos')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="envio">Envío <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('envio') is-invalid @enderror" id="envio" name="envio" value="{{ old('envio', $orden->envio) }}" required>
                            @error('envio')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="total">Total <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{ old('total', $orden->total) }}" required>
                            @error('total')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="metodo_pago">Método pago <span class="text-danger">*</span></label>
                            <select class="form-control @error('metodo_pago') is-invalid @enderror" id="metodo_pago" name="metodo_pago" required>
                                @foreach ($metodosPago as $metodo)
                                    <option value="{{ $metodo }}" {{ old('metodo_pago', $orden->metodo_pago) == $metodo ? 'selected' : '' }}>
                                        {{ ucfirst($metodo) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('metodo_pago')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_pago">Fecha pago</label>
                            <input type="datetime-local" class="form-control @error('fecha_pago') is-invalid @enderror" id="fecha_pago" name="fecha_pago" value="{{ old('fecha_pago', $orden->fecha_pago?->format('Y-m-d\TH:i')) }}">
                            @error('fecha_pago')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notas">Notas</label>
                    <textarea class="form-control @error('notas') is-invalid @enderror" id="notas" name="notas" rows="3">{{ old('notas', $orden->notas) }}</textarea>
                    @error('notas')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <a href="{{ route('admin.ordenes.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>

