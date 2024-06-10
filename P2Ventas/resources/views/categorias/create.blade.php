<!-- Inicio del layout de la aplicación -->
<x-app-layout>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Add New Category
                    </div>
                    <div class="float-end">
                        <a href="{{ route('categorias.index') }}" class="btn btn-primary btn-sm">&larr; atrás</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('categorias.store') }}" method="post">
                        @csrf

                        <!-- Campo de entrada para el nombre de la categoría -->
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

                        <!-- Botón de envío del formulario -->
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Category">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
