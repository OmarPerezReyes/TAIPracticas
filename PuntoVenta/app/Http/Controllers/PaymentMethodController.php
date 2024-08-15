<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $rowCount = $request->get('row', 10);
        $search = $request->get('search', '');

        $paymentMethods = PaymentMethod::query()
            ->where('name', 'like', "%{$search}%")
            ->paginate($rowCount);

        return view('payment_methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        PaymentMethod::create($request->all());

        return redirect()->route('payment_methods.index')
                         ->with('success', 'Método de pago creado con éxito.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('payment_methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $paymentMethod->update($request->all());

        return redirect()->route('payment_methods.index')
                         ->with('success', 'Método de pago actualizado con éxito.');
    }

    public function destroy($id)
    {
        // Encuentra el método de pago por su ID
        $paymentMethod = PaymentMethod::findOrFail($id);

        // Verifica si el método de pago está asociado a alguna orden
        $hasOrders = DB::table('order_payments')
                        ->where('payment_method_id', $paymentMethod->id)
                        ->exists();

        if ($hasOrders) {
            // Redirige con un mensaje de error si el método de pago está asociado a una orden
            return redirect()->route('payment_methods.index')
                             ->with('error', 'No se puede eliminar el método de pago porque está asociado a una o más órdenes.');
        }

        // Elimina el método de pago si no está asociado a ninguna orden
        $paymentMethod->delete();

        // Redirige con un mensaje de éxito
        return redirect()->route('payment_methods.index')
                         ->with('success', 'Método de pago eliminado correctamente.');
    }
}
