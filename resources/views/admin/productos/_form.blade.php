@php
    $selectedFundacion = (int) old('fundacion_id', $producto->fundacion_id);
    $selectedProveedor = (int) old('proveedor_id', $producto->proveedor_id);
@endphp

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title mb-0">{{ $producto->exists ? 'Editar producto' : 'Registrar producto' }}</h3>
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
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                        @error('nombre') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria }}" {{ old('categoria', $producto->categoria ?? 'materiales') === $categoria ? 'selected' : '' }}>
                                    {{ \Illuminate\Support\Str::ucfirst($categoria) }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="unidad">Unidad</label>
                        <select class="form-control @error('unidad') is-invalid @enderror" id="unidad" name="unidad" required>
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad }}" {{ old('unidad', $producto->unidad ?? 'kg') === $unidad ? 'selected' : '' }}>
                                    {{ strtoupper($unidad) }}
                                </option>
                            @endforeach
                        </select>
                        @error('unidad') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="precio">Precio (Bs)</label>
                        <input type="number" step="0.01" min="0" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" required>
                        @error('precio') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $producto->stock ?? 0) }}" required>
                        @error('stock') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado }}" {{ old('estado', $producto->estado ?? 'activo') === $estado ? 'selected' : '' }}>
                                    {{ \Illuminate\Support\Str::ucfirst($estado) }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                @error('descripcion') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fundacion_id">Fundación</label>
                        <select class="form-control @error('fundacion_id') is-invalid @enderror" id="fundacion_id" name="fundacion_id" required>
                            <option value="">Selecciona una fundación</option>
                            @foreach ($fundaciones as $fundacion)
                                <option value="{{ $fundacion->id }}" {{ $selectedFundacion === $fundacion->id ? 'selected' : '' }}>
                                    {{ $fundacion->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('fundacion_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="proveedor_id">Proveedor</label>
                        <select class="form-control @error('proveedor_id') is-invalid @enderror" id="proveedor_id" name="proveedor_id" required>
                            <option value="">Selecciona un proveedor</option>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" data-fundacion="{{ $proveedor->fundacion_id }}" {{ $selectedProveedor === $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->nombre }} ({{ optional($proveedor->fundacion)->nombre }})
                                </option>
                            @endforeach
                        </select>
                        @error('proveedor_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        (function () {
            const fundacionSelect = document.getElementById('fundacion_id');
            const proveedorSelect = document.getElementById('proveedor_id');

            if (!fundacionSelect || !proveedorSelect) {
                return;
            }

            const toggleProveedorOptions = () => {
                const fundacionId = Number(fundacionSelect.value);

                Array.from(proveedorSelect.options).forEach((option) => {
                    if (!option.value) {
                        option.hidden = false;
                        return;
                    }

                    const optionFundacion = Number(option.dataset.fundacion ?? 0);
                    option.hidden = fundacionId > 0 && optionFundacion !== fundacionId;

                    if (option.hidden && option.selected) {
                        option.selected = false;
                    }
                });
            };

            fundacionSelect.addEventListener('change', toggleProveedorOptions);
            toggleProveedorOptions();
        })();
    </script>
@endpush


