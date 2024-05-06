
<?php
    session_start();
    define('BASE_URL', 'http://perezomar.me/TAIPracticas/P1Universidad/');
    define('BASE_PATH', '/var/www/html/TAIPracticas/P1Universidad/');
    // Verificar si no hay una sesión iniciada
    if (!isset($_SESSION['nombre'])) {
        // Redireccionar al usuario a la página de inicio de sesión
        header("Location: http://perezomar.me/TAIPracticas/P1Universidad/index.php"); 
        exit;
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto U3</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style_header_home.css">
    <link rel="stylesheet" href="assets/css/style_header_home.css">

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="<?php echo BASE_URL ?>views/home.php">Práctica 1</a>
    </nav>

<div class="container mt-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL ?>views/home.php?controller=universidad_controller&action=index">Listado de universidades</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL ?>views/home.php?controller=carrera_controller&action=index">Listado de carreras</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL ?>index.php?m=cerrar_sesion">Cerrar sesión</a>
        </li>
    </ul>
    <?php
        // Verificar si los parámetros 'controller' y 'action' están presentes en la solicitud
        if (isset($_GET['controller']) && isset($_GET['action'])) {
            // Obtener el nombre del controlador y la acción desde los parámetros de la solicitud
            $controller = $_GET['controller'];
            $action = $_GET['action'];

            // Incluir el archivo de conexión a la base de datos
            require_once(BASE_PATH . 'bd/Connection.php');

            // Incluir el archivo del controlador correspondiente
            require_once(BASE_PATH . "controllers/$controller.php");

            // Instanciar el objeto del controlador
            $controller = new $controller();

            // Llamar a la acción especificada en el controlador
            $controller->$action();
        }
    ?>

</div>

<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
