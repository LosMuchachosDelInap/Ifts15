<?php
/**
 * Clase de Conexión a Base de Datos - IFTS15
 * Basada en el patrón de La Canchita de Los Pibes
 * 
 * @package IFTS15\ConectionBD
 * @author IFTS15 Team
 * @version 1.0
 */

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
        // Detectar entorno automáticamente
        $this->detectEnvironment();

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
     * Detecta automáticamente el entorno (desarrollo/producción)
     */
    private function detectEnvironment()
    {
        // Detectar si estamos en localhost o producción
        $isLocalhost = (
            $_SERVER['HTTP_HOST'] === 'localhost' || 
            $_SERVER['HTTP_HOST'] === '127.0.0.1' ||
            strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0
        );

        if ($isLocalhost) {
            // Configuración de desarrollo (localhost)
            $this->host     = 'localhost';
            $this->username = 'root';
            $this->password = '';
            $this->dbname   = 'ifts15';
            $this->charset  = 'utf8mb4';
        } else {
            // Configuración de producción (InfinityFree)
            $this->host     = 'sql103.infinityfree.com';
            $this->username = 'if0_37852182';
            $this->password = 'lXRO8EWQ9t1';
            $this->dbname   = 'if0_37852182_ifts15_sistema';
            $this->charset  = 'utf8mb4';
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