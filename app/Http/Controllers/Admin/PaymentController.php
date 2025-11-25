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
        $payments = Payment::with('order')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $orders = Orden::where('status', 'pending')->get();
        return view('admin.payments.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:test.orders,id',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|max:30',
            'transaction_ref' => 'nullable|string|max:120',
        ]);

        Payment::create($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pago registrado exitosamente.');
    }

    public function show(Payment $payment)
    {
        $payment->load('order');
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $orders = Orden::all();
        return view('admin.payments.edit', compact('payment', 'orders'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:test.orders,id',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|max:30',
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
