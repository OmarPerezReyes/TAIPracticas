<!-- Inicio del layout de la aplicación -->
<x-app-layout>

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Client Information
                    </div>
                    <!-- Botón de regreso a la lista de clientes -->
                    <div class="float-end">
                        <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <!-- Muestra el nombre del cliente -->
                    <div class="row">
                        <label for="nombre" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $cliente->nombre }}
                        </div>
                    </div>

                    <!-- Muestra el correo del cliente -->
                    <div class="row">
                        <label for="correo" class="col-md-4 col-form-label text-md-end text-start"><strong>Correo:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $cliente->correo }}
                        </div>
                    </div>

                    <!-- Muestra el teléfono del cliente -->
                    <div class="row">
                        <label for="telefono" class="col-md-4 col-form-label text-md-end text-start"><strong>Teléfono:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $cliente->telefono }}
                        </div>
                    </div>

                    <!-- Muestra la dirección del cliente -->
                    <div class="row">
                        <label for="direccion" class="col-md-4 col-form-label text-md-end text-start"><strong>Dirección:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $cliente->direccion }}
                        </div>
                    </div>

                    <!-- Muestra el RFC del cliente -->
                    <div class="row">
                        <label for="rfc" class="col-md-4 col-form-label text-md-end text-start"><strong>RFC:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $cliente->rfc }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
