<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;

class PosController extends Controller
{
    /**
     * Muestra la vista principal del punto de venta con los productos y clientes disponibles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $todayDate = Carbon::now(); // Obtiene la fecha y hora actual
        $row = (int) request('row', 10); // Obtiene el número de filas para paginación desde la solicitud, o usa 10 por defecto

        // Verifica que el número de filas esté entre 1 y 100
        if ($row < 1 || $row > 100) {
            abort(400, 'El parámetro de filas debe ser un entero entre 1 y 100.');
        }

        // Retorna la vista principal con datos necesarios
        return view('pos.index', [
            'customers' => Customer::all()->sortBy('name'), // Obtiene todos los clientes ordenados por nombre
            'productItem' => Cart::content(), // Obtiene el contenido del carrito de compras
            'products' => Product::where('expire_date', '>', $todayDate)->filter(request(['search']))
                ->sortable() // Habilita la ordenación
                ->paginate($row) // Pagina los resultados según el número de filas especificado
                ->appends(request()->query()), // Mantiene los parámetros de consulta en la paginación
        ]);
    }

    /**
     * Añade un producto al carrito de compras.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCart(Request $request)
    {
        $rules = [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'price' => 'required|numeric',
        ];
    
        $validatedData = $request->validate($rules);
    
        // Obtener el producto de la base de datos
        $product = Product::find($validatedData['id']);
    
        // Verificar si el producto tiene inventario
        if ($product->product_garage <= 0) {
            return redirect()->back()->with('error', 'Se ha agotado el inventario del producto seleccionado.');
        }
    
        // Verificar si el producto ya está en el carrito
        $cartItem = Cart::content()->where('id', $validatedData['id'])->first();
    
        if ($cartItem) {
            // Si el producto ya está en el carrito, actualizar la cantidad
            $currentQuantity = $cartItem->qty;
            $newQuantity = $currentQuantity + 1;
    
            // Verificar si la nueva cantidad excede el inventario disponible
            if ($newQuantity > $product->product_garage) {
                return redirect()->back()->with('warning', 'No se puede añadir más del stock disponible. La cantidad en el carrito no ha sido modificada.');
            }
    
            // Actualizar la cantidad en el carrito
            Cart::update($cartItem->rowId, $newQuantity);
        } else {
            // Si el producto no está en el carrito, añadirlo
            Cart::add([
                'id' => $validatedData['id'],
                'name' => $validatedData['name'],
                'qty' => 1, // Cantidad inicial del producto es 1
                'price' => $validatedData['price'],
                'options' => ['size' => 'large']
            ]);
        }
    
        return redirect()->back()->with('success', '¡Producto añadido con éxito!');
    }
    



    /**
     * Actualiza la cantidad de un producto en el carrito de compras.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $rowId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCart(Request $request, $rowId)
    {
        $validatedData = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);
    
        // Obtener el producto del carrito y la información actual del producto
        $item = Cart::get($rowId);
        $product = Product::find($item->id);
    
        // Verificar si la cantidad solicitada excede el inventario disponible
        if ($validatedData['qty'] > $product->product_garage) {
            // Ajustar la cantidad al máximo disponible
            Cart::update($rowId, $product->product_garage);
            return redirect()->back()->with('warning', 'La cantidad solicitada ha sido ajustada al máximo disponible.');
        }
    
        // Actualizar la cantidad del carrito con la cantidad solicitada
        Cart::update($rowId, $validatedData['qty']);
    
        return redirect()->back()->with('success', 'Cantidad actualizada en el carrito.');
    }
    

    

    /**
     * Elimina un producto del carrito de compras.
     *
     * @param string $rowId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCart(String $rowId)
    {
        // Elimina el producto del carrito
        Cart::remove($rowId);

        // Redirige de vuelta con un mensaje de éxito
        return Redirect::back()->with('success', '¡Producto eliminado del carrito!');
    }

    /**
     * Crea una factura con los productos del carrito para un cliente específico.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function createInvoice(Request $request)
    {
        $rules = [
            'customer_id' => 'required' // ID del cliente es requerido
        ];

        // Valida los datos de la solicitud
        $validatedData = $request->validate($rules);
        $customer = Customer::where('id', $validatedData['customer_id'])->first(); // Obtiene el cliente
        $content = Cart::content(); // Obtiene el contenido del carrito

        // Retorna la vista para crear la factura
        return view('pos.create-invoice', [
            'customer' => $customer,
            'content' => $content
        ]);
    }

    /**
     * Imprime una factura con los productos del carrito para un cliente específico.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function printInvoice(Request $request)
    {
        $rules = [
            'customer_id' => 'required' // ID del cliente es requerido
        ];

        // Valida los datos de la solicitud
        $validatedData = $request->validate($rules);
        $customer = Customer::where('id', $validatedData['customer_id'])->first(); // Obtiene el cliente
        $content = Cart::content(); // Obtiene el contenido del carrito

        // Retorna la vista para imprimir la factura
        return view('pos.print-invoice', [
            'customer' => $customer,
            'content' => $content
        ]);
    }
}
