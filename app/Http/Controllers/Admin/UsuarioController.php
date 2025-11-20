<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Proveedor;
use App\Domain\Lta\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsuarioController extends AdminController
{
    private const ROLES = ['admin', 'fundacion', 'proveedor', 'usuario'];
    private const ROL_MODELS = ['Fundacion', 'Proveedor'];

    public function index(): View
    {
        $this->pageTitle = 'Usuarios';

        $usuarios = Usuario::with(['fundacion', 'proveedor'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.usuarios.index', $this->shareMeta([
            'usuarios' => $usuarios,
        ]));
    }

    public function create(): View
    {
        $this->pageTitle = 'Nuevo usuario';

        return view('admin.usuarios.create', $this->shareMeta([
            'usuario' => new Usuario(),
            'fundaciones' => Fundacion::orderBy('nombre')->get(),
            'proveedores' => Proveedor::orderBy('nombre')->get(),
            'roles' => self::ROLES,
            'rolModels' => self::ROL_MODELS,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if (isset($data['password'])) {
            $data['password_hash'] = bcrypt($data['password']);
            unset($data['password']);
        }

        Usuario::create($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(Usuario $usuario): View
    {
        $this->pageTitle = 'Editar usuario';

        return view('admin.usuarios.edit', $this->shareMeta([
            'usuario' => $usuario,
            'fundaciones' => Fundacion::orderBy('nombre')->get(),
            'proveedores' => Proveedor::orderBy('nombre')->get(),
            'roles' => self::ROLES,
            'rolModels' => self::ROL_MODELS,
        ]));
    }

    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        $data = $this->validatedData($request, $usuario->id);

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password_hash'] = bcrypt($data['password']);
        }
        unset($data['password']);

        $usuario->update($data);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        if ($usuario->carritos()->exists() || $usuario->ordenes()->exists()) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'No se puede eliminar un usuario con carritos u órdenes asociadas.');
        }

        $usuario->delete();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    private function validatedData(Request $request, ?int $usuarioId = null): array
    {
        $rules = [
            'nombre' => ['required', 'string', 'max:120'],
            'email' => [
                'required',
                'email',
                'max:120',
                Rule::unique('usuario', 'email')->ignore($usuarioId),
            ],
            'rol' => ['required', Rule::in(self::ROLES)],
            'fundacion_id' => ['nullable', 'exists:fundacion,id'],
            'proveedor_id' => ['nullable', 'exists:proveedor,id'],
            'rol_model' => ['nullable', Rule::in(self::ROL_MODELS)],
            'activo' => ['nullable', 'boolean'],
        ];

        if ($request->isMethod('post') || !empty($request->input('password'))) {
            $rules['password'] = ['required', 'string', 'min:8'];
        }

        $data = $request->validate($rules);

        $data['activo'] = $request->boolean('activo');

        return $data;
    }
}

