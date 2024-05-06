<?php
    
class admin_model{
    private $DB; // Variable para almacenar la conexión a la base de datos
    private $admins; // Variable para almacenar los datos de los administradores

    // Constructor: inicializa la conexión a la base de datos
    function __construct(){
        $this->DB=Database::connect(); // Establecer la conexión a la base de datos
    }

    // Método para crear un nuevo administrador
    public function create($data){
        try {
            // Preparar la consulta SQL para insertar un nuevo registro de administrador
            $sql="INSERT INTO adminn (id, nombre, apellido, contrasena, telefono) VALUES (?, ?, ?, ?, ?)";
    
            // Ejecutar la consulta SQL
            $query = $this->DB->prepare($sql);
            $query->execute(array($data['id'], $data['nombre'], $data['apellido'], $data['contrasena'], $data['telefono']));

            // Redirigir al usuario a la página de inicio después de registrar exitosamente
            header("Location:index.php");
        } catch (PDOException $e) {
            echo "Error al registrar: " . $e->getMessage(); // Mostrar mensaje de error si falla el registro
        } finally {
            Database::disconnect(); // Desconectar de la base de datos
        }
    }

    // Método para validar las credenciales de inicio de sesión
    function validate($correo, $contrasena) {
        // Consulta SQL para obtener los datos del administrador por su correo (id)
        $sql = "SELECT * FROM adminn WHERE id = ?";
        // Preparar la consulta SQL
        $q = $this->DB->prepare($sql);
        $q->bind_param("s", $correo); // Enlazar el parámetro
        $q->execute(); // Ejecutar la consulta SQL
        $result = $q->get_result(); // Obtener el resultado de la consulta
        $data = $result->fetch_assoc(); // Obtener los datos del administrador
        if ($data && $contrasena == $data['contrasena']) {
            return $data; // Si las credenciales son correctas, devolver los datos del administrador
        } else {
            return false; // Si las credenciales son incorrectas, devolver falso
        }
    }
}

?>
