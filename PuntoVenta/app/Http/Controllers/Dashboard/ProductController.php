<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Redirect;

use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Picqer\Barcode\BarcodeGeneratorHTML;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('products.index', [
            'products' => Product::with(['category', 'supplier'])
                ->filter(request(['search']))
                ->sortable()
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create', [
            'categories' => Category::all(),
            'suppliers' => Supplier::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * Update stock
     */

   /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Generar un código de producto
        $product_code = IdGenerator::generate([
            'table' => 'products',
            'field' => 'product_code',
            'length' => 4,
            'prefix' => 'PC'
        ]);

        // Reglas de validación
        $rules = [
            'product_image' => 'image|file|max:1024',
            'product_name' => 'required|string',
            'category_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'short_description' => 'string|nullable',
            'long_description' => 'string|nullable',
            'product_garage' => 'required|integer|min:1',
            'buying_date' => 'required|date_format:Y-m-d',
            'expire_date' => [
                'required',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) use ($request) {
                    $buyingDate = $request->input('buying_date');
                    if ($value < $buyingDate) {
                        $fail('La fecha de expiración debe ser mayor o igual a la fecha de compra.');
                    }
                },
            ],
            'buying_price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'selling_price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
        ];
        
        // Validar los datos del request
        $validatedData = $request->validate($rules);
        
        $validatedData['buying_price'] = number_format($request->input('buying_price'), 3, '.', '');
        $validatedData['selling_price'] = number_format($request->input('selling_price'), 3, '.', '');


        // Guardar el código de producto en los datos validados
        $validatedData['product_code'] = $product_code;

        // Manejar la carga de la imagen del producto
        if ($file = $request->file('product_image')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/products/';

            $file->storeAs($path, $fileName);
            $validatedData['product_image'] = $fileName;
        }

        // Crear el producto con los datos validados
        $product = Product::create($validatedData);

        // Registrar la entrada de stock
        Stock::create([
            'product_id' => $product->id,
            'date' => now(),
            'movement' => 'Entrada',
            'reason' => 'Nuevo producto agregado',
            'quantity' => $product->product_garage, // O la cantidad inicial que configures
        ]);


        // Redirigir con mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto agregado y stock registrado.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Barcode Generator
        $generator = new BarcodeGeneratorHTML();

        $barcode = $generator->getBarcode($product->product_code, $generator::TYPE_CODE_128);

        return view('products.show', [
            'product' => $product,
            'barcode' => $barcode,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', [
            'categories' => Category::all(),
            'suppliers' => Supplier::all(),
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'product_image' => 'image|file|max:1024',
            'product_name' => 'required|string',
            'category_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'short_description' => 'string|nullable',
            'long_description' => 'string|nullable',
            'product_garage' => 'string|nullable',
            'buying_date' => 'date_format:Y-m-d|max:10|nullable',
            'expire_date' => 'date_format:Y-m-d|max:10|nullable',
            'buying_price' => 'required|integer',
            'selling_price' => 'required|integer',
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('product_image')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/products/';

            /**
             * Delete photo if exists.
             */
            if ($product->product_image) {
                Storage::delete($path . $product->product_image);
            }

            $file->storeAs($path, $fileName);
            $validatedData['product_image'] = $fileName;
        }

        Product::where('id', $product->id)->update($validatedData);

        return Redirect::route('products.index')->with('success', 'Producto actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        /**
         * Delete photo if exists.
         */
        if ($product->product_image) {
            Storage::delete('public/products/' . $product->product_image);
        }

        Product::destroy($product->id);

        return Redirect::route('products.index')->with('success', 'Producto eliminado!');
    }

    public function exportExcel($products)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Products_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * This function loads the product data from the database then converts it
     * into an Array that will be exported to Excel
     */
    function exportData()
    {
        $products = Product::all()->sortByDesc('id');

        $product_array[] = array(
            'Product Name',
            'Category Id',
            'Supplier Id',
            'Product Code',
            'Product Garage',
            'Product Image',
            'Short Description', // Updated column name
            'Long Description',  // Updated column name
            'Buying Date',
            'Expire Date',
            'Buying Price',
            'Selling Price',
        );

        foreach ($products as $product) {
            $product_array[] = array(
                'Product Name' => $product->product_name,
                'Category Id' => $product->category_id,
                'Supplier Id' => $product->supplier_id,
                'Product Code' => $product->product_code,
                'Product Garage' => $product->product_garage,
                'Product Image' => $product->product_image,
                'Short Description' => $product->short_description, // Updated field
                'Long Description' => $product->long_description,  // Updated field
                'Buying Date' => $product->buying_date,
                'Expire Date' => $product->expire_date,
                'Buying Price' => $product->buying_price,
                'Selling Price' => $product->selling_price,
            );
        }

        $this->exportExcel($product_array);
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
            'type' => 'required|in:entry,exit',
            'reason' => 'nullable|string',
        ]);

        $product = Product::find($request->input('product_id'));
        $quantity = $request->input('quantity');
        $type = $request->input('type');

        if ($type === 'entry') {
            $product->product_garage += $quantity;
        } else {
            $product->product_garage -= $quantity;
        }

        $product->save();

        // Registrar el movimiento en la tabla stock
        Stock::create([
            'product_id' => $product->id,
            'date' => now(),
            'movement' => $type,
            'reason' => $request->input('reason'),
            'quantity' => $quantity,
        ]);

        return redirect()->route('products.manageStock')->with('success', 'Stock actualizado exitosamente.');
    }

}
