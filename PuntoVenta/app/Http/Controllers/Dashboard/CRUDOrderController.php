<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\OrderPayment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CRUDOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()
            ->with('customer', 'employee', 'orderPayments.paymentMethod');

        // Filtrar por búsqueda
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->whereHas('customer', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                ->orWhereHas('employee', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                ->orWhereHas('orderPayments.paymentMethod', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            });
        }

        // Ordenar
        if ($sortBy = $request->input('sort_by')) {
            $sortDirection = $request->input('sort_direction', 'asc'); // 'asc' o 'desc'
            $query->orderBy($sortBy, $sortDirection);
        }

        $orders = $query->paginate($request->input('row', 10));

        return view('crudorders.index', compact('orders'));
    }



    // Muestra el formulario para crear una nueva orden
    public function create()
    {
        $customers = Customer::all();
        $employees = Employee::all();
        $paymentMethods = PaymentMethod::all();
        return view('crudorders.create', compact('customers', 'employees', 'paymentMethods')); // Asegúrate de usar la vista correcta
    }

    // Almacena una nueva orden en la base de datos
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'nullable|exists:employees,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount_paid' => 'required|numeric|min:0',
            'change' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        $order = new Order();
        $order->customer_id = $validatedData['customer_id'];
        $order->employee_id = $validatedData['employee_id'];
        $order->total = $validatedData['total'];
        $order->paid = $validatedData['amount_paid'];
        $order->change = $validatedData['change'] ?? 0;
        $order->save();

        $payment = new OrderPayment();
        $payment->order_id = $order->id;
        $payment->payment_method_id = $validatedData['payment_method_id'];
        $payment->amount = $validatedData['amount_paid'];
        $payment->save();

        // Vaciar el carrito
        // Cart::destroy(); // Asegúrate de usar la lógica correcta si usas un carrito

        return redirect()->route('crudorders.index')->with('success', '¡Orden creada con éxito!');
    }

    // Muestra los detalles de una orden específica
    public function show(Order $order)
    {
        return view('crudorders.show', compact('order')); // Asegúrate de usar la vista correcta
    }

    // Muestra el formulario para editar una orden existente
    public function edit(Order $order)
    {
        $customers = Customer::all();
        $employees = Employee::all();
        $paymentMethods = PaymentMethod::all();
        return view('crudorders.edit', compact('order', 'customers', 'employees', 'paymentMethods')); // Asegúrate de usar la vista correcta
    }

    // Actualiza una orden existente en la base de datos
    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'nullable|exists:employees,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount_paid' => 'required|numeric|min:0',
            'change' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        $order->customer_id = $validatedData['customer_id'];
        $order->employee_id = $validatedData['employee_id'];
        $order->total = $validatedData['total'];
        $order->paid = $validatedData['amount_paid'];
        $order->change = $validatedData['change'] ?? 0;
        $order->save();

        // Actualizar el pago si es necesario
        $payment = OrderPayment::where('order_id', $order->id)->first();
        if ($payment) {
            $payment->payment_method_id = $validatedData['payment_method_id'];
            $payment->amount = $validatedData['amount_paid'];
            $payment->save();
        }

        return redirect()->route('crudorders.index')->with('success', '¡Orden actualizada con éxito!');
    }

    // Elimina una orden específica de la base de datos
    public function destroy(Order $order)
    {
        // Eliminar la orden y sus pagos asociados
        $order->delete();
        OrderPayment::where('order_id', $order->id)->delete();

        return redirect()->route('crudorders.index')->with('success', '¡Orden eliminada con éxito!');
    }
}
