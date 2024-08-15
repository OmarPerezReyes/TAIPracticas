@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert text-white bg-danger" role="alert">
                    <div class="iq-alert-text">{{ session('error') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Compras</h4>
                </div>
                <div>
                    <a href="{{ route('compra.exportData') }}" class="btn btn-warning add-list">Exportar</a>
                    <a href="{{ route('compra.manage') }}" class="btn btn-primary add-list">Agregar Compra</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('compra.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Filas por Página:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10') selected @endif>10</option>
                                <option value="25" @if(request('row') == '25') selected @endif>25</option>
                                <option value="50" @if(request('row') == '50') selected @endif>50</option>
                                <option value="100" @if(request('row') == '100') selected @endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Buscar:</label>
                        <div class="input-group col-sm-8">
                            <input type="text" id="search" class="form-control" name="search" placeholder="Buscar compra" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-primary">
                                    <i class="fa-solid fa-magnifying-glass font-size-20"></i>
                                </button>
                                <a href="{{ route('compra.index') }}" class="input-group-text bg-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th> <!-- Nueva columna para el nombre del producto -->
                            <th>Proveedor</th>
                            <th>Cantidad</th>
                            <th>Costo Individual</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Método de Pago</th>
                            <th>
                                <a href="{{ route('compra.index', ['sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'desc' ? 'asc' : 'desc']) }}">
                                    Fecha
                                    @if(request('sort_by') === 'created_at')
                                        <i class="fa-solid fa-arrow-{{ request('sort_order') === 'desc' ? 'down' : 'up' }}"></i>
                                    @endif
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->id }}</td>
                            <td>{{ $purchase->product->product_name }}</td> <!-- Mostrar el nombre del producto -->
                            <td>{{ $purchase->supplier->name }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td>{{ $purchase->cost_individual }}</td>
                            <td>{{ $purchase->discount ?? 'N/A' }}%</td>
                            <td>{{ $purchase->total }}</td>
                            <td>{{ $purchase->paymentMethod->name }}</td>
                            <td>{{ $purchase->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay datos.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $purchases->links() }}
        </div>
    </div>
</div>
@endsection
