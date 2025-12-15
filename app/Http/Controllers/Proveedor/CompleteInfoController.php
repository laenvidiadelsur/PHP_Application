<?php

namespace App\Http\Controllers\Proveedor;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Proveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompleteInfoController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Verificar que el usuario es proveedor
        if (!$user->isProveedor()) {
            return redirect()->route('home')
                ->with('error', 'No tienes acceso a esta sección.');
        }
        
        // Verificar que el usuario está aprobado
        if (!$user->isApproved()) {
            return redirect()->route('home')
                ->with('error', 'Tu cuenta está pendiente de aprobación.');
        }
        
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('home')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        // Si ya está completa, redirigir al dashboard
        if ($proveedor->hasCompleteInfo()) {
            return redirect()->route('proveedor.dashboard')
                ->with('success', 'Tu información ya está completa.');
        }

        // Obtener las fundaciones asociadas
        $fundacionesAsociadas = $proveedor->fundaciones()->get();
        $todasFundaciones = Fundacion::where('activa', true)->orderBy('name')->get();

        return view('proveedor.complete-info', [
            'proveedor' => $proveedor,
            'fundacionesAsociadas' => $fundacionesAsociadas,
            'todasFundaciones' => $todasFundaciones,
            'pageTitle' => 'Completar Información de Proveedor',
        ]);
    }

    /**
     * Formulario de ajustes para editar la información ya cargada.
     */
    public function settings()
    {
        $user = Auth::user();
        
        if (!$user->isProveedor()) {
            return redirect()->route('home')
                ->with('error', 'No tienes acceso a esta sección.');
        }
        
        if (!$user->isApproved()) {
            return redirect()->route('home')
                ->with('error', 'Tu cuenta está pendiente de aprobación.');
        }
        
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('home')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        $fundacionesAsociadas = $proveedor->fundaciones()->get();
        $todasFundaciones = Fundacion::where('activa', true)->orderBy('name')->get();

        return view('proveedor.complete-info', [
            'proveedor' => $proveedor,
            'fundacionesAsociadas' => $fundacionesAsociadas,
            'todasFundaciones' => $todasFundaciones,
            'pageTitle' => 'Ajustes del Proveedor',
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Verificar que el usuario es proveedor
        if (!$user->isProveedor()) {
            return redirect()->route('home')
                ->with('error', 'No tienes acceso a esta sección.');
        }
        
        // Verificar que el usuario está aprobado
        if (!$user->isApproved()) {
            return redirect()->route('home')
                ->with('error', 'Tu cuenta está pendiente de aprobación.');
        }
        
        $proveedor = $user->proveedor;

        if (!$proveedor) {
            return redirect()->route('home')
                ->with('error', 'No tienes un proveedor asociado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'contact_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'fundacion_ids' => 'required|array|min:1',
            'fundacion_ids.*' => 'required|exists:foundations,id',
            'image' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'El nombre del proveedor es obligatorio.',
            'contact_name.required' => 'El nombre de contacto es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'phone.required' => 'El teléfono es obligatorio.',
            'address.required' => 'La dirección es obligatoria.',
            'fundacion_ids.required' => 'Debes seleccionar al menos una fundación.',
            'fundacion_ids.min' => 'Debes seleccionar al menos una fundación.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.max' => 'La imagen no debe superar los 2MB.',
        ]);

        // Validar que el tax_id sea único si se proporciona
        if ($request->filled('tax_id')) {
            $taxIdExists = DB::table((new Proveedor())->getTable())
                ->where('tax_id', $validated['tax_id'])
                ->where('id', '!=', $proveedor->id)
                ->exists();
            if ($taxIdExists) {
                return back()->withErrors(['tax_id' => 'El NIT/Tax ID ya está registrado.'])->withInput();
            }
        }

        $updateData = [
            'name' => $validated['name'],
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'tax_id' => $validated['tax_id'] ?? null,
            'fundacion_id' => $validated['fundacion_ids'][0] ?? null, // Fundación principal
        ];

        // Manejar imagen si se envía
        if ($request->hasFile('image')) {
            if (!$request->file('image')->isValid()) {
                return back()->withErrors(['image' => 'Error al subir la imagen.'])->withInput();
            }

            if (!Storage::disk('public')->exists('suppliers')) {
                Storage::disk('public')->makeDirectory('suppliers');
            }

            if ($proveedor->image_url && Storage::disk('public')->exists($proveedor->image_url)) {
                Storage::disk('public')->delete($proveedor->image_url);
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('suppliers', $imageName, 'public');

            if (!$imagePath) {
                return back()->withErrors(['image' => 'No se pudo guardar la imagen.'])->withInput();
            }

            $updateData['image_url'] = $imagePath;
        }

        // Actualizar información del proveedor (incluye image_url si se cargó)
        $proveedor->update($updateData);

        // Sincronizar fundaciones
        $proveedor->fundaciones()->sync($validated['fundacion_ids']);

        return redirect()->route('proveedor.dashboard')
            ->with('success', 'Información del proveedor completada exitosamente.');
    }

    /**
     * Actualizar desde ajustes (misma lógica que store pero accesible siempre).
     */
    public function updateSettings(Request $request)
    {
        return $this->store($request);
    }
}

