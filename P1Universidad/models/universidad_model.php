<?php
    
    class universidad_model{
        private $DB;
        private $universidades;

        function __construct(){
            try {
                $this->DB = Database::connect();
                #echo "La conexión a la base de datos se ha establecido correctamente.";
            } catch (PDOException $e) {
                echo "Error al establecer la conexión a la base de datos: " . $e->getMessage();
            }
                    }

        function get(){
            $sql= 'SELECT * FROM universidad ';
            $fila=$this->DB->query($sql);
            $this->universidades=$fila;
            #var_dump($this->universidades);
            return  $this->universidades;
        }

        function create($data){

            #$this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql="INSERT INTO universidad(nombre,direccion,tipo) VALUES (?,?,?)";

            $query = $this->DB->prepare($sql);
            $query->execute(array($data['nombre'],$data['direccion'],$data['tipo']));
            Database::disconnect();       

        }

        function get_id($id){
            #$this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM universidad WHERE id = ?";
            $stmt = $this->DB->prepare($sql);
            $stmt->bind_param("i", $id); // "i" indica que el parámetro es un entero
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            return $data;
            
        }

        function update($data){
            #$this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE universidad set nombre=?, direccion =?, tipo=? WHERE id = ? ";
            $q = $this->DB->prepare($sql);
            $q->execute(array($data['nombre'],$data['direccion'],$data['tipo'],$data['id']));
            Database::disconnect();

        }

        function delete($date){
            #$this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql="DELETE FROM universidad where id=?";
            $q=$this->DB->prepare($sql);
            $q->execute(array($date));
            Database::disconnect();
        }
    }
?>
