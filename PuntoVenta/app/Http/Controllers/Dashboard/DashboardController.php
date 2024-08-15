<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
     /**
     * Display the dashboard.
     */
    public function index()
    {
        $totalProducts = Product::count(); // Consulta la cantidad total de productos

        return view('dashboard.index', [
            'totalProducts' => $totalProducts, // Pasa la cantidad de productos a la vista
        ]);
    }
}
