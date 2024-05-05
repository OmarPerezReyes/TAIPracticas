<?php
    
    class admin_model{
        private $DB;
        private $admins;

        function __construct(){
            $this->DB=Database::connect();
        }

        public function create($data){
            try {

                #$this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql="INSERT INTO adminn (id, nombre, apellido, contrasena, telefono) VALUES (?, ?, ?, ?, ?)";
        
                $query = $this->DB->prepare($sql);
                $query->execute(array($data['id'], $data['nombre'], $data['apellido'], $data['contrasena'], $data['telefono']));

                #echo "Registro exitoso."; // Mostrar mensaje de éxito
                header("Location:index.php");
            } catch (PDOException $e) {
                echo "Error al registrar: " . $e->getMessage(); // Mostrar mensaje de error
            } finally {
                Database::disconnect(); // Desconectar de la base de datos
            }
        }
        


        function validate($correo, $contrasena) {
            $sql = "SELECT * FROM adminn WHERE id = ?";
            $q = $this->DB->prepare($sql);
            $q->bind_param("s", $correo);
            $q->execute();
            $result = $q->get_result();
            $data = $result->fetch_assoc();
            #echo $contrasena;
            #echo $data['contrasena'];
            if ($data && $contrasena == $data['contrasena']) {
                return $data; // Las credenciales son correctas
            } else {
                return false; // Las credenciales son incorrectas
            }
        }
    }
?>
