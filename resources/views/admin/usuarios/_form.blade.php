<form action="{{ $usuario->exists ? route('admin.usuarios.update', $usuario) : route('admin.usuarios.store') }}" method="POST">
    @csrf
    @if ($usuario->exists)
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nombre">Nombre <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
                @error('nombre')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="password">Contraseña <span class="text-danger">{{ $usuario->exists ? '' : '*' }}</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ $usuario->exists ? '' : 'required' }}>
                @if ($usuario->exists)
                    <small class="form-text text-muted">Deja en blanco para mantener la contraseña actual.</small>
                @endif
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="rol">Rol <span class="text-danger">*</span></label>
                <select class="form-control @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol }}" {{ old('rol', $usuario->rol) == $rol ? 'selected' : '' }}>
                            {{ ucfirst($rol) }}
                        </option>
                    @endforeach
                </select>
                @error('rol')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="rol_model">Rol Model</label>
                <select class="form-control @error('rol_model') is-invalid @enderror" id="rol_model" name="rol_model">
                    <option value="">Ninguno</option>
                    @foreach ($rolModels as $rolModel)
                        <option value="{{ $rolModel }}" {{ old('rol_model', $usuario->rol_model) == $rolModel ? 'selected' : '' }}>
                            {{ $rolModel }}
                        </option>
                    @endforeach
                </select>
                @error('rol_model')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="fundacion_id">Fundación</label>
                <select class="form-control @error('fundacion_id') is-invalid @enderror" id="fundacion_id" name="fundacion_id">
                    <option value="">Ninguna</option>
                    @foreach ($fundaciones as $fundacion)
                        <option value="{{ $fundacion->id }}" {{ old('fundacion_id', $usuario->fundacion_id) == $fundacion->id ? 'selected' : '' }}>
                            {{ $fundacion->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('fundacion_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select class="form-control @error('proveedor_id') is-invalid @enderror" id="proveedor_id" name="proveedor_id">
                    <option value="">Ninguno</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ old('proveedor_id', $usuario->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('proveedor_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="icheck-primary">
            <input type="checkbox" id="activo" name="activo" value="1" {{ old('activo', $usuario->activo) ? 'checked' : '' }}>
            <label for="activo">Usuario activo</label>
        </div>
    </div>

    <div class="form-group">
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i> Guardar
        </button>
    </div>
</form>

