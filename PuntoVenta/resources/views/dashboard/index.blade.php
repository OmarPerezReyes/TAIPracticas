@extends('dashboard.body.main')

@section('container')
<div class="container-fluid" style="background: #F7FDFF">
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
        </div>
    </div>
    <!-- Page Content -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h4 class="mb-3">Descargar Reportes</h4>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('customers.exportData') }}" class="btn btn-warning">Exportar Clientes</a>
                <a href="{{ route('suppliers.exportData') }}" class="btn btn-warning">Exportar Proveedores</a>
                <a href="{{ route('employees.exportData') }}" class="btn btn-warning">Exportar Vendedores</a>
                <a href="{{ route('categories.exportData') }}" class="btn btn-warning">Exportar Categorías</a>
                <a href="{{ route('compra.exportData') }}" class="btn btn-warning">Exportar Compras</a>
                <a href="{{ route('crudorders.exportData') }}" class="btn btn-warning">Exportar Ventas</a>
                <a href="{{ route('products.exportData') }}" class="btn btn-warning">Exportar Productos</a>
                <a href="{{ route('stock.exportData') }}" class="btn btn-warning">Exportar Inventario</a>
                <a href="{{ route('payment_methods.exportData') }}" class="btn btn-warning">Exportar Métodos de Pago</a>
            </div>
        </div>
    </div>

    <!-- Resumen de Productos -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Resumen de Productos</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total de Productos:</strong> {{ $totalProducts }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end -->
</div>
@endsection

@section('specificpagescripts')
<!-- Table Treeview JavaScript -->
<script src="{{ asset('assets/js/table-treeview.js') }}"></script>
<!-- Chart Custom JavaScript -->
<script src="{{ asset('assets/js/customizer.js') }}"></script>
<!-- Chart Custom JavaScript -->
<script async src="{{ asset('assets/js/chart-custom.js') }}"></script>
@endsection
