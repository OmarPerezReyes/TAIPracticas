@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Agregar Compra</h4>
                </div>
                <div>
                    <a href="{{ route('compra.index') }}" class="btn btn-secondary">Volver a la lista</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('compra.store') }}" method="POST" id="purchase-form">
                @csrf

                <div class="form-group row">
                    <label for="product_id" class="col-sm-3 col-form-label">Producto:</label>
                    <div class="col-sm-9">
                        <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                            <option value="">Seleccionar Producto</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @if(old('product_id') == $product->id) selected @endif>{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="supplier_id" class="col-sm-3 col-form-label">Proveedor:</label>
                    <div class="col-sm-9">
                        <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id">
                            <option value="">Seleccionar Proveedor</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @if(old('supplier_id') == $supplier->id) selected @endif>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="payment_method_id" class="col-sm-3 col-form-label">Método de Pago:</label>
                    <div class="col-sm-9">
                        <select class="form-control @error('payment_method_id') is-invalid @enderror" id="payment_method_id" name="payment_method_id">
                            <option value="">Seleccionar Método de Pago</option>
                            @foreach ($paymentMethods as $paymentMethod)
                                <option value="{{ $paymentMethod->id }}" @if(old('payment_method_id') == $paymentMethod->id) selected @endif>{{ $paymentMethod->name }}</option>
                            @endforeach
                        </select>
                        @error('payment_method_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="quantity" class="col-sm-3 col-form-label">Cantidad:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" step="1" min="0">
                        @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="cost_individual" class="col-sm-3 col-form-label">Costo Individual:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control @error('cost_individual') is-invalid @enderror" id="cost_individual" name="cost_individual" value="{{ old('cost_individual') }}" step="0.01" min="0">
                        @error('cost_individual')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="discount" class="col-sm-3 col-form-label">Descuento:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount') }}" step="0.01" min="0" placeholder="Opcional">
                        @error('discount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="total" class="col-sm-3 col-form-label">Total:</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{ old('total') }}" step="0.01" min="0" readonly>
                        @error('total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary">Realizar Compra</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function calculateTotal() {
        const quantity = parseFloat(document.getElementById('quantity').value) || 0;
        const costIndividual = parseFloat(document.getElementById('cost_individual').value) || 0;
        const discount = parseFloat(document.getElementById('discount').value) || 0;

        const subtotal = quantity * costIndividual;
        const discountAmount = subtotal * (discount / 100);
        const total = subtotal - discountAmount;

        document.getElementById('total').value = total.toFixed(2);
    }

    const inputs = document.querySelectorAll('#quantity, #cost_individual, #discount');
    inputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    // Initial calculation in case there is already data in the fields
    calculateTotal();
});
</script>

@endsection
