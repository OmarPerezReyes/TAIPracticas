<?php
session_start(); // Iniciar la sesión al principio del archivo

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio
header("Location: ../index.php");
exit;
?>
