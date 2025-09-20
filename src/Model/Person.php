<?php

namespace App\Model;

use App\ConectionBD\ConectionDB;
use Exception;
use DateTime;

/**
 * Modelo Person - IFTS15
 * Basado en el patrón de La Canchita de Los Pibes
 * 
 * @package App\Model
 */
class Person
{
    private $id_persona;
    private $nombre;
    private $apellido;
    private $fecha_nacimiento;
    private $dni;
    private $telefono;
    private $edad;

    public function __construct($nombre, $apellido, $fecha_nacimiento, $dni, $telefono = null, $direccion = null, $email_contacto = null, $id_persona = null, $edad = null)
    {
        error_log("CONSTRUCTOR Person - nombre: {$nombre}, apellido: {$apellido}, dni: {$dni}, edad: " . ($edad ?? 'NULL'));
        
        $this->id_persona = $id_persona;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->dni = $dni;
        $this->telefono = $telefono;
        $this->edad = $edad;
        // direccion y email_contacto se ignoran, solo están para compatibilidad
        
        error_log("CONSTRUCTOR Person - completado exitosamente");
    }

    // ========================================
    // GETTERS
    // ========================================
    public function getId() { return $this->id_persona; }
    public function getNombre() { return $this->nombre; }
    public function getApellido() { return $this->apellido; }
    public function getFechaNacimiento() { return $this->fecha_nacimiento; }
    public function getDni() { return $this->dni; }
    public function getTelefono() { return $this->telefono; }
    public function getEdadBD() { return $this->edad; } // Edad guardada en BD
    
    public function getNombreCompleto() { 
        return $this->nombre . ' ' . $this->apellido; 
    }
    
    public function getEdad() {
        if (!$this->fecha_nacimiento) return null;
        $fecha_nac = new DateTime($this->fecha_nacimiento);
        $hoy = new DateTime();
        return $hoy->diff($fecha_nac)->y;
    }

