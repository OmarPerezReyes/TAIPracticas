<div class="container mt-4">
    <h2>Editar Carrera</h2>

    <form method="post" action="<?php echo BASE_URL ?>views/home.php?controller=carrera_controller&action=update">
        <input type="hidden" name="id" value="<?php echo $query['id']; ?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s.]+" title="Ingresa un nombre válido (solo letras y espacios)" value="<?php echo $query['nombre']; ?>">
        </div>
        
        <div class="form-group">
            <label for="universidad">Universidad donde se imparte:</label><br>
            <select name="universidad" class="form-control" id="universidad" required>
                <?php foreach ($universidades as $uni): ?>
                    <option value="<?php echo $uni['id']; ?>" <?php if ($uni['id'] === $query['id_universidad']) echo 'selected'; ?>><?php echo $uni['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-outline-success">Guardar cambios</button>
    </form>
</div>
