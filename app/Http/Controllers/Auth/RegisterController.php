<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Proveedor;
use App\Domain\Lta\Models\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $fundaciones = Fundacion::where('activa', true)->orderBy('name')->get();
        
        return view('auth.register', [
            'fundaciones' => $fundaciones,
        ]);
    }

    public function register(Request $request)
    {
        // Validación básica del usuario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'confirmed', Password::defaults()],
            'user_type' => 'required|in:comprador,fundacion,proveedor',
        ]);

        // Validaciones personalizadas para esquema test
        $usuarioTable = (new Usuario())->getTable();

        // Validar email único
        $emailExists = DB::table($usuarioTable)->where('email', $validated['email'])->exists();
        if ($emailExists) {
            return back()->withErrors(['email' => 'El email ya está registrado.'])->withInput();
        }

        // Validaciones según el tipo de usuario
        if ($validated['user_type'] === 'fundacion') {
            $request->validate([
                'fundacion_name' => 'required|string|max:150',
            ]);
        } elseif ($validated['user_type'] === 'proveedor') {
            $request->validate([
                'proveedor_fundacion_ids' => 'required|array|min:1',
                'proveedor_fundacion_ids.*' => 'required',
                'proveedor_name' => 'required|string|max:150',
            ]);

            // Validar que TODAS las fundaciones existen
            $fundacionTable = (new Fundacion())->getTable();
            $fundacionIds = (array) $request->input('proveedor_fundacion_ids', []);

            $validFundacionIds = DB::table($fundacionTable)
                ->whereIn('id', $fundacionIds)
                ->pluck('id')
                ->all();

            if (count($validFundacionIds) !== count($fundacionIds)) {
                return back()
                    ->withErrors(['proveedor_fundacion_ids' => 'Alguna fundación seleccionada no existe.'])
                    ->withInput();
            }
        }

        // Determinar rol y estado de aprobación
        $rol = $validated['user_type'];
        $approvalStatus = 'approved'; // Compradores se aprueban automáticamente
        
        if ($rol === Usuario::ROL_FUNDACION || $rol === Usuario::ROL_PROVEEDOR) {
            $approvalStatus = Usuario::STATUS_PENDING; // Requieren aprobación
        }

        // Crear la entidad relacionada primero (Fundación o Proveedor)
        $fundacionId = null;
        $proveedorId = null;

        if ($rol === Usuario::ROL_FUNDACION) {
            // Crear nueva fundación solo con el nombre básico
            // La información adicional se completará en el stepper después de la aprobación
            $fundacion = Fundacion::create([
                'name' => $request->input('fundacion_name'),
                'mission' => null,
                'description' => null,
                'address' => null,
                'verified' => false,
                'activa' => true,
            ]);
            $fundacionId = $fundacion->id;
        } elseif ($rol === Usuario::ROL_PROVEEDOR) {
            // Crear nuevo proveedor solo con el nombre básico
            // La información adicional se completará en el stepper después de la aprobación
            $principalFundacionId = $validFundacionIds[0] ?? null;

            $proveedor = Proveedor::create([
                'fundacion_id' => $principalFundacionId,
                'name' => $request->input('proveedor_name'),
                'contact_name' => null,
                'email' => null,
                'phone' => null,
                'address' => null,
                'tax_id' => null,
                'estado' => 'pendiente',
                'activo' => true,
            ]);

            // Asociar todas las fundaciones seleccionadas en la tabla pivote
            $proveedor->fundaciones()->sync($validFundacionIds);
            $proveedorId = $proveedor->id;
        }

        // Crear el usuario
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'rol' => $rol,
            'approval_status' => $approvalStatus,
            'activo' => true,
            'is_admin' => false,
        ];

        if ($rol === Usuario::ROL_FUNDACION) {
            $userData['fundacion_id'] = $fundacionId;
            $userData['rol_model'] = 'Fundacion';
        } elseif ($rol === Usuario::ROL_PROVEEDOR) {
            $userData['proveedor_id'] = $proveedorId;
            $userData['rol_model'] = 'Proveedor';
        }

        $usuario = Usuario::create($userData);

        // Si es comprador, iniciar sesión automáticamente
        if ($rol === Usuario::ROL_COMPRADOR) {
            Auth::login($usuario);
            return redirect()->route('home')
                ->with('success', '¡Cuenta creada exitosamente!');
        }

        // Si requiere aprobación, mostrar mensaje
        return redirect()->route('login')
            ->with('success', 'Tu solicitud ha sido enviada. Un administrador la revisará y te notificará cuando sea aprobada.');
    }
}
