<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Employee;
use App\Models\Stock;


class PosController extends Controller
{
    public function index()
    {
        $todayDate = Carbon::now(); // Obtiene la fecha y hora actual
        $row = (int) request('row', 10); // Obtiene el número de filas para paginación desde la solicitud, o usa 10 por defecto

        // Verifica que el número de filas esté entre 1 y 100
        if ($row < 1 || $row > 100) {
            abort(400, 'El parámetro de filas debe ser un entero entre 1 y 100.');
        }

        // Retorna la vista principal con datos necesarios
        return view('pos.index', [
            'customers' => Customer::all()->sortBy('name'), // Obtiene todos los clientes ordenados por nombre
            'productItem' => Cart::content(), // Obtiene el contenido del carrito de compras
            'products' => Product::where('expire_date', '>', $todayDate)->filter(request(['search']))
                ->sortable() // Habilita la ordenación
                ->paginate($row) // Pagina los resultados según el número de filas especificado
                ->appends(request()->query()), // Mantiene los parámetros de consulta en la paginación
        ]);
    }

    public function addCart(Request $request)
    {
        $rules = [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'price' => 'required|numeric',
        ];
    
        $validatedData = $request->validate($rules);
    
        // Obtener el producto de la base de datos
        $product = Product::find($validatedData['id']);
    
        // Verificar si el producto tiene inventario
        if ($product->product_garage <= 0) {
            return redirect()->back()->with('error', 'Se ha agotado el inventario del producto seleccionado.');
        }
    
        // Verificar si el producto ya está en el carrito
        $cartItem = Cart::content()->where('id', $validatedData['id'])->first();
    
        if ($cartItem) {
            // Si el producto ya está en el carrito, actualizar la cantidad
            $currentQuantity = $cartItem->qty;
            $newQuantity = $currentQuantity + 1;
    
            // Verificar si la nueva cantidad excede el inventario disponible
            if ($newQuantity > $product->product_garage) {
                return redirect()->back()->with('warning', 'No se puede añadir más del stock disponible. La cantidad en el carrito no ha sido modificada.');
            }
    
            // Actualizar la cantidad en el carrito
            Cart::update($cartItem->rowId, $newQuantity);
        } else {
            // Si el producto no está en el carrito, añadirlo
            Cart::add([
                'id' => $validatedData['id'],
                'name' => $validatedData['name'],
                'qty' => 1, // Cantidad inicial del producto es 1
                'price' => $validatedData['price'],
                'options' => ['size' => 'large']
            ]);
        }
    
        return redirect()->back()->with('success', '¡Producto añadido con éxito!');
    }

    public function updateCart(Request $request, $rowId)
    {
        $validatedData = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);
    
        // Obtener el producto del carrito y la información actual del producto
        $item = Cart::get($rowId);
        $product = Product::find($item->id);
    
        // Verificar si la cantidad solicitada excede el inventario disponible
        if ($validatedData['qty'] > $product->product_garage) {
            // Ajustar la cantidad al máximo disponible
            Cart::update($rowId, $product->product_garage);
            return redirect()->back()->with('warning', 'La cantidad solicitada ha sido ajustada al máximo disponible.');
        }
    
        // Actualizar la cantidad del carrito con la cantidad solicitada
        Cart::update($rowId, $validatedData['qty']);
    
