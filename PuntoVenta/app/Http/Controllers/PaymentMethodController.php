<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


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
     /**
     * Exporta los datos de métodos de pago a un archivo Excel.
     */
    public function exportData(Request $request)
    {
        // Obtener todos los datos de métodos de pago con filtrado si es necesario
        $paymentMethods = PaymentMethod::query()
            ->where('name', 'like', "%{$request->get('search', '')}%")
            ->orderBy('id') // Ordena por ID por defecto
            ->get(); // Obtén todos los datos en lugar de paginados

        // Crear una matriz para los datos de métodos de pago
        $paymentMethodArray = [
            ['ID', 'Nombre'],
        ];

        // Llena la matriz con los datos de métodos de pago
        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethodArray[] = [
                $paymentMethod->id,
                $paymentMethod->name,
            ];
        }

        // Exportar los datos a Excel
        return $this->exportExcel($paymentMethodArray);
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
            header('Content-Disposition: attachment;filename="PaymentMethods_ExportedData.xlsx"');
            header('Cache-Control: max-age=0');

            ob_end_clean(); // Limpia el buffer de salida
            $writer->save('php://output'); // Envía el archivo a la salida
            exit(); // Asegúrate de que el script se detenga después de enviar el archivo
        } catch (\Exception $e) {
            return redirect()->route('payment_methods.index')->with('error', 'Error al exportar los datos.');
        }
    }
}
