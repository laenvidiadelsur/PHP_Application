<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title mb-0">{{ $proveedor->exists ? 'Editar proveedor' : 'Registrar proveedor' }}</h3>
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
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" required>
                        @error('nombre') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nit">NIT</label>
                        <input type="text" class="form-control @error('nit') is-invalid @enderror" id="nit" name="nit" value="{{ old('nit', $proveedor->nit) }}" required>
                        @error('nit') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo_servicio">Tipo de servicio</label>
                        <input type="text" class="form-control @error('tipo_servicio') is-invalid @enderror" id="tipo_servicio" name="tipo_servicio" value="{{ old('tipo_servicio', $proveedor->tipo_servicio) }}" required>
                        @error('tipo_servicio') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $proveedor->email) }}" required>
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}" required>
                        @error('telefono') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}" required>
                        @error('direccion') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="representante_nombre">Nombre del representante</label>
                        <input type="text" class="form-control @error('representante_nombre') is-invalid @enderror" id="representante_nombre" name="representante_nombre" value="{{ old('representante_nombre', $proveedor->representante_nombre) }}" required>
                        @error('representante_nombre') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="representante_ci">CI del representante</label>
                        <input type="text" class="form-control @error('representante_ci') is-invalid @enderror" id="representante_ci" name="representante_ci" value="{{ old('representante_ci', $proveedor->representante_ci) }}" required>
                        @error('representante_ci') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fundacion_id">Fundación asociada</label>
                        <select class="form-control @error('fundacion_id') is-invalid @enderror" id="fundacion_id" name="fundacion_id" required>
                            <option value="">Selecciona una fundación</option>
                            @foreach ($fundaciones as $fundacion)
                                <option value="{{ $fundacion->id }}" {{ (int) old('fundacion_id', $proveedor->fundacion_id) === $fundacion->id ? 'selected' : '' }}>
                                    {{ $fundacion->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('fundacion_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado }}" {{ old('estado', $proveedor->estado ?? 'pendiente') === $estado ? 'selected' : '' }}>
                                    {{ \Illuminate\Support\Str::ucfirst($estado) }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <div class="form-group mb-0">
                        <div class="form-check mt-4 pt-1">
                            <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" {{ old('activo', $proveedor->activo ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">Proveedor activo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.proveedores.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
        </div>
    </form>
</div>


