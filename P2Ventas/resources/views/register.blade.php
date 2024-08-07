<html>

<head>
    <title>Registro de usuario</title>
    {{-- <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css "> --}}

</head>

<body>
    <div class="container mt-5">
        <h2>Registro de usuario</h2>
        <form action="crud.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" name="Correo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary" name="alta">Agregar usuario</button>
        </form>
    </div>
</body>

</html>