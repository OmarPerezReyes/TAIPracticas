<?php

require_once "Connection.php"; // Incluimos el archivo de conexión
require_once "../models/UsuarioModel.php"; // Incluimos el modelo de usuario

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["registro"])) {
    $matricula = $_POST["matricula"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $telefono = $_POST["telefono"];
    
    // Instanciar el modelo de usuario
    $usuarioModel = new UsuarioModel($conn); // Usamos la conexión del archivo Connection.php
    
    // Intentar registrar al usuario
    if ($usuarioModel->registrarUsuario($matricula, $nombre, $apellido, $correo, $contrasena, $telefono)) {
        // Redirigir al usuario a la página de productos si el registro es exitoso
        header("Location: ../index.php");
        exit;
    } else {
        // Mostrar un mensaje de error si el registro falla
        $mensajeError = "Error: El correo ya está registrado.";
    }
}
?>