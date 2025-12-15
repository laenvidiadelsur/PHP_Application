@extends('fundacion.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cog mr-2"></i> Ajustes de la Fundación</h3>
                </div>
                <form action="{{ route('fundacion.settings.update') }}" method="POST" enctype="multipart/form-data">
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

                        <div class="form-group">
                            <label for="name">Nombre de la Fundación</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $fundacion->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="mission">Misión</label>
                            <textarea name="mission" id="mission" rows="3" class="form-control @error('mission') is-invalid @enderror" required>{{ old('mission', $fundacion->mission) }}</textarea>
                            @error('mission') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $fundacion->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address', $fundacion->address) }}" required>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Logo / Imagen (opcional)</label>
                            <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            @if($fundacion->image_url)
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Imagen actual:</small>
                                    <img src="{{ asset('storage/' . $fundacion->image_url) }}" alt="{{ $fundacion->name }}" class="img-fluid rounded" style="max-height: 180px;">
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

