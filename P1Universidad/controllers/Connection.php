<?php  
    // Conexion a la base de datos 
    $servername = "localhost";
    $username = "admin";
    $password = "be17af928cb8ea2ca2418261803f684deb3e60a9b3537483";
    $dbname = "practica_registro";

    // Crear conexión 
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
?>
