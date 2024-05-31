<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductoController extends Controller
{
    /**
     * Muestra una lista paginada de todos los productos.
     */
    public function index() : View
    {
        return view('productos.index', [
            'productos' => Producto::latest()->paginate(4)
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create() : View
    {
        // Obtener todas las categorías para el formulario de creación
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'pv' => 'required|numeric',
            'pc' => 'required|numeric',
            'fecha_compra' => 'nullable|date',
            'colores' => 'nullable|string|max:100',
            'descripcion_corta' => 'nullable|string|max:255',
            'descripcion_larga' => 'nullable|string'
        ]);
    
        // Crear un nuevo producto con los datos validados
        Producto::create($validated);
    
        // Redireccionar de vuelta a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')
                ->withSuccess('Nuevo producto agregado.');
    }

    /**
     * Muestra los detalles de un producto específico.
     */
    public function show(Producto $producto) : View
    {
        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario para editar un producto existente.
     */
    public function edit(Producto $producto) : View
    {
        // Obtener todas las categorías para el formulario de edición
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     */
    public function update(Request $request, Producto $producto) : RedirectResponse
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'pv' => 'required|numeric',
            'pc' => 'required|numeric',
            'fecha_compra' => 'nullable|date',
            'colores' => 'nullable|string|max:100',
            'descripcion_corta' => 'nullable|string|max:255',
            'descripcion_larga' => 'nullable|string'
        ]);

        // Actualizar el producto con los datos validados
        $producto->update($validated);

        // Redireccionar de vuelta a la página anterior con un mensaje de éxito
        return redirect()->back()
                ->withSuccess('Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto existente de la base de datos.
     */
    public function destroy(Producto $producto) : RedirectResponse
    {
        // Eliminar el producto
        $producto->delete();

        // Redireccionar de vuelta a la lista de productos con un mensaje de éxito
        return redirect()->route('productos.index')
                ->withSuccess('Producto eliminado correctamente.');
    }
    
}
