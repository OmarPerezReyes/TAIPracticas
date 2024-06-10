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
                        Edit Client
                    </div>
                    <div class="float-end">
                        <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('clientes.update', $cliente->id_cliente) }}" method="post">
                        @csrf
                        @method("PUT")

                        <!-- Campo de entrada para el nombre del cliente -->
                        <div class="mb-3 row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end text-start">Nombre</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $cliente->nombre }}">
                                @error('nombre')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'nombre' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para el correo -->
                        <div class="mb-3 row">
                            <label for="correo" class="col-md-4 col-form-label text-md-end text-start">Correo</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{ $cliente->correo }}">
                                @error('correo')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'correo' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para el teléfono -->
                        <div class="mb-3 row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-end text-start">Teléfono</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ $cliente->telefono }}">
                                @error('telefono')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'telefono' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para la dirección -->
                        <div class="mb-3 row">
                            <label for="direccion" class="col-md-4 col-form-label text-md-end text-start">Dirección</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ $cliente->direccion }}">
                                @error('direccion')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'direccion' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para el RFC -->
                        <div class="mb-3 row">
                            <label for="rfc" class="col-md-4 col-form-label text-md-end text-start">RFC</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('rfc') is-invalid @enderror" id="rfc" name="rfc" value="{{ $cliente->rfc }}">
                                @error('rfc')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'rfc' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Client">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
