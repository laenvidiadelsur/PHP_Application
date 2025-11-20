<x-layouts.admin :pageTitle="$pageTitle">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Editar licencia</h3>
        </div>
        <div class="card-body">
            @include('admin.licencias._form', ['licencia' => $licencia, 'usuarios' => $usuarios, 'estados' => $estados])
        </div>
    </div>
</x-layouts.admin>

