<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página protegida</title>
</head>
<body>
    <div>
        <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
        <form action="index.php?m=cerrar_sesion" method="post">
            <button type="submit" name="cerrar_sesion">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
