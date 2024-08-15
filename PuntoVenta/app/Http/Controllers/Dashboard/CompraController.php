<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Stock;
use App\Models\PaymentMethod;
use Carbon\Carbon;

class CompraController extends Controller
{
    public function index(Request $request)
{
    // Filtrado y paginación
    $purchases = Purchase::with('product', 'supplier', 'paymentMethod')
        ->paginate($request->get('row', 10))  // Default rows per page
        ->appends($request->query());

    return view('compra.index', [
        'purchases' => $purchases,
    ]);
}

     // Mostrar el formulario para agregar una nueva compra
    public function create()
    {
        // Obtener proveedores, métodos de pago y productos
        $suppliers = Supplier::all();
        $paymentMethods = PaymentMethod::all();
        $products = Product::all(); // Asegúrate de tener un modelo Product y su base de datos configurada

        return view('compra.create', [
            'suppliers' => $suppliers,
            'paymentMethods' => $paymentMethods,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'quantity' => 'required|integer|min:1',
            'cost_individual' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'total' => 'required|numeric|min:0',
        ]);

        // Crear una nueva compra con los datos validados
        Purchase::create([
            'product_id' => $validated['product_id'],
            'supplier_id' => $validated['supplier_id'],
            'payment_method_id' => $validated['payment_method_id'],
            'quantity' => $validated['quantity'],
            'cost_individual' => $validated['cost_individual'],
            'discount' => $validated['discount'] ?? 0, // Usar valor 0 si el descuento es nulo
            'total' => $validated['total'],
        ]);

        Stock::create([
            'product_id' => $request->input('product_id'), // Ajusta esto según el modelo de datos real
            'date' => now(),
            'movement' => 'Entrada',
            'reason' => 'Compra de producto',
            'quantity' => $request->input('quantity'), // Cantidad vendida
        ]);

        // Actualizar el stock del producto
        $product = Product::find($request->input('product_id'));
        $product->product_garage += $request->input('quantity');
        $product->save();

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('compra.index')->with('success', 'Compra realizada exitosamente. El stock se ha actualizado');
    }

      /**
     * Exporta los datos de compras a un archivo Excel.
     */
    public function exportData(Request $request)
    {
        // Obtén todos los datos de compras con filtrado si es necesario
        $purchases = Purchase::with('product', 'supplier', 'paymentMethod')
            ->orderBy('id') // Ordena por ID por defecto
            ->get(); // Obtén todos los datos en lugar de paginados

        // Crear una matriz para los datos de compras
        $purchase_array = [
            ['ID', 'Producto', 'Proveedor', 'Método de Pago', 'Cantidad', 'Costo Individual', 'Descuento', 'Total', 'Fecha'],
        ];

        // Llena la matriz con los datos de compras
        foreach ($purchases as $purchase) {
            $purchase_array[] = [
                $purchase->id,
                $purchase->product->product_name,
                $purchase->supplier->name, // Ajusta si tu modelo Supplier tiene otro atributo para el nombre
                $purchase->paymentMethod->name, // Ajusta si tu modelo PaymentMethod tiene otro atributo para el nombre
                $purchase->quantity,
                $purchase->cost_individual,
                $purchase->discount,
                $purchase->total,
                Carbon::parse($purchase->created_at)->format('Y-m-d'), // Usa la fecha de creación
            ];
        }

        // Exportar los datos a Excel
        return $this->exportExcel($purchase_array);
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
            header('Content-Disposition: attachment;filename="Purchases_ExportedData.xlsx"');
            header('Cache-Control: max-age=0');

            ob_end_clean(); // Limpia el buffer de salida
            $writer->save('php://output'); // Envía el archivo a la salida
            exit(); // Asegúrate de que el script se detenga después de enviar el archivo
        } catch (\Exception $e) {
            return redirect()->route('compra.index')->with('error', 'Error al exportar los datos.');
        }
    }
}
