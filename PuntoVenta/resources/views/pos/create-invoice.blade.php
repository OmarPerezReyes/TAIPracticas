<?php
use Carbon\Carbon;

// Configurar el idioma en la vista
Carbon::setLocale('es');
?>
@extends('dashboard.body.main')

@section('container')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white text-center">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid my-3" style="width: 150px;">
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
                            <span class="badge badge-danger">No Pagado</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-left">Artículo</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Precio</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($content as $item)
                                <tr>
                                    <td class="text-left">{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td class="text-center">${{ $item->price }}</td>
                                    <td class="text-right">${{ $item->subtotal }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-top mt-4 pt-4">
                        <div class="d-flex justify-content-between">
                            <p class="text-muted">Subtotal:</p>
                            <p class="text-right">${{ Cart::subtotal() }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-muted">IVA (16%):</p>
                            <p class="text-right">${{ Cart::tax() }}</p>
                        </div>
                        <div class="d-flex justify-content-between font-weight-bold">
                            <h5>Total:</h5>
                            <h5 class="text-primary">${{ Cart::total() }}</h5>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white text-center">
                <form action="{{ route('invoice.generatePDF') }}" method="post" class="d-inline-block">
    @csrf
    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
    <button type="submit" class="btn btn-primary d-flex align-items-center px-4 py-2">
        <i class="las la-print mr-2"></i>
        <span>Generar PDF</span>
    </button>
</form>
<!-- Botón para abrir el modal de pago -->
<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#paymentModal">Pagar</button>

 <!-- Modal de Pago -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Finalizar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('orders.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <!-- Mensaje de advertencia -->
                    <div id="paymentWarning" class="alert alert-warning d-none" role="alert">
                        El monto pagado no cubre el total de la orden.
                    </div>

                    <!-- Información del monto total -->
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Monto Total a Pagar:</h6>
                        <p id="totalAmount" class="h4 text-primary">${{ Cart::total() }}</p>
                    </div>

                    <div class="form-group">
                        <label for="employee_id">Vendedor</label>
                        <select class="form-control" id="employee_id" name="employee_id" required>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_method_id">Método de Pago</label>
                        <select class="form-control" id="payment_method_id" name="payment_method_id" required>
                            @foreach($paymentMethods as $paymentMethod)
                                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount_paid">Cantidad Pagada</label>
                        <input type="number" class="form-control" id="amount_paid" name="amount_paid" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="change">Cambio</label>
                        <input type="number" class="form-control" id="change" name="change" step="0.01" min="0" readonly>
                    </div>
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <input type="hidden" name="total" value="{{ Cart::total() }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="finalizePaymentBtn">Finalizar Pago</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const totalAmount = parseFloat({{ Cart::total() }});
    let hasInteracted = false; // Flag para verificar la interacción del usuario

    function validatePayment() {
        const amountPaidInput = document.getElementById('amount_paid');
        const changeInput = document.getElementById('change');
        const warning = document.getElementById('paymentWarning');
        const submitButton = document.querySelector('#paymentModal .btn-primary'); // Botón de finalizar pago

        const amountPaid = parseFloat(amountPaidInput.value);
        let change = 0;

        if (isNaN(amountPaid) || amountPaid < totalAmount) {
            changeInput.value = '';
            if (hasInteracted) {
                warning.classList.remove('d-none'); // Muestra el mensaje de advertencia solo después de la interacción
            }
            submitButton.disabled = true; // Deshabilitar el botón si el pago no cubre el total
        } else {
            // Calcula el cambio y actualiza el campo de cambio
            change = (amountPaid - totalAmount).toFixed(2);
            changeInput.value = change;
            warning.classList.add('d-none'); // Oculta el mensaje de advertencia
            submitButton.disabled = false; // Habilitar el botón si el pago cubre el total
        }
    }

    function initializeModal() {
        const amountPaidInput = document.getElementById('amount_paid');
        amountPaidInput.addEventListener('input', function () {
            hasInteracted = true; // Marca que el usuario ha interactuado
            validatePayment();
        });

        const form = document.querySelector('#paymentModal form');
        form.addEventListener('submit', function (event) {
            validatePayment(); // Asegúrate de validar antes de enviar
            const warning = document.getElementById('paymentWarning');
            if (!warning.classList.contains('d-none')) {
                event.preventDefault(); // Previene el envío del formulario si el pago no cubre el total
            }
        });
    }

    $('#paymentModal').on('shown.bs.modal', function () {
        initializeModal();
        // No llamar a validatePayment aquí para que el mensaje de advertencia no se muestre al cargar el modal
    });
});
</script>



</div>
            </div>
        </div>
    </div>
</div>


@endsection
