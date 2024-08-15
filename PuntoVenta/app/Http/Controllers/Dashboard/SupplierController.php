<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SupplierController extends Controller
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

        return view('suppliers.index', [
            'suppliers' => Supplier::filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:suppliers,email',
            'phone' => 'required|string|max:15|unique:suppliers,phone',
            'shopname' => 'required|string|max:50',
            'type' => 'required|string|max:25',
            'account_holder' => 'max:50',
            'account_number' => 'max:25',
            'bank_name' => 'max:25',
            'city' => 'required|string|max:50',
            'address' => 'required|string|max:100',
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/suppliers/';

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Supplier::create($validatedData);

        return Redirect::route('suppliers.index')->with('success', 'Datos del proveedor registrados');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:suppliers,email,'.$supplier->id,
            'phone' => 'required|string|max:15|unique:suppliers,phone,'.$supplier->id,
            'shopname' => 'required|string|max:50',
            'type' => 'required|string|max:25',
            'account_holder' => 'max:50',
            'account_number' => 'max:25',
            'bank_name' => 'max:25',
            'city' => 'required|string|max:50',
            'address' => 'required|string|max:100',
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/suppliers/';

            /**
             * Delete photo if exists.
             */
            if($supplier->photo){
                Storage::delete($path . $supplier->photo);
            }

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Supplier::where('id', $supplier->id)->update($validatedData);

        return Redirect::route('suppliers.index')->with('success', 'Datos del proveedor actualizados!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // Verificar si el proveedor tiene productos asociados
        if ($supplier->products()->count() > 0) {
            return Redirect::route('suppliers.index')->with('error', 'No se puede eliminar el proveedor porque tiene productos asociados.');
        }
    
        /**
         * Delete photo if exists.
         */
        if ($supplier->photo) {
            Storage::delete('public/suppliers/' . $supplier->photo);
        }
    
        // Eliminar el proveedor
        $supplier->delete();
    
        return Redirect::route('suppliers.index')->with('success', 'Datos del proveedor eliminados correctamente!');
    }

     /**
     * Exporta los datos de proveedores a un archivo Excel.
     */
    public function exportData(Request $request)
    {
        $query = Supplier::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('shopname', 'like', "%$search%")
                  ->orWhere('type', 'like', "%$search%")
                  ->orWhere('city', 'like', "%$search%");
            });
        }

        $suppliers = $query->get();

        $headers = [
            'No.',
            'Foto',
            'Nombre',
            'Email',
            'Teléfono',
            'Nombre de la Tienda',
            'Tipo',
            'Titular de Cuenta',
            'Número de Cuenta',
            'Nombre del Banco',
            'Ciudad',
            'Dirección'
        ];

        $data = [];

        foreach ($suppliers as $index => $supplier) {
            $data[] = [
                $index + 1,
                $supplier->photo ? asset('storage/suppliers/' . $supplier->photo) : asset('assets/images/user/1.png'),
                $supplier->name,
                $supplier->email,
                $supplier->phone,
                $supplier->shopname,
                $supplier->type,
                $supplier->account_holder,
                $supplier->account_number,
                $supplier->bank_name,
                $supplier->city,
                $supplier->address,
            ];
        }

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
            
            $sheet->getDefaultColumnDimension()->setWidth(20);

            $sheet->fromArray($headers, null, 'A1');
            $sheet->fromArray($data, null, 'A2');

            $writer = new Xlsx($spreadsheet);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Proveedores_Exportados.xlsx"');
            header('Cache-Control: max-age=0');

            ob_end_clean();
            $writer->save('php://output');
            exit();
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Error al exportar los datos.');
        }
    }
}
