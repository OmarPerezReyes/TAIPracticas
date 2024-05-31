<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Muestra una lista de los inventarios.
     */
    public function index()
    {
        return view('inventario.index', [
            'inventario' => Inventario::latest()->paginate(4)
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo inventario.
     */
    public function create()
    {
        // Obtener todas las categorías para el formulario de creación
        $categorias = Categoria::all();
        $productos = Producto::all();
        return view('inventario.create', compact('categorias', 'productos'));
    }

    /**
     * Almacena un nuevo inventario en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'fecha_movimiento' => 'required|date_format:Y-m-d\TH:i',
            'motivo' => 'nullable|string',
            'movimiento' => 'required|in:Entrada,Salida',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Mostrar los datos validados en la consola
        //dd($validated);

        // Crear el inventario
        Inventario::create($validated);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('inventario.index')
        ->withSuccess('Nuevo movimiento agregado.');    }


    /**
     * Muestra el inventario especificado.
     */
    public function show(Inventario $inventario)
    {
        return view('inventario.show', compact('inventario'));
    }

    /**
     * Muestra el formulario para editar el inventario especificado.
     */
    public function edit(Inventario $inventario)
    {
        $categorias = Categoria::all();
        $productos = Producto::all();
        return view('inventario.edit', compact('inventario','categorias','productos'));
    }

    /**
     * Actualiza el inventario especificado en la base de datos.
     */
    public function update(Request $request, Inventario $inventario)
    {
        // Validar los datos
        $validated = $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'fecha_movimiento' => 'required|date_format:Y-m-d\TH:i',
            'motivo' => 'nullable|string',
            'movimiento' => 'required|in:Entrada,Salida',
            'cantidad' => 'required|integer|min:1',
        ]);
        //dd($validated);

        // Actualizar el inventario
        $inventario->update($validated);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('inventario.index')
        ->withSuccess('Movimiento modificado.');    
    }

    /**
     * Elimina el inventario especificado de la base de datos.
     */
    public function destroy(Inventario $inventario)
    {
        // Eliminar el inventario
        $inventario->delete();

        // Redireccionar con un mensaje de éxito
        return redirect()->route('inventario.index')->with('success', 'Inventario eliminado correctamente.');
    }
}
