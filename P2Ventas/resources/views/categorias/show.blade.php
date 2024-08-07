<!-- Inicio del layout de la aplicación -->
<x-app-layout>

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Category Information
                    </div>
                    <!-- Botón de regreso a la lista de categorías -->
                    <div class="float-end">
                        <a href="{{ route('categorias.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <!-- Muestra el nombre de la categoría -->
                    <div class="row">
                        <label for="nombre" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $categoria->nombre }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
