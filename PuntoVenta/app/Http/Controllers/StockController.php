<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;


class StockController extends Controller
{
    public function index(Request $request)
    {
        // Filtrado y paginación
        $stocks = Stock::with('product')
            ->filter($request->only('search'))  // Asegúrate de tener un scope filter en tu modelo Stock
            
            ->sortable()  // Asegúrate de tener un scope sortable en tu modelo Stock
            ->paginate($request->get('row', 10))  // Default rows per page
            ->appends($request->query());
            $sortBy = $request->input('sort_by', 'id'); // Ordenar por ID por defecto
            $sortOrder = $request->input('sort_order', 'asc'); // Orden ascendente por defecto
        

        return view('stock.index', [
            'stocks' => $stocks,
        ]);
    }

    public function manage()
    {
        $products = Product::all();
        return view('stock.manage', compact('products'));
    }

    public function store(Request $request)
    {
        // Mostrar los datos recibidos antes de la validación
        //dd($request->all());


        $request->validate([
            'product_id' => 'required|exists:products,id',
            'date' => 'required|date',
            'quantity' => 'required|numeric',
            'movement' => 'required|in:Entrada,Salida',
            'reason' => 'nullable|string',
        ]);


        $stock = Stock::create([
            'product_id' => $request->input('product_id'),
            'date' => $request->input('date'),
            'movement' => $request->input('movement'),
            'reason' => $request->input('reason'),
            'quantity' => $request->input('quantity'),
        ]);

        // Actualizar el stock del producto
        $product = Product::find($request->input('product_id'));
        if ($request->input('movement') === 'Entrada') {
            $product->product_garage += $request->input('quantity');
        } else {
            $product->product_garage -= $request->input('quantity');
        }
        $product->save();

        return redirect()->route('stocks.index')->with('success', 'Movimiento registrado exitosamente.');
    }

     // Método para exportar datos de stock a Excel
     public function exportData(Request $request)
     {
         $stocks = Stock::with('product')
             ->filter($request->only('search'))
             ->sortable()
             ->get(); // Obtén todos los datos en lugar de paginados
 
         $stock_array[] = [
             'ID',
             'Producto',
             'Fecha',
             'Movimiento',
             'Motivo',
             'Cantidad',
         ];
 
         foreach ($stocks as $stock) {
             $stock_array[] = [
                 $stock->id,
                 $stock->product->product_name,
                 Carbon::parse($stock->date)->format('Y-m-d'), // Conversión manual
                 ucfirst($stock->movement),
                 $stock->reason,
                 $stock->quantity,
             ];
         }
 
         return $this->exportExcel($stock_array);
     }
 
     // Método para exportar a Excel
     public function exportExcel($data)
     {
         ini_set('max_execution_time', 0);
         ini_set('memory_limit', '4000M');
 
         try {
             $spreadSheet = new Spreadsheet();
             $spreadSheet->getActiveSheet()->fromArray($data);
             $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
             $Excel_writer = new Xlsx($spreadSheet);
             header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
             header('Content-Disposition: attachment;filename="Stock_ExportedData.xlsx"');
             header('Cache-Control: max-age=0');
             ob_end_clean();
             $Excel_writer->save('php://output');
             exit();
         } catch (\Exception $e) {
             return redirect()->route('stocks.index')->with('error', 'Error al exportar los datos.');
         }
     }
}
