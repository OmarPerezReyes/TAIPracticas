<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CategoryController extends Controller
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

        return view('categories.index', [
            'categories' => Category::filter(request(['search']))
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
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug|alpha_dash',
        ];

        $validatedData = $request->validate($rules);

        Category::create($validatedData);

        return Redirect::route('categories.index')->with('success', 'Categoria registrada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|unique:categories,name,'.$category->id,
            'slug' => 'required|alpha_dash|unique:categories,slug,'.$category->id,
        ];

        $validatedData = $request->validate($rules);

        Category::where('slug', $category->slug)->update($validatedData);

        return Redirect::route('categories.index')->with('success', 'Categoria actualizada!');
    }

    public function destroy($slug)
{
    // Buscar la categoría por el slug
    $category = Category::where('slug', $slug)->firstOrFail();
    
    // Verificar si la categoría tiene productos asociados
    if ($category->products()->count() > 0) {
        // Si existen productos, redirigir con un mensaje de error
        return Redirect::route('categories.index')
            ->with('error', 'La categoría no puede ser eliminada porque tiene productos asociados.');
    }

    // Eliminar la categoría
    $category->delete();

    // Redirigir con un mensaje de éxito
    return Redirect::route('categories.index')
        ->with('success', 'Categoría eliminada con éxito.');
}


/**
     * Exporta los datos de categorías a un archivo Excel.
     */
    public function exportData(Request $request)
    {
        // Obtener todos los datos de categorías con filtrado si es necesario
        $categories = Category::filter($request->only('search')) // Aplica el filtro de búsqueda si existe
            ->orderBy('id') // Ordena por ID por defecto
            ->get(); // Obtén todos los datos en lugar de paginados

        // Crear una matriz para los datos de categorías
        $category_array = [
            ['ID', 'Nombre', 'Slug'],
        ];

        // Llena la matriz con los datos de categorías
        foreach ($categories as $category) {
            $category_array[] = [
                $category->id,
                $category->name,
                $category->slug,
            ];
        }

        // Exportar los datos a Excel
        return $this->exportExcel($category_array);
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
            header('Content-Disposition: attachment;filename="Categories_ExportedData.xlsx"');
            header('Cache-Control: max-age=0');

            ob_end_clean(); // Limpia el buffer de salida
            $writer->save('php://output'); // Envía el archivo a la salida
            exit(); // Asegúrate de que el script se detenga después de enviar el archivo
        } catch (\Exception $e) {
            return Redirect::route('categories.index')->with('error', 'Error al exportar los datos.');
        }
    }
    
}
