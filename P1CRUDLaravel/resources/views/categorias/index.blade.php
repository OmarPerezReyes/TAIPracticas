<!-- Inicio del layout de la aplicación -->
<x-app-layout>

    <div class="row justify-content-center mt-3">
        <div class="col-md-12">

            @if(session('success')) <!-- Mensaje de éxito -->
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="card">
                <div class="card-header">Category List</div>
                <div class="card-body">
                    <!-- Botón para agregar una nueva categoría -->
                    <a href="{{ route('categorias.create') }}" class="btn btn-success btn-sm my-2">
                        <i class="bi bi-plus-circle"></i> Add New Category
                    </a>
                    <!-- Tabla de categorías -->
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S#</th>
                                <th>Nombre</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Listar categorías -->
                            @forelse ($categorias as $categoria)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $categoria->nombre }}</td>
                                <td>
                                    <!-- Formulario para eliminar categoría -->
                                    <form action="{{ route('categorias.destroy', $categoria->id_categoria) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <!-- Botones para mostrar, editar y eliminar categoría -->
                                        <a href="{{ route('categorias.show', $categoria->id_categoria) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </a>
                                        <a href="{{ route('categorias.edit', $categoria->id_categoria) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this category?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <!-- Mensaje si no hay categorías -->
                            <tr>
                                <td colspan="3" class="text-center text-danger">
                                    <strong>No Category Found!</strong>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    {{ $categorias->links() }}

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
