@extends('proveedor.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cog mr-2"></i> Ajustes del Proveedor</h3>
                </div>
                <form action="{{ route('proveedor.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Nombre del Proveedor</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $proveedor->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="contact_name">Nombre de Contacto</label>
                                <input type="text" name="contact_name" id="contact_name" class="form-control @error('contact_name') is-invalid @enderror"
                                       value="{{ old('contact_name', $proveedor->contact_name) }}" required>
                                @error('contact_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $proveedor->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Teléfono</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $proveedor->phone) }}" required>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="address">Dirección</label>
                                <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address', $proveedor->address) }}" required>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tax_id">NIT / Tax ID (opcional)</label>
                                <input type="text" name="tax_id" id="tax_id" class="form-control @error('tax_id') is-invalid @enderror"
                                       value="{{ old('tax_id', $proveedor->tax_id) }}">
                                @error('tax_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fundacion_ids">Fundaciones</label>
                            <select name="fundacion_ids[]" id="fundacion_ids" class="form-control @error('fundacion_ids') is-invalid @enderror" multiple required size="8">
                                @foreach($todasFundaciones as $fundacion)
                                    <option value="{{ $fundacion->id }}"
                                        @if(in_array($fundacion->id, old('fundacion_ids', $fundacionesAsociadas->pluck('id')->toArray()))) selected @endif>
                                        {{ $fundacion->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fundacion_ids') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text text-muted">Selecciona una o más fundaciones.</small>
                        </div>

                        <div class="form-group">
                            <label for="image">Logo / Imagen (opcional)</label>
                            <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            @if($proveedor->image_url)
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Imagen actual:</small>
                                    <img src="{{ asset('storage/' . $proveedor->image_url) }}" alt="{{ $proveedor->name }}" class="img-fluid rounded" style="max-height: 180px;">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

