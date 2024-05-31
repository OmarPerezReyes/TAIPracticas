<!-- Inicio del layout de la aplicación -->
<x-app-layout>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Editar movimiento de inventario
                    </div>
                    <div class="float-end">
                        <a href="{{ route('inventario.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventario.update', $inventario->id_inventario) }}" method="post">
                        @csrf
                        @method('PUT')

                        <!-- Campo de selección para la categoría -->
                        <div class="mb-3 row">
                            <label for="id_categoria" class="col-md-4 col-form-label text-md-end text-start">Categoria</label>
                            <div class="col-md-6">
                                <select class="form-select" id="id_categoria" name="id_categoria">
                                    <option selected disabled>Seleccionar categoria</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}" {{ $inventario->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Campo de selección para el producto -->
                        <div class="mb-3 row">
                            <label for="id_producto" class="col-md-4 col-form-label text-md-end text-start">Producto</label>
                            <div class="col-md-6">
                                <select class="form-select" id="id_producto" name="id_producto">
                                    <option selected disabled>Seleccionar producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id_producto }}" data-categoria="{{ $producto->id_categoria }}" {{ $inventario->id_producto == $producto->id_producto ? 'selected' : '' }}>
                                            {{ $producto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                          <!-- Campo para la fecha y hora de movimiento -->
                          <div class="mb-3 row">
                            <label for="fecha_movimiento" class="col-md-4 col-form-label text-md-end text-start">Fecha y hora del movimiento</label>
                            <div class="col-md-6">
                                <input type="datetime-local" class="form-control" id="fecha_movimiento" name="fecha_movimiento" value="{{ old('fecha_movimiento', \Carbon\Carbon::parse($inventario->fecha_movimiento)->format('Y-m-d\TH:i')) }}">
                            </div>
                        </div>

                        <!-- Campo para el motivo -->
                        <div class="mb-3 row">
                            <label for="motivo" class="col-md-4 col-form-label text-md-end text-start">Motivo</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="motivo" name="motivo" value="{{ old('motivo', $inventario->motivo) }}">
                            </div>
                        </div>

                        <!-- Campo de selección para el tipo de movimiento -->
                        <div class="mb-3 row">
                            <label for="movimiento" class="col-md-4 col-form-label text-md-end text-start">Movimiento</label>
                            <div class="col-md-6">
                                <select class="form-select" id="movimiento" name="movimiento">
                                    <option selected disabled>Seleccionar tipo de movimiento</option>
                                    <option value="Entrada" {{ $inventario->movimiento == 'Entrada' ? 'selected' : '' }}>Entrada</option>
                                    <option value="Salida" {{ $inventario->movimiento == 'Salida' ? 'selected' : '' }}>Salida</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campo para la cantidad -->
                        <div class="mb-3 row">
                            <label for="cantidad" class="col-md-4 col-form-label text-md-end text-start">Cantidad</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ old('cantidad', $inventario->cantidad) }}">
                            </div>
                        </div>

                        <!-- Botón de envío del formulario -->
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Inventory">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        document.getElementById('id_categoria').addEventListener('change', function() {
            var categoriaId = this.value; // Obtener el ID de la categoría seleccionada

            // Obtener todas las opciones de productos
            var opcionesProductos = document.querySelectorAll('#id_producto option');

            // Ocultar todas las opciones de productos
            opcionesProductos.forEach(function(opcionProducto) {
                opcionProducto.style.display = 'none';
            });

            // Mostrar solo las opciones de productos que pertenecen a la categoría seleccionada
            var opcionesProductosFiltradas = document.querySelectorAll('#id_producto option[data-categoria="' + categoriaId + '"]');
            opcionesProductosFiltradas.forEach(function(opcionProducto) {
                opcionProducto.style.display = '';
            });

            // Reiniciar el campo de selección de productos
            document.getElementById('id_producto').selectedIndex = 0;
        });

        // Ejecutar el filtro al cargar la página
        document.getElementById('id_categoria').dispatchEvent(new Event('change'));
    </script>

</x-app-layout>
