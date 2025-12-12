<div class="form-group">
    <label for="name">Nombre <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" 
           id="name" name="name" value="{{ old('name', $proveedor->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="contact_name">Nombre de Contacto</label>
    <input type="text" class="form-control @error('contact_name') is-invalid @enderror" 
           id="contact_name" name="contact_name" value="{{ old('contact_name', $proveedor->contact_name ?? '') }}">
    @error('contact_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" 
           id="email" name="email" value="{{ old('email', $proveedor->email ?? '') }}">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="phone">Teléfono</label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
           id="phone" name="phone" value="{{ old('phone', $proveedor->phone ?? '') }}">
    @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="address">Dirección</label>
    <input type="text" class="form-control @error('address') is-invalid @enderror" 
           id="address" name="address" value="{{ old('address', $proveedor->address ?? '') }}">
    @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="tax_id">NIT / Tax ID</label>
    <input type="text" class="form-control @error('tax_id') is-invalid @enderror" 
           id="tax_id" name="tax_id" value="{{ old('tax_id', $proveedor->tax_id ?? '') }}">
    @error('tax_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="estado">Estado <span class="text-danger">*</span></label>
    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
        <option value="pendiente" {{ old('estado', $proveedor->estado ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="aprobado" {{ old('estado', $proveedor->estado ?? '') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
        <option value="rechazado" {{ old('estado', $proveedor->estado ?? '') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
    </select>
    @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" 
           {{ old('activo', $proveedor->activo ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="activo">Activo</label>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar
    </button>
    <a href="{{ route('admin.proveedores.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>
