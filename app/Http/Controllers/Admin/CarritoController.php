<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Carrito;
use App\Domain\Lta\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CarritoController extends AdminController
{
    private const ESTADOS = ['activo', 'procesando', 'completado', 'abandonado'];

    public function index(): View
    {
        $this->pageTitle = 'Carritos';

        $carritos = Carrito::with(['usuario', 'items.producto'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.carritos.index', $this->shareMeta([
            'carritos' => $carritos,
        ]));
    }

    public function show(Carrito $carrito): View
    {
        $this->pageTitle = 'Detalle del carrito';

        $carrito->load(['usuario', 'items.producto']);

        return view('admin.carritos.show', $this->shareMeta([
            'carrito' => $carrito,
        ]));
    }

    public function edit(Carrito $carrito): View
    {
        $this->pageTitle = 'Editar carrito';

        return view('admin.carritos.edit', $this->shareMeta([
            'carrito' => $carrito->load('usuario'),
            'usuarios' => Usuario::orderBy('nombre')->get(),
            'estados' => self::ESTADOS,
        ]));
    }

    public function update(Request $request, Carrito $carrito): RedirectResponse
    {
        $data = $this->validatedData($request);

        $carrito->update($data);

        return redirect()
            ->route('admin.carritos.index')
            ->with('success', 'Carrito actualizado correctamente.');
    }

    public function destroy(Carrito $carrito): RedirectResponse
    {
        $carrito->delete();

        return redirect()
            ->route('admin.carritos.index')
            ->with('success', 'Carrito eliminado correctamente.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'usuario_id' => ['nullable', 'exists:usuario,id'],
            'total' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', Rule::in(self::ESTADOS)],
            'fecha_expiracion' => ['nullable', 'date'],
            'session_id' => ['nullable', 'string', 'max:100'],
        ]);
    }
}

