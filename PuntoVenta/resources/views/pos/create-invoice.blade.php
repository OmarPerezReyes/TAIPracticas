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


                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Pagar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
