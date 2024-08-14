@extends('dashboard.body.main')

@section('container')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white text-center">
                    <h5 class="font-weight-bold">Formulario de Pago</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('pos.processPayment') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="customer_id">Cliente</label>
                            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                            <p class="form-control-plaintext">{{ $customer->name }}</p>
                        </div>

                        <div class="form-group">
                            <label for="user_id">Vendedor</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">Seleccione un vendedor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment_method_id">Método de Pago</label>
                            <select name="payment_method_id" id="payment_method_id" class="form-control">
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="amount_paid">Monto Pagado</label>
                            <input type="number" step="0.01" name="amount_paid" id="amount_paid" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="change">Cambio</label>
                            <input type="number" step="0.01" name="change" id="change" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Finalizar Pedido</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Monto total de la orden (puedes pasar este valor desde el backend)
    const totalAmount = {{ Cart::total() }};

    // Referencia al formulario
    const form = document.querySelector('form');

    // Referencia a los campos de monto pagado y cambio
    const amountPaidInput = document.getElementById('amount_paid');
    const changeInput = document.getElementById('change');

    // Función para validar el monto pagado
    function validatePayment() {
        const amountPaid = parseFloat(amountPaidInput.value);
        const change = parseFloat(changeInput.value);

        if (isNaN(amountPaid) || amountPaid < totalAmount) {
            alert('El monto pagado debe ser suficiente para cubrir el total de la orden.');
            return false;
        }

        // Calcula el cambio y actualiza el campo de cambio
        if (amountPaid >= totalAmount) {
            changeInput.value = (amountPaid - totalAmount).toFixed(2);
        }

        return true;
    }

    // Agrega un evento de validación al enviar el formulario
    form.addEventListener('submit', function (event) {
        if (!validatePayment()) {
            event.preventDefault(); // Previene el envío del formulario si la validación falla
        }
    });

    // Calcula el cambio automáticamente cuando se cambia el monto pagado
    amountPaidInput.addEventListener('input', function () {
        validatePayment();
    });
});
</script>

@endsection
