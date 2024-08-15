<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px; /* Tamaño de fuente más pequeño para un diseño compacto */
        }
        .container {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 10px;
        }
        .card-header {
            background-color: #f1f1f1;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            font-size: 14px;
            font-weight: bold;
        }
        .card-body {
            padding: 10px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        table th {
            background-color: #f1f1f1;
        }
        .img-thumbnail {
            max-width: 60px;
            max-height: 60px;
            object-fit: cover;
        }
        .total {
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Información del Cliente y Vendedor -->
        <div class="card">
            <div class="card-header text-center">Resumen de Pedido</div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between;">
                    <div style="width: 48%; font-size: 12px;">
                        <h6>Cliente</h6>
                        <p>{{ $order->customer->name ?? 'No definido' }}</p>
                        <p>{{ $order->customer->email ?? 'No definido' }}</p>
                    </div>
                    <div style="width: 48%; font-size: 12px;">
                        <h6>Vendedor</h6>
                        <p>{{ $order->employee->name ?? 'No definido' }}</p>
                        <p>{{ $order->employee->email ?? 'No definido' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles del Pedido -->
        <div class="card">
            <div class="card-header">Detalles del Pedido</div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; font-size: 12px;">
                    <div style="width: 24%;">
                        <h6>Fecha del Pedido</h6>
                        <p>{{ $order->created_at ? $order->created_at->format('d-m-Y H:i') : 'No definido' }}</p>
                    </div>
                    <div style="width: 24%;">
                        <h6>Monto Pagado</h6>
                        <p>{{ $order->paid }}</p>
                    </div>
                    <div style="width: 24%;">
                        <h6>Cambio</h6>
                        <p>{{ $order->change }}</p>
                    </div>
                    <div style="width: 24%;">
                        <h6>Método de Pago</h6>
                        <p>{{ $order->paymentMethod->name ?? 'No definido' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos Comprados -->
        <div class="card">
            <div class="card-header">Productos Comprados</div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th class="text-left">Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Precio</th>
                            <th class="text-right">Total</th>
                            <th class="text-center">Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalWithVAT = 0;
                        @endphp
                        @foreach ($orderDetails as $item)
                        <tr>
                            <td class="text-left">{{ $item->product->product_name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">{{ number_format($item->price, 2) }}</td>
                            <td class="text-right">{{ number_format($item->quantity * $item->price, 2) }}</td>
                            <td class="text-center">
                                <img class="img-thumbnail" src="{{ $item->product->product_image ? asset('storage/products/'.$item->product->product_image) : asset('assets/images/product/default.webp') }}" alt="{{ $item->product->product_name }}">
                            </td>
                            @php
                                $totalWithVAT += $item->quantity * $item->price;
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Totales -->
                <div class="footer">
                    <div class="total">Total sin IVA: {{ number_format($totalWithVAT, 2) }}</div>
                    <div class="total">IVA (16%): {{ number_format($totalWithVAT * 0.16, 2) }}</div>
                    <div class="total">Total con IVA: {{ number_format($order->total, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
