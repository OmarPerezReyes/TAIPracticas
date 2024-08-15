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
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Lista de Pedidos Completos</h4>
                </div>
                <div>
                <a href="{{ route('crudorders.exportData') }}" class="btn btn-warning add-list">Exportar</a>

                    <a href="{{ route('crudorders.index') }}" class="btn btn-danger add-list">
                        <i class="fa-solid fa-trash mr-3"></i>Limpiar Búsqueda
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('crudorders.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Filas:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Buscar:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="search" class="form-control" name="search" placeholder="Buscar pedido" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                </div>
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
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>Nombre del Vendedor</th>
                            <th>@sortablelink('customer.name', 'Nombre del Cliente')</th>
                            <th>@sortablelink('created_at', 'Fecha del Pedido')</th>
                            <th>@sortablelink('paid', 'Pagado')</th>
                            <th>@sortablelink('change', 'Cambio')</th>
                            <th>@sortablelink('paymentMethod.name', 'Método de Pago')</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ (($orders->currentPage() - 1) * $orders->perPage()) + $loop->iteration }}</td>
                            <td>{{ $order->employee ? $order->employee->name : 'No definido' }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $order->paid }}</td>
                            <td>{{ $order->change }}</td>
                            <td>
                                @if ($order->paymentMethod)
                                    {{ $order->paymentMethod->name }}
                                @else
                                    No definido
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <a class="btn btn-info mr-2" data-toggle="tooltip" data-placement="top" title="Detalles" href="{{ route('crudorders.show', $order->id) }}">
                                        Detalles
                                    </a>
                                    <form action="{{ route('order.generatePDF') }}" method="post" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <button type="submit" class="btn btn-success d-flex align-items-center px-4 py-2" data-toggle="tooltip" data-placement="top" title="Generar PDF">
                                            <i class="fa-solid fa-file-pdf mr-2"></i>
                                            PDF
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $orders->links() }}
        </div>
    </div>
    <!-- Fin de la página -->
</div>
@endsection
