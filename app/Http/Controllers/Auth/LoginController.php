<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Lta\Models\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Los administradores siempre pueden iniciar sesión
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }
            
            // Verificar si el usuario está activo (excepto administradores)
            // Si activo es null, se considera activo por defecto
            if ($user->activo === false) {
                Auth::logout();
                return back()->with('error', 'Tu cuenta ha sido desactivada. Contacta al administrador.');
            }
            
            // Verificar estado de aprobación para fundaciones y proveedores
            if (in_array($user->rol, [Usuario::ROL_FUNDACION, Usuario::ROL_PROVEEDOR])) {
                if ($user->approval_status === Usuario::STATUS_PENDING) {
                    Auth::logout();
                    return back()->with('error', 'Tu cuenta está pendiente de aprobación. Un administrador revisará tu solicitud.');
                }
                
                if ($user->approval_status === Usuario::STATUS_REJECTED) {
                    Auth::logout();
                    return back()->with('error', 'Tu solicitud fue rechazada. Contacta al administrador para más información.');
                }
            }
            
            // Redirigir según el rol
            if ($user->isFundacion()) {
                return redirect()->intended(route('fundacion.dashboard'));
            }
            
            if ($user->isProveedor()) {
                return redirect()->intended(route('proveedor.dashboard'));
            }
            
            // Comprador o usuario normal
            return redirect()->intended(route('home'));
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Sesión cerrada exitosamente');
    }
}

