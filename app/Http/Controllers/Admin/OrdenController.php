<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Orden;
use App\Domain\Lta\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrdenController extends AdminController
{
    private const ESTADOS_PAGO = ['pendiente', 'procesando', 'completado', 'fallido', 'reembolsado'];
    private const ESTADOS_ENVIO = ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'];
    private const METODOS_PAGO = ['stripe', 'efectivo', 'transferencia'];

    public function index(): View
    {
        $this->pageTitle = 'Órdenes';

        $ordenes = Orden::with(['usuario', 'items.producto'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.ordenes.index', $this->shareMeta([
            'ordenes' => $ordenes,
        ]));
    }

    public function show(Orden $orden): View
    {
        $this->pageTitle = 'Detalle de la orden';

        $orden->load(['usuario', 'items.producto', 'items.proveedor']);

        return view('admin.ordenes.show', $this->shareMeta([
            'orden' => $orden,
        ]));
    }

    public function edit(Orden $orden): View
    {
        $this->pageTitle = 'Editar orden';

        return view('admin.ordenes.edit', $this->shareMeta([
            'orden' => $orden->load('usuario'),
            'usuarios' => Usuario::orderBy('nombre')->get(),
            'estadosPago' => self::ESTADOS_PAGO,
            'estadosEnvio' => self::ESTADOS_ENVIO,
            'metodosPago' => self::METODOS_PAGO,
        ]));
    }

    public function update(Request $request, Orden $orden): RedirectResponse
    {
        $data = $this->validatedData($request);

        $orden->update($data);

        return redirect()
            ->route('admin.ordenes.index')
            ->with('success', 'Orden actualizada correctamente.');
    }

    public function destroy(Orden $orden): RedirectResponse
    {
        $orden->delete();

        return redirect()
            ->route('admin.ordenes.index')
            ->with('success', 'Orden eliminada correctamente.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'usuario_id' => ['required', 'exists:usuario,id'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'impuestos' => ['required', 'numeric', 'min:0'],
            'envio' => ['required', 'numeric', 'min:0'],
            'total' => ['required', 'numeric', 'min:0'],
            'direccion_calle' => ['nullable', 'string', 'max:200'],
            'direccion_ciudad' => ['nullable', 'string', 'max:120'],
            'direccion_estado' => ['nullable', 'string', 'max:120'],
            'direccion_codigo_postal' => ['nullable', 'string', 'max:20'],
            'direccion_pais' => ['nullable', 'string', 'max:5'],
            'coord_latitud' => ['nullable', 'numeric'],
            'coord_longitud' => ['nullable', 'numeric'],
            'contacto_nombre' => ['nullable', 'string', 'max:150'],
            'contacto_telefono' => ['nullable', 'string', 'max:40'],
            'contacto_email' => ['nullable', 'email', 'max:120'],
            'estado_pago' => ['required', Rule::in(self::ESTADOS_PAGO)],
            'estado_envio' => ['required', Rule::in(self::ESTADOS_ENVIO)],
            'metodo_pago' => ['required', Rule::in(self::METODOS_PAGO)],
            'fecha_pago' => ['nullable', 'date'],
            'notas' => ['nullable', 'string'],
        ]);
    }
}

