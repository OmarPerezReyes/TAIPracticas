<?php
namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\DetailsOrder;

class InvoiceController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Obtener los datos necesarios
        $customer = Customer::find($request->customer_id);
        $content = Cart::content();

        // Cargar la vista y pasarle los datos
        $pdf = PDF::loadView('pdf.invoice', compact('customer', 'content'));

        // Opción 1: Descargar el PDF
        // return $pdf->download('invoice.pdf');

        // Opción 2: Mostrar el PDF en el navegador
        return $pdf->stream('invoice.pdf');
    }

    public function generateOrderPDF(Request $request)
    {
         // Obtén la orden con el ID proporcionado, incluyendo las relaciones
         $order = Order::with('customer', 'paymentMethod', 'employee')->find($request->order_id);
    
         // Verifica si la orden existe
         if (!$order) {
             abort(404, 'Orden no encontrada.');
         }
     
         // Carga los detalles de la orden usando el ID de la orden
         $orderDetails = DetailsOrder::where('order_id', $order->id)
                                     ->with('product')  // Asegúrate de que también obtienes los datos del producto
                                     ->get();
     
        // Verificar si el pedido fue encontrado
        if (!$order) {
            abort(404, 'Pedido no encontrado.');
        }

        // Cargar la vista y pasarle los datos
        $pdf = PDF::loadView('pdf.printorder', [
            'order' => $order,
            'orderDetails' => $orderDetails
        ]);

        // Opción 1: Descargar el PDF
         return $pdf->download('printorder.pdf');

        // Opción 2: Mostrar el PDF en el navegador
        //return $pdf->stream('printorder.pdf');
    }
}
