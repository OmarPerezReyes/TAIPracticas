<div class="container mt-4">
    <h2 class="mb-4">Listado de Carreras</h2>

    <a href="<?php echo BASE_URL ?>views/home.php?controller=carrera_controller&action=create" class="btn btn-primary mb-3">Registrar carrera</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Universidad donde se imparte</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query as $data): ?>
                <tr>
                    <td><?php echo $data['id']; ?></td>
                    <td><?php echo $data['nombre']; ?></td>
                    <td><?php echo $data['nombre_universidad']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL ?>views/home.php?controller=carrera_controller&action=update&id=<?php echo $data['id']; ?>" class="btn btn-outline-secondary btn-sm">Editar</a>
                        <a href="<?php echo BASE_URL ?>views/home.php?controller=carrera_controller&action=delete&id=<?php echo $data['id']; ?>" onclick="return confirmDelete();" class="btn btn-outline-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// Función para mostrar un mensaje de confirmación antes de eliminar una carrera
function confirmDelete() {
    return confirm("¿Estás seguro de que deseas eliminar esta carrera?");
}
</script>
