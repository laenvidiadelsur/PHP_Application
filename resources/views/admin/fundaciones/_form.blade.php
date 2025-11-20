<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title mb-0">{{ $fundacion->exists ? 'Editar fundación' : 'Registrar fundación' }}</h3>
    </div>
    <form method="POST" action="{{ $action }}">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $fundacion->nombre) }}" required>
                        @error('nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nit">NIT</label>
                        <input type="text" class="form-control @error('nit') is-invalid @enderror" id="nit" name="nit" value="{{ old('nit', $fundacion->nit) }}" required>
                        @error('nit')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fecha_creacion">Fecha de creación</label>
                        <input type="date" class="form-control @error('fecha_creacion') is-invalid @enderror" id="fecha_creacion" name="fecha_creacion" value="{{ old('fecha_creacion', optional($fundacion->fecha_creacion)->format('Y-m-d')) }}" required>
                        @error('fecha_creacion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $fundacion->direccion) }}" required>
                        @error('direccion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $fundacion->telefono) }}" required>
                        @error('telefono')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $fundacion->email) }}" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="representante_nombre">Nombre del representante</label>
                        <input type="text" class="form-control @error('representante_nombre') is-invalid @enderror" id="representante_nombre" name="representante_nombre" value="{{ old('representante_nombre', $fundacion->representante_nombre) }}" required>
                        @error('representante_nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="representante_ci">CI del representante</label>
                        <input type="text" class="form-control @error('representante_ci') is-invalid @enderror" id="representante_ci" name="representante_ci" value="{{ old('representante_ci', $fundacion->representante_ci) }}" required>
                        @error('representante_ci')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="area_accion">Área de acción</label>
                        <input type="text" class="form-control @error('area_accion') is-invalid @enderror" id="area_accion" name="area_accion" value="{{ old('area_accion', $fundacion->area_accion) }}" required>
                        @error('area_accion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cuenta_bancaria">Cuenta bancaria</label>
                        <input type="text" class="form-control @error('cuenta_bancaria') is-invalid @enderror" id="cuenta_bancaria" name="cuenta_bancaria" value="{{ old('cuenta_bancaria', $fundacion->cuenta_bancaria) }}">
                        @error('cuenta_bancaria')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="logo">Logo (URL)</label>
                        <input type="text" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" value="{{ old('logo', $fundacion->logo) }}">
                        @error('logo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="mision">Misión</label>
                <textarea class="form-control @error('mision') is-invalid @enderror" id="mision" name="mision" rows="3" required>{{ old('mision', $fundacion->mision) }}</textarea>
                @error('mision')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $fundacion->descripcion) }}</textarea>
                @error('descripcion')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="activa" name="activa" value="1" {{ old('activa', $fundacion->activa) ? 'checked' : '' }}>
                <label class="form-check-label" for="activa">Fundación activa</label>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.fundaciones.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
        </div>
    </form>
</div>


