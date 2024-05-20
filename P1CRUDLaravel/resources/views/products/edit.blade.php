<!-- Inicio del layout de la aplicación -->
<x-app-layout>

    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <!-- Verifica si hay un mensaje de éxito en la sesión -->
            @session('success')
            <!-- Muestra un mensaje de éxito -->
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
            @endsession

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Edit Product
                    </div>
                    <div class="float-end">
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="post">
                        @csrf
                        @method("PUT")

                        <!-- Campo de entrada para el código del producto -->
                        <div class="mb-3 row">
                            <label for="code" class="col-md-4 col-form-label text-md-end text-start">Code</label>
                            <div class="col-md-6">
                                <!-- El valor inicial del campo es el código actual del producto -->
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ $product->code }}">
                                @error('code')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'code' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para el nombre del producto -->
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <!-- El valor inicial del campo es el nombre actual del producto -->
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $product->name }}">
                                @error('name')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'name' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para la cantidad del producto -->
                        <div class="mb-3 row">
                            <label for="quantity" class="col-md-4 col-form-label text-md-end text-start">Quantity</label>
                            <div class="col-md-6">
                                <!-- El valor inicial del campo es la cantidad actual del producto -->
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ $product->quantity }}">
                                @error('quantity')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'quantity' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para el precio del producto -->
                        <div class="mb-3 row">
                            <label for="price" class="col-md-4 col-form-label text-md-end text-start">Price</label>
                            <div class="col-md-6">
                                <!-- El valor inicial del campo es el precio actual del producto -->
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ $product->price }}">
                                @error('price')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'price' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo de entrada para la descripción del producto -->
                        <div class="mb-3 row">
                            <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                                <!-- El valor inicial del campo es la descripción actual del producto -->
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ $product->description }}</textarea>
                                @error('description')
                                <!-- Muestra un mensaje de error si hay un problema con el campo 'description' -->
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>