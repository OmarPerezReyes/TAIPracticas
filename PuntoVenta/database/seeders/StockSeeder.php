<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\Product;

class StockSeeder extends Seeder
{
    public function run()
    {
        // Obtén todos los productos existentes
        $products = Product::all();

        foreach ($products as $product) {
            // Agrega movimientos de entrada de stock
            Stock::create([
                'product_id' => $product->id,
                'date' => now(),
                'movement' => 'entry',
                'reason' => 'Initial stock entry',
                'quantity' => 10,
            ]);

            // Puedes agregar más entradas o salidas si es necesario
            // Stock::create([
            //     'product_id' => $product->id,
            //     'date' => now(),
            //     'movement' => 'exit',
            //     'reason' => 'Sale',
            //     'quantity' => 5,
            // ]);
        }
    }
}

