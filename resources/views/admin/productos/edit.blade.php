<x-layouts.admin :pageTitle="$pageTitle">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Corrige los errores antes de continuar.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @include('admin.productos._form', [
        'producto' => $producto,
        'fundaciones' => $fundaciones,
        'proveedores' => $proveedores,
        'unidades' => $unidades,
        'categorias' => $categorias,
        'estados' => $estados,
        'action' => route('admin.productos.update', $producto),
        'method' => 'PUT',
    ])
</x-layouts.admin>


