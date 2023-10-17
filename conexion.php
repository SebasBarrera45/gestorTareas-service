<?php
// Verificar si existe el encabezado 'HTTP_ORIGIN' en la solicitud
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Establecer los encabezados de Control de Acceso HTTP (CORS) para permitir solicitudes desde el origen recibido
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}

// Verificar si la solicitud es de tipo OPTIONS (utilizada para pre-vuelos CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Si se especifica 'HTTP_ACCESS_CONTROL_REQUEST_METHOD', establecer los métodos permitidos en los encabezados de respuesta
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST");
    // Si se especifica 'HTTP_ACCESS_CONTROL_REQUEST_HEADERS', establecer los encabezados de solicitud permitidos en los encabezados de respuesta
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    // Finalizar la ejecución del script sin procesar la solicitud
    exit(0);
}

// Definir una clase de conexión a la base de datos
class Conexion
{
    protected $db;

    // Método para establecer una conexión a la base de datos
    protected function connect()
    {
        try {
            $NAMEDB = 'tareas';
            $HOST = 'localhost';
            $USER = 'root';
            $PASSWORD = '';
            
            // Crear una instancia de PDO para conectarse a la base de datos
            $conectar = $this->db = new PDO("mysql:host=$HOST;dbname=$NAMEDB", "$USER", "$PASSWORD");
            return $conectar;
        } catch (Exception $e) {
            // Manejar errores de conexión a la base de datos
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    // Método para configurar el conjunto de caracteres de la conexión a UTF-8
    public function set_names()
    {
        return $this->db->query("SET NAMES 'utf8'");
    }
}
?>
