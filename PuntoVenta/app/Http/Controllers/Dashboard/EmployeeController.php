<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EmployeeController extends Controller
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

        return view('employees.index', [
            'employees' => Employee::filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:employees,email',
            'phone' => 'required|string|max:15|unique:employees,phone',
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/employees/';

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Employee::create($validatedData);

        return Redirect::route('employees.index')->with('success', 'Datos del vendedor registrados!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', [
            'employee' => $employee,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', [
            'employee' => $employee,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:employees,email,'.$employee->id,
            'phone' => 'required|string|max:20|unique:employees,phone,'.$employee->id,
        ];

        $validatedData = $request->validate($rules);

        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/employees/';

            /**
             * Delete photo if exists.
             */
            if($employee->photo){
                Storage::delete($path . $employee->photo);
            }

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Employee::where('id', $employee->id)->update($validatedData);

        return Redirect::route('employees.index')->with('success', 'Datos del vendedor actualizados!');
    }

   /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        // Verifica si el empleado tiene órdenes asociadas
        $hasOrders = DB::table('orders')
                       ->where('employee_id', $employee->id)
                       ->exists();

        if ($hasOrders) {
            // Redirige con un mensaje de error si el empleado tiene órdenes asociadas
            return Redirect::route('employees.index')
                           ->with('error', 'No se puede eliminar el vendedor porque tiene órdenes asociadas.');
        }

        // Elimina la foto si existe
        if ($employee->photo) {
            Storage::delete('public/employees/' . $employee->photo);
        }

        // Elimina el empleado
        Employee::destroy($employee->id);

        // Redirige con un mensaje de éxito
        return Redirect::route('employees.index')
                       ->with('success', 'Datos del vendedor eliminados!');
    }


    /**
     * Exporta los datos de vendedores a un archivo Excel.
     */
    public function exportData(Request $request)
    {
        $query = Employee::query();

        // Filtrar por búsqueda
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        // Obtener los datos
        $employees = $query->get();

        // Crear una matriz para los datos de empleados
        $employeeArray = [
            ['ID', 'Nombre', 'Email', 'Teléfono', 'Foto'],
        ];

        // Llena la matriz con los datos de empleados
        foreach ($employees as $employee) {
            $employeeArray[] = [
                $employee->id,
                $employee->name,
                $employee->email,
                $employee->phone,
                $employee->photo ? url('storage/employees/' . $employee->photo) : 'N/A',
            ];
        }

        // Exportar los datos a Excel
        return $this->exportExcel($employeeArray);
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
            header('Content-Disposition: attachment;filename="Employees_ExportedData.xlsx"');
            header('Cache-Control: max-age=0');

            ob_end_clean(); // Limpia el buffer de salida
            $writer->save('php://output'); // Envía el archivo a la salida
            exit(); // Asegúrate de que el script se detenga después de enviar el archivo
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'Error al exportar los datos.');
        }
    }
}
