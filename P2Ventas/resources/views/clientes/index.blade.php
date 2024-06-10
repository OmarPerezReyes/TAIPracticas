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
                <div class="card-header">Client List</div>
                <div class="card-body">
                    <!-- Botón para agregar un nuevo cliente -->
                    <a href="{{ route('clientes.create') }}" class="btn btn-success btn-sm my-2">
                        <i class="bi bi-plus-circle"></i> Add New Client
                    </a>
                    <!-- Tabla de clientes -->
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S#</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>RFC</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Listar clientes -->
                            @forelse ($clientes as $cliente)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->correo }}</td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>{{ $cliente->direccion }}</td>
                                <td>{{ $cliente->rfc }}</td>
                                <td>
                                    <!-- Formulario para eliminar cliente -->
                                    <form action="{{ route('clientes.destroy', $cliente->id_cliente) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <!-- Botones para mostrar, editar y eliminar cliente -->
                                        <a href="{{ route('clientes.show', $cliente->id_cliente) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente->id_cliente) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this client?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <!-- Mensaje si no hay clientes -->
                            <tr>
                                <td colspan="7" class="text-center text-danger">
                                    <strong>No Clients Found!</strong>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    {{ $clientes->links() }}

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
