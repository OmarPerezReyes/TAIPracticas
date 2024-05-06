<div class="container mt-4">
    <h2>Alta de Carrera</h2>

    <form method="post" action="<?php echo BASE_URL ?>views/home.php?controller=carrera_controller&action=create">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s.]+" title="Ingresa un nombre válido (solo letras y espacios)">
        </div>
        
        <div class="form-group">
            <label for="universidad">Universidad donde se imparte:</label><br>
            <select name="universidad" class="form-control" id="universidad" required>
                <option value="">Selecciona una universidad</option>
                <?php foreach ($universidades as $universidad): ?>
                    <option value="<?php echo $universidad['id']; ?>"><?php echo $universidad['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-outline-success">Guardar</button>
    </form>
</div>
