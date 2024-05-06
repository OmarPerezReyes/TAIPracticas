<div class="container mt-4">
    <h2>Editar Universidad</h2>
    <form method="post" action="<?php echo BASE_URL ?>views/home.php?controller=universidad_controller&action=update">
        <input type="hidden" name="id" value="<?php echo $query['id']; ?>"> <!-- Campo oculto para pasar el ID -->

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" value="<?php echo $query['nombre']; ?>" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s.]+" title="Ingresa un nombre válido (solo letras y espacios)">
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Dirección" value="<?php echo $query['direccion']; ?>" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo:</label>
            <select name="tipo" class="form-control" id="tipo" required>
                <option value="Publico" <?php if ($query['tipo'] == 'Publico') echo 'selected'; ?>>Público</option>
                <option value="Privado" <?php if ($query['tipo'] == 'Privado') echo 'selected'; ?>>Privado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-outline-success">Guardar cambios</button>
    </form>
</div>
