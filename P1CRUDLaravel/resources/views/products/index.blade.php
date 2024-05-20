<!-- Inicio del layout de la aplicación -->
<x-app-layout>

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">

            @session('success') <!-- Mensaje de éxito -->
            <div class="alert alert-success">
                {{ $value }}
            </div>
            @endsession

            <div class="card">
                <div class="card-header">Product List</div>
                <div class="card-body">
                    <!-- Botón para agregar un nuevo producto -->
                    <a href="{{ route('products.create') }}" class="btn btn-success btn-sm my-2">
                        <i class="bi bi-plus-circle"></i> Add New Product
                    </a>
                    <!-- Tabla de productos -->
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Listar productos -->
                            @forelse ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    <!-- Formulario para eliminar producto -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <!-- Botones para mostrar, editar y eliminar producto -->
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this product?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <!-- Mensaje si no hay productos -->
                            <tr>
                                <td colspan="6" class="text-center text-danger">
                                    <strong>No Product Found!</strong>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    {{ $products->links() }}

                </div>
            </div>
        </div>
    </div>

</x-app-layout>