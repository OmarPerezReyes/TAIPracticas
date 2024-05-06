<?php 
    require_once('../models/carrera_model.php');
    require_once('../models/universidad_model.php');

    class carrera_controller{

        private $model_carrera;
        private $model_universidad;


        function __construct(){
            $this->model_carrera=new carrera_model();
        }

        function index(){
            $query =$this->model_carrera->get();
            include_once('../views/carreras/index.php');
        }

        function create(){
            if (isset($_POST['nombre'], $_POST['universidad'])) {
                // Obtener los datos del formulario
                $data['nombre'] = $_POST['nombre'];
                $data['universidad'] = $_POST['universidad']; 
                // Llamar al método para crear un nuevo registro
                $this->model_carrera->create($data);
                // Redirigir al usuario a la página index para mostrar los registros actualizados
                header("Location: " . BASE_URL . "views/home.php?controller=carrera_controller&action=index");
                exit();
            }
            else{
                $this->model_universidad=new universidad_model();
                $universidades =$this->model_universidad->get();
                include_once('../views/carreras/create.php');
            }
        }

        function update(){
            if (isset($_POST['nombre'], $_POST['universidad'])) {
                // Obtener los datos del formulario
                $data['id'] = $_POST['id'];
                $data['nombre'] = $_POST['nombre'];
                $data['universidad'] = $_POST['universidad']; 
                // Llamar al método para actualizar el registro
                $this->model_carrera->update($data);
                var_dump($data);
                
                // Redirigir al usuario a la página index para mostrar los registros actualizados
                header("Location: " . BASE_URL . "views/home.php?controller=carrera_controller&action=index");
                exit();
            }
            else{
                $this->model_universidad=new universidad_model();
                $universidades =$this->model_universidad->get();
                $query =$this->model_carrera->get_id($_GET['id']);
                include_once('../views/carreras/edit.php');
            }
        }

        function delete() {
            $this->model_carrera->delete($_GET['id']);
            // Redirigir al usuario a la página index para mostrar los registros actualizados
            header("Location: " . BASE_URL . "views/home.php?controller=carrera_controller&action=index");
            exit();
        }
        
    }
?>
