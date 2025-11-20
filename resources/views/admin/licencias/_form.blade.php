<form action="{{ $licencia->exists ? route('admin.licencias.update', $licencia) : route('admin.licencias.store') }}" method="POST">
    @csrf
    @if ($licencia->exists)
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="numero">Número de licencia <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero', $licencia->numero) }}" required>
                @error('numero')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="titular_id">Titular <span class="text-danger">*</span></label>
                <select class="form-control @error('titular_id') is-invalid @enderror" id="titular_id" name="titular_id" required>
                    <option value="">Selecciona un titular</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ old('titular_id', $licencia->titular_id) == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->nombre }} ({{ $usuario->email }})
                        </option>
                    @endforeach
                </select>
                @error('titular_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="estado">Estado <span class="text-danger">*</span></label>
                <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado }}" {{ old('estado', $licencia->estado) == $estado ? 'selected' : '' }}>
                            {{ ucfirst($estado) }}
                        </option>
                    @endforeach
                </select>
                @error('estado')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="vigencia_desde">Vigencia desde <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('vigencia_desde') is-invalid @enderror" id="vigencia_desde" name="vigencia_desde" value="{{ old('vigencia_desde', $licencia->vigencia_desde?->format('Y-m-d')) }}" required>
                @error('vigencia_desde')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="vigencia_hasta">Vigencia hasta</label>
                <input type="date" class="form-control @error('vigencia_hasta') is-invalid @enderror" id="vigencia_hasta" name="vigencia_hasta" value="{{ old('vigencia_hasta', $licencia->vigencia_hasta?->format('Y-m-d')) }}">
                @error('vigencia_hasta')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <a href="{{ route('admin.licencias.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i> Guardar
        </button>
    </div>
</form>

