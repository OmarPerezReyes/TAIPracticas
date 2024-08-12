{{-- resources/views/stock/manage.blade.php --}}
@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="mb-3">Registrar Movimiento</h4>
            <form action="{{ route('stock.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="product">Producto:<span class="text-danger">*</span></label>
                    <select class="form-control" id="product" name="product_id" required>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Fecha:<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ now()->format('Y-m-d') }}" readonly>
                </div>
                <div class="form-group">
                    <label for="quantity">Cantidad:<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                </div>
                <div class="form-group">
                    <label for="movement">Tipo de Movimiento:<span class="text-danger">*</span></label>
                    <select class="form-control" id="movement" name="movement" required>
                        <option value="Entrada">Entrada</option>
                        <option value="Salida">Salida</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="reason">Motivo:<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="reason" name="reason" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Movimiento</button>
            </form>
        </div>
    </div>
</div>
@endsection
