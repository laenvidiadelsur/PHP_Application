<div class="form-group">
    <label for="name">Nombre <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" 
           id="name" name="name" value="{{ old('name', $producto->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="description">Descripción</label>
    <textarea class="form-control @error('description') is-invalid @enderror" 
              id="description" name="description" rows="3">{{ old('description', $producto->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="image">Imagen del Producto</label>
    <input type="file" class="form-control @error('image') is-invalid @enderror" 
           id="image" name="image" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
           onchange="previewImage(this)">
    @error('image')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    @if(isset($producto) && $producto->image_url)
        <div class="mt-2">
            <img id="current-image" src="{{ asset('storage/' . $producto->image_url) }}" alt="{{ $producto->name }}" 
                 class="img-thumbnail" style="max-width: 200px; max-height: 200px; display: block;">
            <p class="text-muted small mt-1">Imagen actual</p>
        </div>
    @endif
    <div id="image-preview" class="mt-2" style="display: none;">
        <img id="preview-img" src="" alt="Vista previa" 
             class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
        <p class="text-muted small mt-1">Vista previa de la nueva imagen</p>
    </div>
    <small class="form-text text-muted">
        Formatos permitidos: JPEG, JPG, PNG, GIF, WEBP. Tamaño máximo: 5MB. Dimensiones: 100x100 a 5000x5000 píxeles.
    </small>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const currentImg = document.getElementById('current-image');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB en bytes
        
        // Validar tamaño
        if (file.size > maxSize) {
            alert('La imagen es demasiado grande. El tamaño máximo es 5MB.');
            input.value = '';
            preview.style.display = 'none';
            return;
        }
        
        // Validar tipo
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Formato de imagen no válido. Use: JPEG, JPG, PNG, GIF o WEBP.');
            input.value = '';
            preview.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            if (currentImg) {
                currentImg.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        if (currentImg) {
            currentImg.style.display = 'block';
        }
    }
}
</script>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="price">Precio <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                   id="price" name="price" value="{{ old('price', $producto->price ?? '') }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="stock">Stock <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                   id="stock" name="stock" value="{{ old('stock', $producto->stock ?? 0) }}" required min="0">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="estado">Estado <span class="text-danger">*</span></label>
            <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                <option value="activo" {{ old('estado', $producto->estado ?? '') == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ old('estado', $producto->estado ?? '') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="category_id">Categoría</label>
            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('category_id', $producto->category_id ?? '') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar
    </button>
    <a href="{{ route('proveedor.productos.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>

