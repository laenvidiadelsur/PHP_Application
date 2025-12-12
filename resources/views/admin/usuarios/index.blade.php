@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Usuarios</h2>
                <div>
                    @if($pendingCount > 0)
                        <span class="badge badge-warning mr-2">
                            <i class="fas fa-bell"></i> {{ $pendingCount }} Pendiente(s)
                        </span>
                    @endif
                    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.usuarios.index') }}" class="row">
                <div class="col-md-4">
                    <label for="approval_status">Estado de Aprobación</label>
                    <select name="approval_status" id="approval_status" class="form-control">
                        <option value="">Todos</option>
                        <option value="pending" {{ request('approval_status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="approved" {{ request('approval_status') === 'approved' ? 'selected' : '' }}>Aprobado</option>
                        <option value="rejected" {{ request('approval_status') === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="rol">Rol</label>
                    <select name="rol" id="rol" class="form-control">
                        <option value="">Todos</option>
                        <option value="admin" {{ request('rol') === 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="fundacion" {{ request('rol') === 'fundacion' ? 'selected' : '' }}>Fundación</option>
                        <option value="proveedor" {{ request('rol') === 'proveedor' ? 'selected' : '' }}>Proveedor</option>
                        <option value="comprador" {{ request('rol') === 'comprador' ? 'selected' : '' }}>Comprador</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">Filtrar</button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado Aprobación</th>
                            <th>Activo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    @if($usuario->isAdmin())
                                        <span class="badge badge-danger">Admin</span>
                                    @elseif($usuario->isFundacion())
                                        <span class="badge badge-info">Fundación</span>
                                    @elseif($usuario->isProveedor())
                                        <span class="badge badge-warning">Proveedor</span>
                                    @else
                                        <span class="badge badge-secondary">Comprador</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usuario->approval_status === 'pending')
                                        <span class="badge badge-warning">Pendiente</span>
                                    @elseif($usuario->approval_status === 'approved')
                                        <span class="badge badge-success">Aprobado</span>
                                    @elseif($usuario->approval_status === 'rejected')
                                        <span class="badge badge-danger">Rechazado</span>
                                    @else
                                        <span class="badge badge-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usuario->activo)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if($usuario->approval_status === 'pending')
                                            <form action="{{ route('admin.usuarios.approve', $usuario) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Aprobar">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.usuarios.reject', $usuario) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Rechazar" onclick="return confirm('¿Está seguro de rechazar este usuario?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-sm btn-info" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay usuarios registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
