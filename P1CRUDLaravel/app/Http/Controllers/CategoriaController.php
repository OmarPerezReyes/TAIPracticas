<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategoriaController extends Controller
{
    /**
     * Muestra una lista paginada de todas las categorías.
     */
    public function index() : View
    {
        return view('categorias.index', [
            'categorias' => Categoria::latest()->paginate(4)
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create() : View
    {
        return view('categorias.create');
    }

    /**
     * Almacena una nueva categoría en la base de datos.
     */
    public function store(Request $request) : RedirectResponse
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:100'
        ]);

        // Crear una nueva categoría con los datos validados
        Categoria::create($validated);

        // Redireccionar de vuelta a la lista de categorías con un mensaje de éxito
        return redirect()->route('categorias.index')
                ->withSuccess('Nueva categoría agregada.');
    }

    /**
     * Muestra los detalles de una categoría específica.
     */
    public function show(Categoria $categoria) : View
    {
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Muestra el formulario para editar una categoría existente.
     */
    public function edit(Categoria $categoria) : View
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualiza una categoría existente en la base de datos.
     */
    public function update(Request $request, Categoria $categoria) : RedirectResponse
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:100'
        ]);

        // Actualizar la categoría con los datos validados
        $categoria->update($validated);

        // Redireccionar de vuelta a la página anterior con un mensaje de éxito
        return redirect()->back()
                ->withSuccess('Categoría actualizada correctamente.');
    }

    /**
     * Elimina una categoría existente de la base de datos.
     */
    public function destroy(Categoria $categoria) : RedirectResponse
    {
        // Eliminar la categoría
        $categoria->delete();

        // Redireccionar de vuelta a la lista de categorías con un mensaje de éxito
        return redirect()->route('categorias.index')
                ->withSuccess('Categoría eliminada correctamente.');
    }
}

