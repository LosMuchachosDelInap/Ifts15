<?php

namespace App\Model;

use App\ConectionBD\ConectionDB;
use Exception;

/**
 * Modelo Career - IFTS15
 * 
 * @package App\Model
 */
class Career
{
    private $id_carrera;
    private $nombre;
    private $descripcion;
    private $duracion_anios;
    private $is_active;

    public function __construct($nombre, $descripcion = null, $duracion_anios = 3, $id_carrera = null)
    {
        $this->id_carrera = $id_carrera;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->duracion_anios = $duracion_anios;
        $this->is_active = true;
    }

    // ========================================
    // GETTERS
    // ========================================
    public function getId() { return $this->id_carrera; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getDuracionAnios() { return $this->duracion_anios; }
    public function getIsActive() { return $this->is_active; }

    // ========================================
    // SETTERS
    // ========================================
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setDuracionAnios($duracion_anios) { $this->duracion_anios = $duracion_anios; }
    public function setIsActive($is_active) { $this->is_active = $is_active; }

    // ========================================
    // MÉTODOS DE BASE DE DATOS
    // ========================================
    
    /**
     * Guardar carrera en la base de datos
     */
    public function guardar($conn)
    {
        $stmt = $conn->prepare("INSERT INTO carrera (nombre, descripcion, duracion_anios, is_active) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $this->nombre, $this->descripcion, $this->duracion_anios, $this->is_active);
        
        if ($stmt->execute()) {
            $this->id_carrera = $conn->insert_id;
            return true;
        }
        return false;
    }

    /**
     * Actualizar carrera existente
     */
    public function actualizar($conn)
    {
        $stmt = $conn->prepare("UPDATE carrera SET nombre = ?, descripcion = ?, duracion_anios = ?, is_active = ? WHERE id_carrera = ?");
        $stmt->bind_param("ssiii", $this->nombre, $this->descripcion, $this->duracion_anios, $this->is_active, $this->id_carrera);
        return $stmt->execute();
    }

    // ========================================
    // MÉTODOS ESTÁTICOS DE BÚSQUEDA
    // ========================================
    
    /**
     * Buscar carrera por ID
     */
    public static function buscarPorId($conn, $id)
    {
        $stmt = $conn->prepare("SELECT * FROM carrera WHERE id_carrera = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($fila = $resultado->fetch_assoc()) {
            $career = new Career($fila['nombre'], $fila['descripcion'], $fila['duracion_anios'], $fila['id_carrera']);
            $career->is_active = $fila['is_active'];
            return $career;
        }
        return null;
    }

    /**
     * Obtener todas las carreras activas
     */
    public static function obtenerTodas($conn, $solo_activas = true)
    {
        $sql = "SELECT * FROM carrera";
        if ($solo_activas) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY nombre";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $carreras = [];
        while ($fila = $resultado->fetch_assoc()) {
            $career = new Career($fila['nombre'], $fila['descripcion'], $fila['duracion_anios'], $fila['id_carrera']);
            $career->is_active = $fila['is_active'];
            $carreras[] = $career;
        }
        
        return $carreras;
    }

    // ========================================
    // VALIDACIONES
    // ========================================
    
    /**
     * Validar datos de la carrera
     */
    public function validar()
    {
        $errores = [];
        
        if (empty($this->nombre)) {
            $errores[] = "El nombre de la carrera es obligatorio";
        } elseif (strlen($this->nombre) < 3) {
            $errores[] = "El nombre debe tener al menos 3 caracteres";
        }
        
        if ($this->duracion_anios < 1 || $this->duracion_anios > 10) {
            $errores[] = "La duración debe ser entre 1 y 10 años";
        }
        
        return $errores;
    }
}
?>