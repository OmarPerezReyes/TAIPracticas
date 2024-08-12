<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;

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

        return redirect()->route('stocks.index')->with('success', 'Movimiento de stock agregado exitosamente.');
    }
}