        return redirect()->back()->with('success', 'Cantidad actualizada en el carrito.');
    }

    public function deleteCart(String $rowId)
    {
        // Elimina el producto del carrito
        Cart::remove($rowId);

        // Redirige de vuelta con un mensaje de éxito
        return Redirect::back()->with('success', '¡Producto eliminado del carrito!');
    }

    public function createInvoice(Request $request)
    {
        $rules = [
            'customer_id' => 'required' // ID del cliente es requerido
        ];
    
        // Valida los datos de la solicitud
        $validatedData = $request->validate($rules);
        $customer = Customer::where('id', $validatedData['customer_id'])->first(); // Obtiene el cliente
        $content = Cart::content(); // Obtiene el contenido del carrito
    
        // Asegúrate de obtener los empleados y métodos de pago
        $employees = Employee::all();
        $paymentMethods = PaymentMethod::all();
    
        // Retorna la vista para crear la factura
        return view('pos.create-invoice', [
            'customer' => $customer,
            'content' => $content,
            'employees' => $employees,
            'paymentMethods' => $paymentMethods
        ]);
    }
    

    public function printInvoice(Request $request)
    {
        $rules = [
            'customer_id' => 'required' // ID del cliente es requerido
        ];

        // Valida los datos de la solicitud
        $validatedData = $request->validate($rules);
        $customer = Customer::where('id', $validatedData['customer_id'])->first(); // Obtiene el cliente
        $content = Cart::content(); // Obtiene el contenido del carrito

        // Retorna la vista para imprimir la factura
        return view('pos.print-invoice', [
            'customer' => $customer,
            'content' => $content
        ]);
    }

    public function showPaymentForm()
    {
        return view('pos.payment-form', [
            'paymentMethods' => PaymentMethod::all(),
        ]);
    }

    public function processPayment(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'nullable|exists:users,id', // Assuming vendor user
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount_paid' => 'required|numeric|min:0',
            'change' => 'required|numeric|min:0',
        ]);

        // Crear un nuevo pedido
        $order = Order::create([
            'customer_id' => $validatedData['customer_id'],
            'user_id' => $validatedData['user_id'],
            'total' => Cart::total(),
            'paid' => $validatedData['amount_paid'],
            'change' => $validatedData['change'],
        ]);

        // Registrar el pago
        OrderPayment::create([
            'order_id' => $order->id,
            'payment_method_id' => $validatedData['payment_method_id'],
            'amount' => $validatedData['amount_paid'],
        ]);

        // Vaciar el carrito
        Cart::destroy();

        return redirect()->route('pos.index')->with('success', '¡Pedido completado con éxito!');
    }
   
    public function store(Request $request)
{
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'employee_id' => 'nullable|exists:employees,id',
        'payment_method_id' => 'required|exists:payment_methods,id',
        'amount_paid' => 'required|numeric|min:0',
        'change' => 'nullable|numeric|min:0',
        'total' => 'required|numeric|min:0',
    ]);

    // Crear una nueva orden
    $order = new Order();
    $order->customer_id = $validatedData['customer_id'];
    $order->employee_id = $validatedData['employee_id'];
    $order->total = $validatedData['total'];
    $order->paid = $validatedData['amount_paid'];
    $order->change = $validatedData['change'] ?? 0;
    $order->save();

    // Registrar el pago
    $payment = new OrderPayment();
    $payment->order_id = $order->id;
    $payment->payment_method_id = $validatedData['payment_method_id'];
    $payment->amount = $validatedData['amount_paid'];
    $payment->save();

    // Registrar la salida de stock para cada producto en la orden
    foreach (Cart::content() as $item) {
        // Asumimos que el modelo `Stock` está relacionado con el producto a través de `product_id`
        // y que `Stock::create` es el método para agregar un nuevo registro de movimiento de inventario
        Stock::create([
            'product_id' => $item->id, // Ajusta esto según el modelo de datos real
            'date' => now(),
            'movement' => 'Salida',
            'reason' => 'Venta de producto',
            'quantity' => $item->qty, // Cantidad vendida
        ]);

        // Actualizar la cantidad en el inventario del producto
        $product = Product::find($item->id); // Encuentra el producto por ID
        if ($product) {
            $product->product_garage -= $item->qty; // Resta la cantidad vendida del stock
            $product->save(); // Guarda los cambios en la base de datos
        }
    }

    // Vaciar el carrito
    Cart::destroy();

    // Redirigir con mensaje de éxito
    return redirect()->route('pos.index')->with('success', '¡Pago realizado, pedido finalizado e inventario actualizado con éxito!');
}

}
