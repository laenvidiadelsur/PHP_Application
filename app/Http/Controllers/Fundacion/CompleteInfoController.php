<?php

namespace App\Http\Controllers\Fundacion;

use App\Domain\Lta\Models\Fundacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'El nombre de la fundación es obligatorio.',
            'mission.required' => 'La misión de la fundación es obligatoria.',
            'description.required' => 'La descripción de la fundación es obligatoria.',
            'address.required' => 'La dirección de la fundación es obligatoria.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.max' => 'La imagen no debe superar los 2MB.',
        ]);

        // Manejar imagen si se envía
        if ($request->hasFile('image')) {
            if (!$request->file('image')->isValid()) {
                return back()->withErrors(['image' => 'Error al subir la imagen.'])->withInput();
            }

            // Asegurar directorio
            if (!Storage::disk('public')->exists('foundations')) {
                Storage::disk('public')->makeDirectory('foundations');
            }

            // Eliminar imagen anterior si existe
            if ($fundacion->image_url && Storage::disk('public')->exists($fundacion->image_url)) {
                Storage::disk('public')->delete($fundacion->image_url);
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('foundations', $imageName, 'public');

            if (!$imagePath) {
                return back()->withErrors(['image' => 'No se pudo guardar la imagen.'])->withInput();
            }

            $validated['image_url'] = $imagePath;
            unset($validated['image']);
        }

        $fundacion->update($validated);

        return redirect()->route('fundacion.dashboard')
            ->with('success', 'Información de la fundación completada exitosamente.');
    }
}

