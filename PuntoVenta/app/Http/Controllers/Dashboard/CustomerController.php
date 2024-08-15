<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CustomerController extends Controller
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

        return view('customers.index', [
            'customers' => Customer::filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Mostrar todos los datos recibidos
        // dd($request->all());
    
        // Eliminar las reglas de validación
        // $rules = [
        //     'photo' => 'image|file|max:1024',
        //     'name' => 'required|string|max:50',
        //     'email' => 'required|email|max:50|unique:customers,email',
        //     'phone' => 'required|string|max:15|unique:customers,phone',
        //     'RFC' => 'required|string|max:13|unique:customers,RFC',
        //     'razon_social' => 'required|string|max:100',
        //     'codigo_postal' => 'required|string|max:5',
        //     'regimen_fiscal' => 'required|string|max:50',
        //     'address' => 'required|string|max:100',
        // ];
    
        // Eliminar la validación de datos
        // $validatedData = $request->validate($rules);
    
        // Mostrar los datos recibidos sin validar
        $validatedData = $request->all();
        //dd($validatedData);
    
        /**
         * Manejar la carga de la imagen con Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/customers/';
    
            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
    
            // Mostrar los datos después de manejar la imagen
            //dd($validatedData);
        }
    
        $customer = Customer::create($validatedData);
    
        // Mostrar el cliente creado
        //dd($customer);
    
        return Redirect::route('customers.index')->with('success', 'Datos del cliente registrados!');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', [
            'customer' => $customer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:customers,email,'.$customer->id,
            'phone' => 'required|string|max:15|unique:customers,phone,'.$customer->id,
            'RFC' => 'required|string|max:13|unique:customers,RFC,'.$customer->id,
            'razon_social' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:5',
            'regimen_fiscal' => 'required|string|max:50',
            'address' => 'required|string|max:100',
        ];

        $validatedData = $request->validate($rules);

        
        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/customers/';

            /**
             * Delete photo if exists.
             */
            if($customer->photo){
                Storage::delete($path . $customer->photo);
            }

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Customer::where('id', $customer->id)->update($validatedData);

        return Redirect::route('customers.index')->with('success', 'Datos del cliente actualizados!');
    }

   /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Verifica si el cliente tiene órdenes asociadas
        $hasOrders = DB::table('orders')
                       ->where('customer_id', $customer->id)
                       ->exists();

        if ($hasOrders) {
            // Redirige con un mensaje de error si el cliente tiene órdenes asociadas
            return Redirect::route('customers.index')
                           ->with('error', 'No se puede eliminar el cliente porque tiene órdenes asociadas.');
        }

        // Elimina la foto si existe
        if ($customer->photo) {
            Storage::delete('public/customers/' . $customer->photo);
        }

        // Elimina el cliente
        Customer::destroy($customer->id);

        // Redirige con un mensaje de éxito
        return Redirect::route('customers.index')
                       ->with('success', 'Datos del cliente eliminados!');
    }


    /**
     * Exporta los datos de clientes a un archivo Excel.
     */
    public function exportData(Request $request)
    {
        $query = Customer::query();

        // Filtrar por búsqueda
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('RFC', 'like', "%$search%")
                  ->orWhere('razon_social', 'like', "%$search%")
                  ->orWhere('codigo_postal', 'like', "%$search%")
                  ->orWhere('regimen_fiscal', 'like', "%$search%");
            });
        }

        // Obtener los datos
        $customers = $query->get();

        // Crear una matriz para los datos de clientes
        $headers = [
            'No.',
            'Foto',
            'Nombre',
            'Email',
            'Teléfono',
            'RFC',
            'Razón Social',
            'Código Postal',
            'Régimen Fiscal'
        ];

        $data = [];

        foreach ($customers as $index => $customer) {
            $data[] = [
                $index + 1,
                $customer->photo ? asset('storage/customers/' . $customer->photo) : asset('assets/images/user/1.png'),
                $customer->name,
                $customer->email,
                $customer->phone,
                $customer->RFC,
                $customer->razon_social,
                $customer->codigo_postal,
                $customer->regimen_fiscal,
            ];
        }

        // Exportar los datos a Excel
        return $this->exportExcel($data, $headers);
    }

    /**
     * Maneja la exportación de datos a un archivo Excel.
     */
    private function exportExcel($data, $headers)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Ajustar el ancho de las columnas
            $sheet->getDefaultColumnDimension()->setWidth(20);

            // Agregar encabezados
            $sheet->fromArray($headers, null, 'A1');

            // Agregar datos
            $sheet->fromArray($data, null, 'A2');

            $writer = new Xlsx($spreadsheet);

            // Configurar las cabeceras de la respuesta HTTP
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Clientes_Exportados.xlsx"');
            header('Cache-Control: max-age=0');

            ob_end_clean(); // Limpiar el buffer de salida
            $writer->save('php://output'); // Enviar el archivo a la salida
            exit(); // Asegurarse de que el script se detenga después de enviar el archivo
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'Error al exportar los datos.');
        }
    }

}
