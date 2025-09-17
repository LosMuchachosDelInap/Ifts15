<?php
/**
 * Clase de Conexión a la Base de Datos usando MySQLi
 * Alternativa a PDO para cuando PDO no está disponible
 */

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            $this->connection->set_charset(DB_CHARSET);
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                die("Error de conexión: " . $e->getMessage() . "<br>Host: " . DB_HOST . "<br>Database: " . DB_NAME);
            } else {
                die("Error de conexión a la base de datos. Por favor, contacte al administrador.");
            }
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        if (empty($params)) {
            return $this->connection->query($sql);
        }
        
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $this->connection->error);
        }
        
        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // Todos como string por simplicidad
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function fetchAll($sql, $params = []) {
        $result = $this->query($sql, $params);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function fetchOne($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetch_assoc();
    }
    
    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }
    
    public function beginTransaction() {
        return $this->connection->begin_transaction();
    }
    
    public function commit() {
        return $this->connection->commit();
    }
    
    public function rollback() {
        return $this->connection->rollback();
    }
    
    public function lastInsertId() {
        return $this->connection->insert_id;
    }
}
?>