<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::query();
        
        // Filtrar por estado de aprobación si se solicita
        if ($request->has('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }
        
        // Filtrar por rol si se solicita
        if ($request->has('rol')) {
            $query->where('rol', $request->rol);
        }
        
        $usuarios = $query->orderBy('created_at', 'desc')->paginate(15);
        $pageTitle = 'Usuarios';
        
        // Contar pendientes para notificación
        $pendingCount = Usuario::where('approval_status', Usuario::STATUS_PENDING)->count();
        
        return view('admin.usuarios.index', compact('usuarios', 'pageTitle', 'pendingCount'));
    }

    public function create()
    {
        $pageTitle = 'Nuevo Usuario';
        $usuario = new Usuario();
        return view('admin.usuarios.create', compact('pageTitle', 'usuario'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|string|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Usuario::create($validated);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(Usuario $usuario)
    {
        $pageTitle = 'Editar Usuario';
        return view('admin.usuarios.edit', compact('usuario', 'pageTitle'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|string|email|max:150|unique:users,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $usuario->update($validated);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    public function approve(Usuario $usuario)
    {
        $usuario->update([
            'approval_status' => Usuario::STATUS_APPROVED,
            'activo' => true,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario aprobado exitosamente.');
    }

    public function reject(Usuario $usuario)
    {
        $usuario->update([
            'approval_status' => Usuario::STATUS_REJECTED,
            'activo' => false,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario rechazado exitosamente.');
    }
}
