<?php
/**
 * Clase de Conexión a Base de Datos - IFTS15
 * Basada en el patrón de La Canchita de Los Pibes con phpdotenv
 * 
 * @package IFTS15\ConectionBD
 * @author IFTS15 Team
 * @version 2.0
 */

// Cargar configuración central
require_once __DIR__ . '/../config.php';

class ConectionDB
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    private $charset;

    public function __construct()
    {
        // Cargar configuración desde variables de entorno usando la función helper
        $this->host     = env('DB_HOST', 'localhost');
        $this->username = env('DB_USERNAME', 'root');
        $this->password = env('DB_PASSWORD', '');
        $this->dbname   = env('DB_NAME', 'ifts15');
        $this->charset  = env('DB_CHARSET', 'utf8mb4');

        // Crear conexión MySQLi
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->dbname
        );

        // Configurar charset
        $this->conn->set_charset($this->charset);

        // Verificar conexión
        if ($this->conn->connect_error) {
            error_log("Error de conexión BD: " . $this->conn->connect_error);
            die("Error de conexión a la base de datos");
        }
    }

    /**
     * Obtiene la conexión MySQLi
     * 
     * @return mysqli Conexión a la base de datos
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * Cierra la conexión a la base de datos
     */
    public function closeConnection()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    /**
     * Destructor - cierra automáticamente la conexión
     */
    public function __destruct()
    {
        $this->closeConnection();
    }
}