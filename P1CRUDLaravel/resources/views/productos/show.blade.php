<!-- Inicio del layout de la aplicación -->
<x-app-layout>

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Product Information
                    </div>
                    <!-- Botón de regreso a la lista de productos -->
                    <div class="float-end">
                        <a href="{{ route('productos.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <!-- Muestra el nombre del producto -->
                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $producto->nombre }}
                        </div>
                    </div>

                    <!-- Muestra la categoría del producto -->
                    <div class="row">
                        <label for="category" class="col-md-4 col-form-label text-md-end text-start"><strong>Category:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $producto->id_categoria }}
                        </div>
                    </div>

                    <!-- Muestra el precio de venta del producto -->
                    <div class="row">
                        <label for="price_sale" class="col-md-4 col-form-label text-md-end text-start"><strong>Price Sale:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $producto->pv }}
                        </div>
                    </div>

                    <!-- Muestra el precio de compra del producto -->
                    <div class="row">
                        <label for="price_purchase" class="col-md-4 col-form-label text-md-end text-start"><strong>Price Purchase:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $producto->pc }}
                        </div>
                    </div>

                    <!-- Muestra la fecha de compra del producto -->
                    <div class="row">
                        <label for="date" class="col-md-4 col-form-label text-md-end text-start"><strong>Date of Purchase:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $producto->fecha_compra }}
                        </div>
                    </div>

                    <!-- Muestra los colores del producto -->
                    <div class="row">
                        <label for="colors" class="col-md-4 col-form-label text-md-end text-start"><strong>Colors:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $producto->colores }}
                        </div>
                    </div>

                    <!-- Muestra la descripción corta del producto -->
                    <div class="row">
                        <label for="short_description" class="col-md-4 col-form-label text-md-end text-start"><strong>Short Description:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $producto->descripcion_corta }}
                        </div>
                    </div>

                    <!-- Muestra la descripción larga del producto -->
                    <div class="row">
                        <label for="long_description" class="col-md-4 col-form-label text-md-end text-start"><strong>Long Description:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $producto->descripcion_larga }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
