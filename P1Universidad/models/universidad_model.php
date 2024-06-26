<?php
    
class universidad_model{
    private $DB;
    private $universidades;

    function __construct(){
        try {
            // Establecer la conexión a la base de datos
            $this->DB = Database::connect();
            // Si se establece la conexión correctamente, se muestra un mensaje
            #echo "La conexión a la base de datos se ha establecido correctamente.";
        } catch (PDOException $e) {
            // Si hay un error al establecer la conexión, se muestra un mensaje de error
            echo "Error al establecer la conexión a la base de datos: " . $e->getMessage();
        }
    }

    // Método para obtener todas las universidades
    function get(){
        $sql= 'SELECT * FROM universidad ';
        // Ejecutar la consulta SQL
        $fila=$this->DB->query($sql);
        // Guardar el resultado en la propiedad $universidades
        $this->universidades=$fila;
        // Retornar el resultado
        return  $this->universidades;
    }

    // Método para crear una nueva universidad
    function create($data){
        // Preparar la consulta SQL
        $sql="INSERT INTO universidad(nombre,direccion,tipo) VALUES (?,?,?)";
        // Ejecutar la consulta SQL
        $query = $this->DB->prepare($sql);
        $query->execute(array($data['nombre'],$data['direccion'],$data['tipo']));
        // Cerrar la conexión a la base de datos
        Database::disconnect();       
    }

    // Método para obtener los datos de una universidad por su ID
    function get_id($id){
        $sql = "SELECT * FROM universidad WHERE id = ?";
        $stmt = $this->DB->prepare($sql);
        $stmt->bind_param("i", $id); // "i" indica que el parámetro es un entero
        $stmt->execute();
        $result = $stmt->get_result();
        // Obtener los datos de la universidad
        $data = $result->fetch_assoc();
        // Retornar los datos
        return $data;
    }

    // Método para actualizar los datos de una universidad
    function update($data){
        $sql = "UPDATE universidad set nombre=?, direccion =?, tipo=? WHERE id = ? ";
        $q = $this->DB->prepare($sql);
        $q->execute(array($data['nombre'],$data['direccion'],$data['tipo'],$data['id']));
        // Cerrar la conexión a la base de datos
        Database::disconnect();
    }

    // Método para eliminar una universidad por su ID
    function delete($id){
        $sql="DELETE FROM universidad where id=?";
        $q=$this->DB->prepare($sql);
        $q->execute(array($id));
        // Cerrar la conexión a la base de datos
        Database::disconnect();
    }
}

?>
