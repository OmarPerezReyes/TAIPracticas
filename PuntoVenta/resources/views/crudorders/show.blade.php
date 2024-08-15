@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">

        <!-- Información del Cliente y Vendedor -->
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-center">Resumen de Pedido</h4>
                    <div class="row text-center">
                        <div class="col-md-6">
                            <h6>Cliente</h6>
                            <p class="mb-1">{{ $order->customer->name ?? 'No definido' }}</p>
                            <p>{{ $order->customer->email ?? 'No definido' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Vendedor</h6>
                            <p class="mb-1">{{ $order->employee->name ?? 'No definido' }}</p>
                            <p>{{ $order->employee->email ?? 'No definido' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles del Pedido -->
        <div class="col-lg-12 mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h6>Fecha del Pedido</h6>
                            <p>{{ $order->created_at ? $order->created_at->format('d-m-Y H:i') : 'No definido' }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Monto Pagado</h6>
                            <p>{{ $order->paid }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Cambio</h6>
                            <p>{{ $order->change }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Método de Pago</h6>
                            <p>{{ $order->paymentMethod->name ?? 'No definido' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos Comprados -->
        <div class="col-lg-12 mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-borderless">
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
                                <td class="text-center">{{ $item->price }}</td>
                                <td class="text-right">{{ $item->quantity * $item->price }}</td>
                                <td class="text-center">
                                    <img class="avatar-40 rounded" src="{{ $item->product->product_image ? asset('storage/products/'.$item->product->product_image) : asset('assets/images/product/default.webp') }}">
                                </td>
                                @php
                                    $totalWithVAT += $item->quantity * $item->price;
                                @endphp
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Totales -->
                    <div class="row mt-4 text-right">
                        <div class="col-md-6">
                            <h6>Total sin IVA: {{ number_format($totalWithVAT, 2) }}</h6>
                            <h6>IVA (16%): {{ number_format($totalWithVAT * .16, 2) }}</h6>
                            <h5>Total con IVA: {{ $order->total }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        @if ($order->status == 'pending')
            <div class="col-lg-12 mt-4">
                <div class="text-center">
                    <form action="{{ route('order.updateStatus') }}" method="POST">
                        @method('put')
                        @csrf
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <button type="submit" class="btn btn-success">Completar Pedido</button>
                        <a class="btn btn-danger" href="{{ route('order.pendingOrders') }}">Cancelar</a>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
