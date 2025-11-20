<x-layouts.admin :pageTitle="$pageTitle">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Corrige los errores antes de continuar.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @include('admin.fundaciones._form', [
        'fundacion' => $fundacion,
        'action' => route('admin.fundaciones.update', $fundacion),
        'method' => 'PUT',
    ])
</x-layouts.admin>


