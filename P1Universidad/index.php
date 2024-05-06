<?php
    require_once('bd/Connection.php');
    require_once('controllers/admin_controller.php');

    $controller= new admin_controller();
    
    if(!empty($_REQUEST['m'])){
        $metodo=$_REQUEST['m'];
        if (method_exists($controller, $metodo)) {
            $controller->$metodo();
        }else{
            $controller->index();
        }
    }else{
        $controller->index();
    }
?>