    // ========================================
    // SETTERS
    // ========================================
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setApellido($apellido) { $this->apellido = $apellido; }
    public function setFechaNacimiento($fecha_nacimiento) { $this->fecha_nacimiento = $fecha_nacimiento; }
    public function setDni($dni) { $this->dni = $dni; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    public function setEdad($edad) { $this->edad = $edad; }

    // ========================================
    // MÉTODOS DE BASE DE DATOS
    // ========================================
    
    /**
     * Guardar persona en la base de datos
     */
    public function guardar($conn)
    {
        $stmt = $conn->prepare("INSERT INTO persona (nombre, apellido, fecha_nacimiento, dni, telefono, edad) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Manejar fecha_nacimiento NULL explícitamente
        $fecha_param = $this->fecha_nacimiento;
        if (empty($fecha_param)) {
            $fecha_param = null;
        }
        
        $stmt->bind_param("sssssi", 
            $this->nombre, 
            $this->apellido, 
            $fecha_param, 
            $this->dni, 
            $this->telefono,
            $this->edad
        );
        
        if ($stmt->execute()) {
            $this->id_persona = $conn->insert_id;
            return true;
        } else {
            // Log del error específico
            error_log("Error al guardar persona: " . $stmt->error . " | SQL: " . $stmt->sqlstate);
            return false;
        }
    }

    /**
     * Actualizar persona existente
     */
    public function actualizar($conn)
    {
        // Manejar fecha_nacimiento NULL explícitamente
        $fecha_param = $this->fecha_nacimiento;
        if (empty($fecha_param)) {
            $fecha_param = null;
        }
        
        $stmt = $conn->prepare("UPDATE persona SET nombre = ?, apellido = ?, fecha_nacimiento = ?, dni = ?, telefono = ?, edad = ? WHERE id_persona = ?");
        $stmt->bind_param("sssssii", 
            $this->nombre, 
            $this->apellido, 
            $fecha_param, 
            $this->dni, 
            $this->telefono,
            $this->edad,
            $this->id_persona
        );
        return $stmt->execute();
    }

    /**
     * Eliminar persona
     */
    public function eliminar($conn)
    {
        $stmt = $conn->prepare("DELETE FROM persona WHERE id_persona = ?");
        $stmt->bind_param("i", $this->id_persona);
        return $stmt->execute();
    }

    // ========================================
    // MÉTODOS ESTÁTICOS DE BÚSQUEDA
    // ========================================
    
    /**
     * Buscar persona por ID
     */
    public static function buscarPorId($conn, $id)
    {
        $stmt = $conn->prepare("SELECT * FROM persona WHERE id_persona = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($fila = $resultado->fetch_assoc()) {
            return new Person(
                $fila['nombre'], 
                $fila['apellido'], 
                $fila['fecha_nacimiento'], 
                $fila['dni'], 
                $fila['telefono'], 
                null, // direccion no se usa
                null, // email_contacto ya no se almacena en persona
                $fila['id_persona'],
                $fila['edad']
            );
        }
        return null;
    }

    /**
     * Buscar persona por DNI
     */
    public static function buscarPorDni($conn, $dni)
    {
        $stmt = $conn->prepare("SELECT * FROM persona WHERE dni = ?");
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($fila = $resultado->fetch_assoc()) {
            return new Person(
                $fila['nombre'], 
                $fila['apellido'], 
                $fila['fecha_nacimiento'], 
                $fila['dni'], 
                $fila['telefono'], 
                null, // direccion no se usa
                null, // email_contacto ya no se almacena en persona
                $fila['id_persona']
            );
        }
        return null;
    }

    /**
     * Obtener todas las personas
     */
    public static function obtenerTodas($conn, $limit = null, $offset = 0)
    {
        $sql = "SELECT * FROM persona ORDER BY apellido, nombre";
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
        }
        
        $stmt = $conn->prepare($sql);
        if ($limit) {
            $stmt->bind_param("ii", $limit, $offset);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $personas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $personas[] = new Person(
                $fila['nombre'], 
                $fila['apellido'], 
                $fila['fecha_nacimiento'], 
                $fila['dni'], 
                $fila['telefono'], 
                null, // direccion no se usa
                null, // email_contacto ya no se almacena en persona
                $fila['id_persona']
            );
        }
        
        return $personas;
    }

    /**
     * Buscar personas por nombre o apellido
     */
    public static function buscarPorNombre($conn, $termino)
    {
        $termino = "%{$termino}%";
        $stmt = $conn->prepare("SELECT * FROM persona WHERE nombre LIKE ? OR apellido LIKE ? ORDER BY apellido, nombre");
        $stmt->bind_param("ss", $termino, $termino);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $personas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $personas[] = new Person(
                $fila['nombre'], 
                $fila['apellido'], 
                $fila['fecha_nacimiento'], 
                $fila['dni'], 
                $fila['telefono'], 
                null, // direccion no se usa
                null, // email_contacto ya no se almacena en persona
                $fila['id_persona']
            );
        }
        
        return $personas;
    }

    // ========================================
    // VALIDACIONES
    // ========================================
    
    /**
     * Validar datos de la persona
     */
    public function validar()
    {
        $errores = [];
        
        if (empty($this->nombre)) {
            $errores[] = "El nombre es obligatorio";
        } elseif (strlen($this->nombre) < 2) {
            $errores[] = "El nombre debe tener al menos 2 caracteres";
        }
        
        if (empty($this->apellido)) {
            $errores[] = "El apellido es obligatorio";
        } elseif (strlen($this->apellido) < 2) {
            $errores[] = "El apellido debe tener al menos 2 caracteres";
        }
        
        if (empty($this->dni)) {
            $errores[] = "El DNI es obligatorio";
        } elseif (!preg_match('/^\d{7,8}$/', $this->dni)) {
            $errores[] = "El DNI debe tener 7 u 8 dígitos";
        }
        
        if ($this->fecha_nacimiento) {
            $fecha = DateTime::createFromFormat('Y-m-d', $this->fecha_nacimiento);
            if (!$fecha || $fecha->format('Y-m-d') !== $this->fecha_nacimiento) {
                $errores[] = "Formato de fecha de nacimiento inválido";
            } elseif ($fecha > new DateTime()) {
                $errores[] = "La fecha de nacimiento no puede ser futura";
            }
        }
        
        if ($this->telefono && !preg_match('/^[\d\-\+\(\)\s]+$/', $this->telefono)) {
            $errores[] = "Formato de teléfono inválido";
        }
        
        return $errores;
    }

    /**
     * Verificar si el DNI ya existe (para nuevo registro)
     */
    public function dniExiste($conn)
    {
        $stmt = $conn->prepare("SELECT id_persona FROM persona WHERE dni = ? AND id_persona != ?");
        $id_actual = $this->id_persona ?? 0;
        $stmt->bind_param("si", $this->dni, $id_actual);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}
?>