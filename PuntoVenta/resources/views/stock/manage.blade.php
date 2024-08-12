{{-- resources/views/stock/manage.blade.php --}}
@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="mb-3">Agregar Movimiento de Stock</h4>
            <form action="{{ route('stock.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="product">Producto:</label>
                    <select class="form-control" id="product" name="product_id">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Fecha:</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Cantidad:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="movement">Tipo de Movimiento:</label>
                    <select class="form-control" id="movement" name="movement">
                        <option value="Entrada">Entrada</option>
                        <option value="Salida">Salida</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="reason">Motivo:</label>
                    <input type="text" class="form-control" id="reason" name="reason">
                </div>
                <button type="submit" class="btn btn-primary">Agregar Movimiento</button>
            </form>
        </div>
    </div>
</div>
@endsection
