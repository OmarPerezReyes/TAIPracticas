<?php

use Carbon\Carbon;

// Configurar el idioma en la vista
Carbon::setLocale('es');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Pedido</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .card-header h5 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            padding: 12px;
            border: 1px solid #e0e0e0;
            text-align: left;
        }
        .table th {
            background-color: #f1f1f1;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-muted {
            color: #757575;
        }
        .badge-danger {
            background-color: #e57373;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .font-weight-bold {
            font-weight: 600;
        }
        .border-top {
            border-top: 1px solid #e0e0e0;
        }
        .mt-4 {
            margin-top: 20px;
        }
        .pt-4 {
            padding-top: 20px;
        }
        @media (max-width: 768px) {
            .table th, .table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card-header">
            <h5 class="font-weight-bold">Resumen de Pedido</h5>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
            <div>
                
    <h6 class="text-muted">Fecha de la Orden:</h6>
    <p class="mb-0">{{ Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}</p>
    </div>

                <div>
                    <h6 class="text-muted">Estado de la Orden:</h6>
                    <span class="badge-danger">No Pagado</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Artículo</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Precio</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($content as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-center">${{ number_format((float)$item->price, 2) }}</td>
                        <td class="text-right">${{ number_format((float)$item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

                        
            <div class="border-top mt-4 pt-4">
                <div class="d-flex justify-content-between">
                    <p class="text-muted">Subtotal:</p>
                    <p class="text-right">${{ number_format((float)Cart::subtotal(), 2) }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted">IVA (16%):</p>
                    <p class="text-right">${{ number_format((float)Cart::tax(), 2) }}</p>
                </div>
                <div class="d-flex justify-content-between font-weight-bold">
                    <h5>Total:</h5>
                    <h5 class="text-primary">${{ number_format((float)Cart::total(), 2) }}</h5>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
