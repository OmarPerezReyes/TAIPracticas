
<div class="container mt-4">
    <h2>Alta de Universidad</h2>

    <form method="post" action="<?php echo BASE_URL ?>views/home.php?controller=universidad_controller&action=create">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s.]+" title="Ingresa un nombre válido (solo letras y espacios)">
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Dirección" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo:</label>
            <select name="tipo" class="form-control" id="tipo" required>
                <option value="">Selecciona un tipo</option>
                <option value="Publico">Público</option>
                <option value="Privado">Privado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-outline-success">Guardar</button>
    </form>
</div>
