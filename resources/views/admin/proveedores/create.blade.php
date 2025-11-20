<x-layouts.admin :pageTitle="$pageTitle">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Corrige los errores antes de continuar.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @include('admin.proveedores._form', [
        'proveedor' => $proveedor,
        'fundaciones' => $fundaciones,
        'estados' => $estados,
        'action' => route('admin.proveedores.store'),
        'method' => 'POST',
    ])
</x-layouts.admin>


