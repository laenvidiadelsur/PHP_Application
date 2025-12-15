<?php

namespace App\Http\Controllers\Fundacion;

use App\Domain\Lta\Models\Fundacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompleteInfoController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $fundacion = $user->fundacion;

        if (!$fundacion) {
            return redirect()->route('home')
                ->with('error', 'No tienes una fundación asociada.');
        }

        // Si ya está completa, redirigir al dashboard
        if ($fundacion->hasCompleteInfo()) {
            return redirect()->route('fundacion.dashboard')
                ->with('success', 'Tu información ya está completa.');
        }

        return view('fundacion.complete-info', [
            'fundacion' => $fundacion,
            'pageTitle' => 'Completar Información de Fundación',
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $fundacion = $user->fundacion;

        if (!$fundacion) {
            return redirect()->route('home')
                ->with('error', 'No tienes una fundación asociada.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'mission' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
        ], [
            'name.required' => 'El nombre de la fundación es obligatorio.',
            'mission.required' => 'La misión de la fundación es obligatoria.',
            'description.required' => 'La descripción de la fundación es obligatoria.',
            'address.required' => 'La dirección de la fundación es obligatoria.',
        ]);

        $fundacion->update($validated);

        return redirect()->route('fundacion.dashboard')
            ->with('success', 'Información de la fundación completada exitosamente.');
    }
}

