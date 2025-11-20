<x-layouts.admin :pageTitle="$pageTitle">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Editar carrito #{{ $carrito->id }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.carritos.update', $carrito) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usuario_id">Usuario</label>
                            <select class="form-control @error('usuario_id') is-invalid @enderror" id="usuario_id" name="usuario_id">
                                <option value="">Anónimo</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('usuario_id', $carrito->usuario_id) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->nombre }} ({{ $usuario->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('usuario_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total">Total <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{ old('total', $carrito->total) }}" required>
                            @error('total')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado">Estado <span class="text-danger">*</span></label>
                            <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado }}" {{ old('estado', $carrito->estado) == $estado ? 'selected' : '' }}>
                                        {{ ucfirst($estado) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha_expiracion">Fecha expiración</label>
                            <input type="datetime-local" class="form-control @error('fecha_expiracion') is-invalid @enderror" id="fecha_expiracion" name="fecha_expiracion" value="{{ old('fecha_expiracion', $carrito->fecha_expiracion?->format('Y-m-d\TH:i')) }}">
                            @error('fecha_expiracion')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <a href="{{ route('admin.carritos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>

