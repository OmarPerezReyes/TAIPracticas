<?php
require_once "models/admin_model.php"; // Incluir el modelo de usuario

class admin_controller {

    private $model_admin;

    public function __construct() {
        $this->model_admin = new admin_model(); // Instanciar el modelo de usuario con la conexión PDO
    }

    function index(){
        include_once('views/header.php');
        include_once('views/index.php');
        include_once('views/footer.php');
    }

    public function iniciar_sesion() {
        $data = false;
        if (isset($_POST['correo'], $_POST['contrasena'])) {
            $data = $this->model_admin->validate($_POST['correo'], $_POST['contrasena']);    
        }
        if ($data) {
            session_start();
            $_SESSION['nombre'] = $data['nombre']; // Establecer la sesión del usuario
            include_once('views/mensaje.php');
        } else {
            echo "Credenciales incorrectas. Sesión rechazada.";
        }
    }

    public function registro(){
        if (isset($_POST['telefono'])) {
            // Obtener los datos del formulario
            $data['id'] = $_POST['correo'];
            $data['nombre'] = $_POST['nombre'];
            $data['apellido'] = $_POST['apellido'];
            $data['contrasena'] = $_POST['contrasena'];
            $data['telefono'] = $_POST['telefono'];
    
            // Llamar al método para crear un nuevo registro
            $this->model_admin->create($data);
            
        }
        else{
            $data = false;
            include_once('views/registro.php');
            include_once('views/footer.php');
        }
    }

    public function cerrar_sesion() {
        session_start();
        session_unset(); // Eliminar todas las variables de sesión
        session_destroy(); // Destruir la sesión
        header("Location: index.php"); // Redirigir al usuario a la página de inicio
        exit;
    }
}


?>
