<?php
session_start(); // Iniciar la sesión al principio del archivo

// Verificar si la sesión está activa
if (!isset($_SESSION['cliente'])) {
    // Si la sesión no está activa, redirigir al usuario a la página de inicio de sesión
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <h1><?php echo "entraste"; ?></h1>
    <!-- Agrega aquí cualquier otro contenido que desees mostrar -->

    <!-- Botón para cerrar sesión -->
    <form action="../controllers/cerrar_sesion.php" method="post">
        <input type="submit" value="Cerrar Sesión">
    </form>
</body>
</html>
