<?php
class Database
{
    private static $servername = 'localhost';
    private static $username = 'admin';
    private static $password = 'be17af928cb8ea2ca2418261803f684deb3e60a9b3537483';
    private static $dbname = 'p1_universidad';

    private static $conn = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        if (null == self::$conn)
        {
            self::$conn = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);

            // Check connection
            if (self::$conn->connect_error) {
                die("Conexión fallida: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }

    public static function disconnect()
    {
        self::$conn->close();
        self::$conn = null;
    }
}
?>
