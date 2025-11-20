<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Fundacion;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FundacionController extends AdminController
{
    public function index(): View
    {
        $this->pageTitle = 'Fundaciones';

        $fundaciones = Fundacion::orderBy('nombre')->paginate(12);

        return view('admin.fundaciones.index', $this->shareMeta([
            'fundaciones' => $fundaciones,
        ]));
    }

    public function create(): View
    {
        $this->pageTitle = 'Nueva fundación';

        return view('admin.fundaciones.create', $this->shareMeta([
            'fundacion' => new Fundacion(),
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Fundacion::create($data);

        return redirect()
            ->route('admin.fundaciones.index')
            ->with('success', 'Fundación creada correctamente.');
    }

    public function edit(Fundacion $fundacion): View
    {
        $this->pageTitle = 'Editar fundación';

        return view('admin.fundaciones.edit', $this->shareMeta([
            'fundacion' => $fundacion,
        ]));
    }

    public function update(Request $request, Fundacion $fundacion): RedirectResponse
    {
        $data = $this->validatedData($request, $fundacion->id);

        $fundacion->update($data);

        return redirect()
            ->route('admin.fundaciones.index')
            ->with('success', 'Fundación actualizada correctamente.');
    }

    public function destroy(Fundacion $fundacion): RedirectResponse
    {
        if ($fundacion->proveedores()->exists() || $fundacion->productos()->exists()) {
            return redirect()
                ->route('admin.fundaciones.index')
                ->with('error', 'No se puede eliminar una fundación con proveedores o productos asociados.');
        }

        try {
            $fundacion->delete();

            return redirect()
                ->route('admin.fundaciones.index')
                ->with('success', 'Fundación eliminada correctamente.');
        } catch (QueryException $exception) {
            return redirect()
                ->route('admin.fundaciones.index')
                ->with('error', 'Ocurrió un error al eliminar la fundación: '.$exception->getMessage());
        }
    }

    private function validatedData(Request $request, ?int $fundacionId = null): array
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'nit' => [
                'required',
                'string',
                'max:50',
                Rule::unique('fundacion', 'nit')->ignore($fundacionId),
            ],
            'direccion' => ['required', 'string', 'max:200'],
            'telefono' => ['required', 'string', 'max:30'],
            'email' => [
                'required',
                'email',
                'max:120',
                Rule::unique('fundacion', 'email')->ignore($fundacionId),
            ],
            'representante_nombre' => ['required', 'string', 'max:120'],
            'representante_ci' => ['required', 'string', 'max:40'],
            'mision' => ['required', 'string'],
            'fecha_creacion' => ['required', 'date'],
            'area_accion' => ['required', 'string', 'max:120'],
            'cuenta_bancaria' => ['nullable', 'string', 'max:80'],
            'logo' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'activa' => ['nullable', 'boolean'],
        ], [], [
            'nit' => 'NIT',
        ]);

        $data['activa'] = $request->boolean('activa');

        return $data;
    }
}


