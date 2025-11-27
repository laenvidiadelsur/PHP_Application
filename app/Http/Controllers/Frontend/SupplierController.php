<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        $proveedores = Proveedor::where('activo', true)
            ->orderBy('name')
            ->paginate(12);
        
        return view('frontend.suppliers.index', [
            'pageTitle' => 'Proveedores',
            'proveedores' => $proveedores,
        ]);
    }
    
    public function show(Proveedor $proveedor): View
    {
        $proveedor->load('productos');
        
        return view('frontend.suppliers.show', [
            'pageTitle' => $proveedor->name,
            'proveedor' => $proveedor,
        ]);
    }
}

