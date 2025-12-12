<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Fundacion;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FoundationController extends Controller
{
    public function index(): View
    {
        $query = Fundacion::where('activa', true)
            ->where('verified', true);
            
        // Filter/Sort logic
        $sort = request('sort', 'name'); // Default sort by name
        
        switch ($sort) {
            case 'ranking':
                $query->withCount('votes')->orderByDesc('votes_count');
                break;
            case 'newest':
                $query->orderByDesc('created_at');
                break;
            case 'favorites':
                if (auth()->check()) {
                    $query->whereHas('votes', function($q) {
                        $q->where('user_id', auth()->id());
                    });
                }
                break;
            default:
                $query->orderBy('name');
                break;
        }

        $fundaciones = $query->paginate(12)->withQueryString();
        
        return view('frontend.foundations.index', [
            'pageTitle' => 'Fundaciones',
            'fundaciones' => $fundaciones,
            'currentSort' => $sort,
        ]);
    }
    
    public function show(Fundacion $fundacion): View
    {
        // Get all suppliers for this foundation
        $suppliers = $fundacion->proveedores()
            ->where('activo', true)
            ->orderBy('name')
            ->get();
        
        // Build products query
        $productsQuery = \App\Domain\Lta\Models\Producto::query()
            ->whereIn('supplier_id', $suppliers->pluck('id'))
            ->where('estado', 'activo')
            ->with(['supplier', 'category']);
        
        // Apply supplier filter if requested
        if (request('supplier_id')) {
            $productsQuery->where('supplier_id', request('supplier_id'));
        }
        
        // Paginate products
        $products = $productsQuery->orderBy('name')->paginate(12);
        
        return view('frontend.foundations.show', [
            'pageTitle' => $fundacion->name,
            'fundacion' => $fundacion,
            'suppliers' => $suppliers,
            'products' => $products,
        ]);
    }
}

