@extends('admin.layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Corrige los errores antes de continuar.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.productos.store') }}" method="POST">
                @csrf
                @include('admin.productos._form', [
                    'producto' => $producto,
                    'proveedores' => $proveedores,
                    'categorias' => $categorias,
                ])
            </form>
        </div>
    </div>
@endsection


