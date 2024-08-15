<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\OrderPayment;
use App\Models\DetailsOrder;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    public function show($id)
    {
        // Obtén la orden con el ID proporcionado, incluyendo las relaciones
        $order = Order::with('customer', 'paymentMethod', 'employee')->find($id);
    
        // Verifica si la orden existe
        if (!$order) {
            abort(404, 'Orden no encontrada.');
        }
    
        // Carga los detalles de la orden usando el ID de la orden
        $orderDetails = DetailsOrder::where('order_id', $order->id)
                                    ->with('product')  // Asegúrate de que también obtienes los datos del producto
                                    ->get();
    
        // Verifica los datos obtenidos antes de desplegar la vista
        /*dd([
            'Order' => $order,
            'Order Details' => $orderDetails,
            'Customer' => $order->customer,
            'Payment Method' => $order->paymentMethod,
            'Employee' => $order->employee,
        ]);*/
    
        // Descomenta la siguiente línea para devolver la vista una vez confirmados los datos
        return view('crudorders.show', compact('order', 'orderDetails'));
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

    /**
     * Exporta los datos de órdenes a un archivo Excel.
     */
    public function exportData(Request $request)
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

        // Obtener los datos
        $orders = $query->get();

        // Crear una matriz para los datos de órdenes
        $orderArray = [
            ['ID', 'Cliente', 'Empleado', 'Método de Pago', 'Monto Pagado', 'Cambio', 'Total'],
        ];

        // Llena la matriz con los datos de órdenes
        foreach ($orders as $order) {
            $orderArray[] = [
                $order->id,
                $order->customer->name ?? 'N/A',
                $order->employee->name ?? 'N/A',
                $order->orderPayments->first()->paymentMethod->name ?? 'N/A',
                $order->paid,
                $order->change,
                $order->total,
            ];
        }

        // Exportar los datos a Excel
        return $this->exportExcel($orderArray);
    }

    /**
     * Maneja la exportación de datos a un archivo Excel.
     */
    private function exportExcel($data)
    {
        ini_set('max_execution_time', 0); // Evita el tiempo máximo de ejecución
        ini_set('memory_limit', '4000M'); // Ajusta el límite de memoria

        try {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->getActiveSheet()->fromArray($data);
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);

            $writer = new Xlsx($spreadsheet);

            // Configura las cabeceras de la respuesta HTTP
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Orders_ExportedData.xlsx"');
            header('Cache-Control: max-age=0');

            ob_end_clean(); // Limpia el buffer de salida
            $writer->save('php://output'); // Envía el archivo a la salida
            exit(); // Asegúrate de que el script se detenga después de enviar el archivo
        } catch (\Exception $e) {
            return redirect()->route('crudorders.index')->with('error', 'Error al exportar los datos.');
        }
    }
}
