<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Fundacion;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FoundationController extends Controller
{
    public function index(): View
    {
        $fundaciones = Fundacion::where('activa', true)
            ->where('verified', true)
            ->orderBy('name')
            ->paginate(12);
        
        return view('frontend.foundations.index', [
            'pageTitle' => 'Fundaciones',
            'fundaciones' => $fundaciones,
        ]);
    }
    
    public function show(Fundacion $fundacion): View
    {
        return view('frontend.foundations.show', [
            'pageTitle' => $fundacion->name,
            'fundacion' => $fundacion,
        ]);
    }
}

