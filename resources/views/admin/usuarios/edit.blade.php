<x-layouts.admin :pageTitle="$pageTitle">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Editar usuario</h3>
        </div>
        <div class="card-body">
            @include('admin.usuarios._form', ['usuario' => $usuario, 'fundaciones' => $fundaciones, 'proveedores' => $proveedores, 'roles' => $roles, 'rolModels' => $rolModels])
        </div>
    </div>
</x-layouts.admin>

