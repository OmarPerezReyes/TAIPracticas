<?php
// Incluir el modelo de usuario
require_once "models/admin_model.php";

class admin_controller {
    private $model_admin;

    // Constructor: inicializa el modelo de usuario
    public function __construct() {
        $this->model_admin = new admin_model();
    }

    // Método para mostrar la página de inicio (login)
    function index(){
        include_once('views/login/header.php'); // Incluir el encabezado de la página
        include_once('views/login/index.php'); // Incluir la vista del formulario de inicio de sesión
        include_once('views/login/footer.php'); // Incluir el pie de página
    }

    // Método para iniciar sesión
    public function iniciar_sesion() {
        $data = false;

        // Verificar si se enviaron datos de inicio de sesión
        if (isset($_POST['correo'], $_POST['contrasena'])) {
            // Validar las credenciales de inicio de sesión
            $data = $this->model_admin->validate($_POST['correo'], $_POST['contrasena']);    
        }

        // Si las credenciales son válidas
        if ($data) {
            // Iniciar la sesión
            session_start();
            $_SESSION['nombre'] = $data['nombre']; // Establecer la sesión del usuario

            // Redirigir al usuario a la página principal (home)
            include_once('views/home.php');
        } else {
            // Si las credenciales son incorrectas, mostrar un mensaje de error
            echo "Credenciales incorrectas. Sesión rechazada.";
        }
    }

    // Método para registrar un nuevo usuario
    public function registro(){
        if (isset($_POST['telefono'])) {
            // Obtener los datos del formulario
            $data['id'] = $_POST['correo'];
            $data['nombre'] = $_POST['nombre'];
            $data['apellido'] = $_POST['apellido'];
            $data['contrasena'] = $_POST['contrasena'];
            $data['telefono'] = $_POST['telefono'];
    
            // Llamar al método para crear un nuevo registro de usuario
            $this->model_admin->create($data);
        }
        else{
            $data = false;
            include_once('views/login/registro.php'); // Incluir la vista del formulario de registro
            include_once('views/login/footer.php'); // Incluir el pie de página
        }
    }

    // Método para cerrar sesión
    public function cerrar_sesion() {
        // Iniciar la sesión
        session_start();

        // Destruir todas las variables de sesión
        session_unset();

        // Destruir la sesión
        session_destroy();

        // Redirigir al usuario a la página de inicio
        header("Location: index.php");
        exit;
    }
}
?>
