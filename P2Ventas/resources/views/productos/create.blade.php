<!-- Inicio del layout de la aplicación -->
<x-app-layout>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Add New Product
                    </div>
                    <div class="float-end">
                        <a href="{{ route('productos.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.store') }}" method="post">
                        @csrf

                        <!-- Campo de entrada para el nombre del producto -->
                        <div class="mb-3 row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end text-start">Nombre</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}">
                                @error('nombre')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'nombre' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para la categoría del producto -->
<div class="mb-3 row">
    <label for="id_categoria" class="col-md-4 col-form-label text-md-end text-start">Categoría</label>
    <div class="col-md-6">
        <select class="form-control @error('id_categoria') is-invalid @enderror" id="id_categoria" name="id_categoria">
            <option value="">Seleccione una categoría</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
        @error('id_categoria')
        <!-- Muestra un mensaje de error si hay un problema con el campo 'id_categoria' -->
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>



                        <!-- Campo de entrada para el precio de venta del producto -->
                        <div class="mb-3 row">
                            <label for="pv" class="col-md-4 col-form-label text-md-end text-start">Precio de Venta</label>
                            <div class="col-md-6">
                                <input type="number" step="0.01" class="form-control @error('pv') is-invalid @enderror" id="pv" name="pv" value="{{ old('pv') }}">
                                @error('pv')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'pv' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para el precio de compra del producto -->
                        <div class="mb-3 row">
                            <label for="pc" class="col-md-4 col-form-label text-md-end text-start">Precio de Compra</label>
                            <div class="col-md-6">
                                <input type="number" step="0.01" class="form-control @error('pc') is-invalid @enderror" id="pc" name="pc" value="{{ old('pc') }}">
                                @error('pc')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'pc' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para la fecha de compra del producto -->
                        <div class="mb-3 row">
                            <label for="fecha_compra" class="col-md-4 col-form-label text-md-end text-start">Fecha de Compra</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control @error('fecha_compra') is-invalid @enderror" id="fecha_compra" name="fecha_compra" value="{{ old('fecha_compra') }}">
                                @error('fecha_compra')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'fecha_compra' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para los colores del producto -->
                        <div class="mb-3 row">
                            <label for="colores" class="col-md-4 col-form-label text-md-end text-start">Colores</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('colores') is-invalid @enderror" id="colores" name="colores" value="{{ old('colores') }}">
                                @error('colores')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'colores' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para la descripción corta del producto -->
                        <div class="mb-3 row">
                            <label for="descripcion_corta" class="col-md-4 col-form-label text-md-end text-start">Descripción Corta</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('descripcion_corta') is-invalid @enderror" id="descripcion_corta" name="descripcion_corta" value="{{ old('descripcion_corta') }}">
                                @error('descripcion_corta')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'descripcion_corta' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para la descripción larga del producto -->
                        <div class="mb-3 row">
                            <label for="descripcion_larga" class="col-md-4 col-form-label text-md-end text-start">Descripción Larga</label>
                            <div class="col-md-6">
                                <textarea class="form-control @error('descripcion_larga') is-invalid @enderror" id="descripcion_larga" name="descripcion_larga">{{ old('descripcion_larga') }}</textarea>
                                @error('descripcion_larga')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'descripcion_larga' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Botón de envío del formulario -->
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Product">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
