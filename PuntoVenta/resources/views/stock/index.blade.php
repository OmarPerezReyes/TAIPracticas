{{-- resources/views/stock/index.blade.php --}}
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
                    <h4 class="mb-3">Movimientos </h4>
                </div>
                <div>
                    <a href="{{ route('stock.exportData') }}" class="btn btn-warning add-list">Exportar</a>
                    <a href="{{ route('stock.manage') }}" class="btn btn-primary add-list">Agregar Movimiento</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('stocks.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Row:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10') selected="selected" @endif>10</option>
                                <option value="25" @if(request('row') == '25') selected="selected" @endif>25</option>
                                <option value="50" @if(request('row') == '50') selected="selected" @endif>50</option>
                                <option value="100" @if(request('row') == '100') selected="selected" @endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Buscar:</label>
                        <div class="input-group col-sm-8">
                            <input type="text" id="search" class="form-control" name="search" placeholder="Buscar movimiento" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-primary">
                                    <i class="fa-solid fa-magnifying-glass font-size-20"></i>
                                </button>
                                <a href="{{ route('stocks.index') }}" class="input-group-text bg-danger">
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
                        <th>
                            <a href="{{ route('stocks.index', ['sort_by' => 'id', 'sort_order' => request('sort_order') === 'desc' ? 'asc' : 'desc']) }}">
                                ID
                                @if(request('sort_by') === 'id')
                                    <i class="fa-solid fa-arrow-{{ request('sort_order') === 'desc' ? 'down' : 'up' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Producto</th>
                        <th>
                            <a href="{{ route('stocks.index', ['sort_by' => 'date', 'sort_order' => request('sort_order') === 'desc' ? 'asc' : 'desc']) }}">
                                Fecha
                                @if(request('sort_by') === 'date')
                                    <i class="fa-solid fa-arrow-{{ request('sort_order') === 'desc' ? 'down' : 'up' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('stocks.index', ['sort_by' => 'movement', 'sort_order' => request('sort_order') === 'desc' ? 'asc' : 'desc']) }}">
                                Movimiento
                                @if(request('sort_by') === 'movement')
                                    <i class="fa-solid fa-arrow-{{ request('sort_order') === 'desc' ? 'down' : 'up' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Motivo</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>

                    <tbody>
                        @forelse ($stocks as $stock)
                        <tr>
                            <td>{{ $stock->id }}</td>
                            <td>{{ $stock->product->product_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($stock->date)->format('Y-m-d') }}</td>
                            <td>{{ ucfirst($stock->movement) }}</td>
                            <td>{{ $stock->reason }}</td>
                            <td>{{ $stock->quantity }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay datos.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $stocks->links() }}
        </div>
    </div>
</div>
@endsection