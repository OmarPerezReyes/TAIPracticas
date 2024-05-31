<!-- Inicio del layout de la aplicación -->
<x-app-layout>

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Inventory Information
                    </div>
                    <!-- Botón de regreso a la lista de inventario -->
                    <div class="float-end">
                        <a href="{{ route('inventario.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <!-- Muestra el ID del producto -->
                    <div class="row mb-3">
                        <label for="id_producto" class="col-md-4 col-form-label text-md-end text-start"><strong>Product ID:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $inventario->producto->nombre }}
                        </div>
                    </div>

                    <!-- Muestra el ID de la categoría -->
                    <div class="row mb-3">
                        <label for="id_categoria" class="col-md-4 col-form-label text-md-end text-start"><strong>Category ID:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $inventario->categoria->nombre }}
                        </div>
                    </div>

                    <!-- Muestra la fecha y hora del movimiento -->
                    <div class="row mb-3">
                        <label for="fecha_movimiento" class="col-md-4 col-form-label text-md-end text-start"><strong>Movement Date & Time:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $inventario->fecha_movimiento }}
                        </div>
                    </div>

                    <!-- Muestra el motivo -->
                    <div class="row mb-3">
                        <label for="motivo" class="col-md-4 col-form-label text-md-end text-start"><strong>Reason:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $inventario->motivo }}
                        </div>
                    </div>

                    <!-- Muestra el tipo de movimiento -->
                    <div class="row mb-3">
                        <label for="movimiento" class="col-md-4 col-form-label text-md-end text-start"><strong>Movement Type:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $inventario->movimiento }}
                        </div>
                    </div>

                    <!-- Muestra la cantidad -->
                    <div class="row mb-3">
                        <label for="cantidad" class="col-md-4 col-form-label text-md-end text-start"><strong>Quantity:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $inventario->cantidad }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
