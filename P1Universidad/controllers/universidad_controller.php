<?php 
    require_once('../models/universidad_model.php');

    class universidad_controller{

        private $model_universidad;

        function __construct(){
            $this->model_universidad=new universidad_model();
        }

        function index(){
            $query =$this->model_universidad->get();
            include_once('../views/universidades/index.php');
        }

        function create(){
            if (isset($_POST['tipo'])) {
                // Obtener los datos del formulario
                $data['nombre'] = $_POST['nombre'];
                $data['direccion'] = $_POST['direccion'];
                $data['tipo'] = $_POST['tipo'];
                // Llamar al método para crear un nuevo registro
                $this->model_universidad->create($data);
                
                // Redirigir al usuario a la página index para mostrar los registros actualizados
                header("Location: " . BASE_URL . "views/home.php?controller=universidad_controller&action=index");
                exit();
            }
            else{
                $data = false;
                include_once('../views/universidades/create.php');
            }
        }

        function update(){
            if (isset($_POST['tipo'])) {
                // Obtener los datos del formulario
                $data['id'] = $_POST['id'];
                $data['nombre'] = $_POST['nombre'];
                $data['direccion'] = $_POST['direccion'];
                $data['tipo'] = $_POST['tipo'];
                // Llamar al método para crear un nuevo registro
                $this->model_universidad->update($data);
                
                // Redirigir al usuario a la página index para mostrar los registros actualizados
                header("Location: " . BASE_URL . "views/home.php?controller=universidad_controller&action=index");
                exit();
            }
            else{
                $query =$this->model_universidad->get_id($_GET['id']);
                include_once('../views/universidades/edit.php');
            }
        }

        function delete() {
            $this->model_universidad->delete($_GET['id']);
            // Redirigir al usuario a la página index para mostrar los registros actualizados
            header("Location: " . BASE_URL . "views/home.php?controller=universidad_controller&action=index");
            exit();
        }
        
    }
?>
