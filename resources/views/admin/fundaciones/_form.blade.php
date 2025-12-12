<div class="form-group">
    <label for="name">Nombre <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" 
           id="name" name="name" value="{{ old('name', $fundacion->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="mission">Misión</label>
    <textarea class="form-control @error('mission') is-invalid @enderror" 
              id="mission" name="mission" rows="3">{{ old('mission', $fundacion->mission ?? '') }}</textarea>
    @error('mission')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="description">Descripción</label>
    <textarea class="form-control @error('description') is-invalid @enderror" 
              id="description" name="description" rows="3">{{ old('description', $fundacion->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="address">Dirección</label>
    <input type="text" class="form-control @error('address') is-invalid @enderror" 
           id="address" name="address" value="{{ old('address', $fundacion->address ?? '') }}">
    @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox" class="form-check-input" id="verified" name="verified" value="1" 
           {{ old('verified', $fundacion->verified ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="verified">Verificada</label>
</div>

<div class="form-check mb-3">
    <input type="checkbox" class="form-check-input" id="activa" name="activa" value="1" 
           {{ old('activa', $fundacion->activa ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="activa">Activa</label>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar
    </button>
    <a href="{{ route('admin.fundaciones.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>
