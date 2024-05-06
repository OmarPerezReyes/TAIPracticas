<?php
// Incluir el archivo de conexión a la base de datos
require_once('bd/Connection.php');
// Incluir el controlador de administrador
require_once('controllers/admin_controller.php');

// Instanciar el controlador de administrador
$controller= new admin_controller();

// Verificar si se proporcionó un método en la solicitud
if(!empty($_REQUEST['m'])){
    $metodo=$_REQUEST['m'];
    // Verificar si el método existe en el controlador
    if (method_exists($controller, $metodo)) {
        // Llamar al método especificado
        $controller->$metodo();
    } else {
        // Si el método no existe, llamar al método index por defecto
        $controller->index();
    }
} else {
    // Si no se proporcionó un método, llamar al método index por defecto
    $controller->index();
}
?>
