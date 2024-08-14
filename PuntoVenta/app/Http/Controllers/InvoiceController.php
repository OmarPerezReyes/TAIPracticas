<?php
namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Cart;
use App\Models\Customer;

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
}
