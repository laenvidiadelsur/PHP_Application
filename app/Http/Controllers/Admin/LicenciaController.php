<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Licencia;
use App\Domain\Lta\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LicenciaController extends AdminController
{
    private const ESTADOS = ['pendiente', 'activa', 'vencida', 'cancelada'];

    public function index(): View
    {
        $this->pageTitle = 'Licencias';

        $licencias = Licencia::with('titular')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.licencias.index', $this->shareMeta([
            'licencias' => $licencias,
        ]));
    }

    public function create(): View
    {
        $this->pageTitle = 'Nueva licencia';

        return view('admin.licencias.create', $this->shareMeta([
            'licencia' => new Licencia(),
            'usuarios' => Usuario::orderBy('nombre')->get(),
            'estados' => self::ESTADOS,
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Licencia::create($data);

        return redirect()
            ->route('admin.licencias.index')
            ->with('success', 'Licencia creada correctamente.');
    }

    public function edit(Licencia $licencia): View
    {
        $this->pageTitle = 'Editar licencia';

        return view('admin.licencias.edit', $this->shareMeta([
            'licencia' => $licencia,
            'usuarios' => Usuario::orderBy('nombre')->get(),
            'estados' => self::ESTADOS,
        ]));
    }

    public function update(Request $request, Licencia $licencia): RedirectResponse
    {
        $data = $this->validatedData($request, $licencia->id);

        $licencia->update($data);

        return redirect()
            ->route('admin.licencias.index')
            ->with('success', 'Licencia actualizada correctamente.');
    }

    public function destroy(Licencia $licencia): RedirectResponse
    {
        $licencia->delete();

        return redirect()
            ->route('admin.licencias.index')
            ->with('success', 'Licencia eliminada correctamente.');
    }

    private function validatedData(Request $request, ?int $licenciaId = null): array
    {
        return $request->validate([
            'numero' => [
                'required',
                'string',
                'max:255',
                Rule::unique('licencias', 'numero')->ignore($licenciaId),
            ],
            'titular_id' => ['required', 'exists:usuario,id'],
            'estado' => ['required', Rule::in(self::ESTADOS)],
            'vigencia_desde' => ['required', 'date'],
            'vigencia_hasta' => ['nullable', 'date', 'after_or_equal:vigencia_desde'],
        ]);
    }
}

