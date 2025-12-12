@extends('admin.layouts.app')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Editar usuario</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.usuarios._form', ['usuario' => $usuario])
            </form>
        </div>
    </div>
@endsection

