<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Lta\Models\Orden;
use App\Domain\Lta\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')->orderBy('id', 'desc')->paginate(15);
        $pageTitle = 'Pagos';
        return view('admin.payments.index', compact('payments', 'pageTitle'));
    }

    public function create()
    {
        $orders = Orden::where('estado', 'pendiente')->get();
        $pageTitle = 'Nuevo Pago';
        $payment = new Payment();
        return view('admin.payments.create', compact('orders', 'pageTitle', 'payment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string|max:50',
            'estado' => 'required|string|max:30',
            'transaction_ref' => 'nullable|string|max:120',
        ]);

        Payment::create($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pago registrado exitosamente.');
    }

    public function show(Payment $payment)
    {
        $payment->load('order');
        $pageTitle = 'Detalle de Pago';
        return view('admin.payments.show', compact('payment', 'pageTitle'));
    }

    public function edit(Payment $payment)
    {
        $orders = Orden::all();
        $pageTitle = 'Editar Pago';
        return view('admin.payments.edit', compact('payment', 'orders', 'pageTitle'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string|max:50',
            'estado' => 'required|string|max:30',
            'transaction_ref' => 'nullable|string|max:120',
        ]);

        $payment->update($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pago eliminado exitosamente.');
    }
}
