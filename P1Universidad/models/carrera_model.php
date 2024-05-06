<?php
    
class carrera_model{
    private $DB;
    private $carreras;

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

   // Método para obtener todas las carreras con el nombre de la universidad
function get(){
    $sql= 'SELECT carrera.*, universidad.nombre AS nombre_universidad 
            FROM carrera 
            INNER JOIN universidad ON carrera.id_universidad = universidad.id';
    // Ejecutar la consulta SQL
    $fila=$this->DB->query($sql);
    // Guardar el resultado en la propiedad $carreras
    $this->carreras=$fila;
    // Retornar el resultado
    return  $this->carreras;
}


    // Método para crear una nueva carrera
    function create($data){
        // Preparar la consulta SQL
        $sql="INSERT INTO carrera(nombre,id_universidad) VALUES (?,?)";
        // Ejecutar la consulta SQL
        $query = $this->DB->prepare($sql);
        $data['universidad'] = intval($data['universidad']);
        $query->execute(array($data['nombre'], $data['universidad']));
        // Cerrar la conexión a la base de datos
        Database::disconnect();       
    }

    // Método para obtener los datos de una carrera por su ID
    function get_id($id){
        $sql = "SELECT * FROM carrera WHERE id = ?";
        $stmt = $this->DB->prepare($sql);
        $stmt->bind_param("i", $id); // "i" indica que el parámetro es un entero
        $stmt->execute();
        $result = $stmt->get_result();
        // Obtener los datos de la carrera
        $data = $result->fetch_assoc();
        // Retornar los datos
        return $data;
    }

    // Método para actualizar los datos de una carrera
    function update($data){
        $sql = "UPDATE carrera set nombre=?, id_universidad =? WHERE id = ? ";
        $q = $this->DB->prepare($sql);
        $q->execute(array($data['nombre'],$data['universidad'],$data['id']));
        // Cerrar la conexión a la base de datos
        Database::disconnect();
    }

    // Método para eliminar una carrera por su ID
    function delete($id){
        $sql="DELETE FROM carrera where id=?";
        $q=$this->DB->prepare($sql);
        $q->execute(array($id));
        // Cerrar la conexión a la base de datos
        Database::disconnect();
    }
}

?>
