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
                <div class="card-header">Inventory List</div>
                <div class="card-body">
                    <!-- Botón para agregar un nuevo inventario -->
                    <a href="{{ route('inventario.create') }}" class="btn btn-success btn-sm my-2">
                        <i class="bi bi-plus-circle"></i> Add New Inventory
                    </a>
                    <!-- Tabla de inventario -->
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S#</th>
                                <th>Producto</th>
                                <th>Categoria</th>
                                <th>Fecha de movimiento</th>
                                <th>Motivo</th>
                                <th>Movimiento</th>
                                <th>Cantidad</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Listar inventario -->
                            @forelse ($inventario as $inv)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $inv->producto->nombre }}</td>
                                <td>{{ $inv->categoria->nombre }}</td>
                                <td>{{ $inv->fecha_movimiento }}</td>
                                <td>{{ $inv->motivo }}</td>
                                <td>{{ $inv->movimiento }}</td>
                                <td>{{ $inv->cantidad }}</td>
                                <td>
                                    <!-- Formulario para eliminar inventario -->
                                    <form action="{{ route('inventario.destroy', $inv->id_inventario) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <!-- Botones para mostrar, editar y eliminar inventario -->
                                        <a href="{{ route('inventario.show', $inv->id_inventario) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </a>
                                        <a href="{{ route('inventario.edit', $inv->id_inventario) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this inventory?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <!-- Mensaje si no hay inventario -->
                            <tr>
                                <td colspan="8" class="text-center text-danger">
                                    <strong>No Inventory Found!</strong>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    {{ $inventario->links() }}

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
