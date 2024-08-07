<!-- Inicio del layout de la aplicación -->
<x-app-layout>

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <!-- Verifica si hay un mensaje de éxito en la sesión -->
            @if(session('success'))
            <!-- Muestra un mensaje de éxito -->
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Edit Category
                    </div>
                    <div class="float-end">
                        <a href="{{ route('categorias.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('categorias.update', $categoria->id_categoria) }}" method="post">
                        @csrf
                        @method("PUT")

                        <!-- Campo de entrada para el nombre de la categoría -->
                        <div class="mb-3 row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end text-start">Nombre</label>
                            <div class="col-md-6">
                                <!-- El valor inicial del campo es el nombre actual de la categoría -->
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $categoria->nombre }}">
                                @error('nombre')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'nombre' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Category">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
