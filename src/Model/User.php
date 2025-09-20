<?php

namespace App\Model;

use App\ConectionBD\ConectionDB;
use Exception;

/**
 * Modelo User - IFTS15
 * Basado en el patrón de La Canchita de Los Pibes
 * 
 * @package App\Model
 */
class User
{
    private $id_usuario;
    private $email;
    private $password_hash;
    private $id_persona;
    private $role_id;
    private $id_carrera;
    private $id_comision;
    private $id_anoCursada;
    private $is_active;
    private $created_at;
    private $updated_at;
    private $last_login;

    public function __construct($email, $password, $id_persona, $role_id = 2, $id_carrera = null, $id_comision = null, $id_anoCursada = null, $id_usuario = null, $hash_password = true)
    {
        $this->id_usuario = $id_usuario;
        $this->email = $email;
        // Si $hash_password es true, hashea la contraseña; si es false, ya viene hasheada
        $this->password_hash = $hash_password ? password_hash($password, PASSWORD_DEFAULT) : $password;
        $this->id_persona = $id_persona;
        $this->role_id = $role_id; // 1=admin, 2=estudiante, 3=profesor
        $this->id_carrera = $id_carrera;
        $this->id_comision = $id_comision;
        $this->id_anoCursada = $id_anoCursada;
        $this->is_active = true;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }

    // ========================================
    // GETTERS
    // ========================================
    public function getId() { return $this->id_usuario; }
    public function getEmail() { return $this->email; }
    public function getPasswordHash() { return $this->password_hash; }
    public function getIdPersona() { return $this->id_persona; }
    public function getRoleId() { return $this->role_id; }
    public function getIsActive() { return $this->is_active; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }
    public function getLastLogin() { return $this->last_login; }

    // ========================================
    // SETTERS
    // ========================================
    public function setEmail($email) { 
        $this->email = $email; 
        $this->updated_at = date('Y-m-d H:i:s');
    }
    
    public function setPassword($password) { 
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT); 
        $this->updated_at = date('Y-m-d H:i:s');
    }
    
    public function setRoleId($role_id) { 
        $this->role_id = $role_id; 
        $this->updated_at = date('Y-m-d H:i:s');
    }
    
    public function setIsActive($is_active) { 
        $this->is_active = $is_active; 
        $this->updated_at = date('Y-m-d H:i:s');
    }

    public function updateLastLogin() {
        $this->last_login = date('Y-m-d H:i:s');
    }

    // ========================================
    // MÉTODOS DE BASE DE DATOS
    // ========================================
    
    /**
     * Guardar usuario en la base de datos
     */
    public function guardar($conn)
    {
        try {
            // Adaptar a la estructura de BD existente con campos académicos
            $stmt = $conn->prepare("INSERT INTO usuario (email, clave, id_persona, id_rol, id_carrera, id_comision, id_añoCursada, habilitado) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("ssiiiii", 
                $this->email, 
                $this->password_hash, 
                $this->id_persona, 
                $this->role_id,
                $this->id_carrera,
                $this->id_comision, 
                $this->id_anoCursada
            );
            
            if ($stmt->execute()) {
                $this->id_usuario = $conn->insert_id;
                $this->is_active = 1;
                return true;
            }
            
        } catch (mysqli_sql_exception $e) {
            error_log("Error guardando usuario: " . $e->getMessage());
            
            // Si es error de duplicado
            if ($e->getCode() == 1062) {
                throw new Exception("El email ya está registrado");
            }
            throw new Exception("Error interno del servidor");
        }
        
        return false;
    }

    /**
     * Actualizar usuario existente
     */
    public function actualizar($conn)
    {
        // Adaptar a la estructura de BD existente
        $stmt = $conn->prepare("UPDATE usuario SET email = ?, clave = ?, habilitado = ? WHERE id_usuario = ?");
        $stmt->bind_param("ssii", 
            $this->email, 
            $this->password_hash, 
            $this->is_active,
            $this->id_usuario
        );
        return $stmt->execute();
    }

    /**
     * Actualizar solo último login (simplificado para BD existente)
     */
    public function actualizarUltimoLogin($conn)
    {
        $this->updateLastLogin();
        // En la BD actual no tenemos last_login, así que simplemente actualizamos la fecha interna
        return true; // Siempre exitoso para mantener compatibilidad
    }

    /**
     * Eliminar usuario (soft delete - marcar como inactivo)
     */
    public function eliminar($conn, $soft_delete = true)
    {
        if ($soft_delete) {
            // Adaptar a BD existente: usar habilitado = 0 en lugar de is_active = false
            $stmt = $conn->prepare("UPDATE usuario SET habilitado = 0 WHERE id_usuario = ?");
            $stmt->bind_param("i", $this->id_usuario);
            if ($stmt->execute()) {
                $this->is_active = false;
                return true;
            }
            return false;
        } else {
            $stmt = $conn->prepare("DELETE FROM usuario WHERE id_usuario = ?");
            $stmt->bind_param("i", $this->id_usuario);
            return $stmt->execute();
        }
    }

    // ========================================
    // MÉTODOS ESTÁTICOS DE BÚSQUEDA
    // ========================================
    
    /**
     * Buscar usuario por ID
     */
    public static function buscarPorId($conn, $id)
    {
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($fila = $resultado->fetch_assoc()) {
            $user = new User(
                $fila['email'], 
                $fila['clave'], // Usar 'clave' que es el nombre real
                $fila['id_persona'], 
                $fila['id_rol'], // Usar 'id_rol' que es el nombre real
                $fila['id_usuario'], 
                false // No hashear, ya viene hasheado
            );
            // Usar solo campos que existen en la BD
            $user->is_active = $fila['habilitado'] ?? 1;
            $user->created_at = $fila['idCreate'] ?? null;
            $user->updated_at = $fila['idUpdate'] ?? null;
            // last_login no existe en tu esquema
            return $user;
        }
        return null;
    }

    /**
     * Buscar usuario por email
     */
    public static function buscarPorEmail($conn, $email)
    {
        // Adaptar a la estructura de BD existente - usar 'habilitado' en lugar de 'is_active'
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ? AND habilitado = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($fila = $resultado->fetch_assoc()) {
            $user = new User(
                $fila['email'], 
                $fila['clave'], // Usar directamente 'clave' que es el nombre real de la columna
                $fila['id_persona'], 
                $fila['id_rol'], // Usar 'id_rol' que es el nombre real de la columna
                $fila['id_carrera'] ?? null,    // id_carrera
                $fila['id_comision'] ?? null,   // id_comision
                $fila['id_añoCursada'] ?? null, // id_anoCursada
                $fila['id_usuario'],            // id_usuario
                false // No volver a hashear, ya viene de BD
            );
            
            // Mapear campos de la BD existente
            $user->is_active = $fila['habilitado'] ?? 1;
            $user->created_at = $fila['idCreate'] ?? $fila['created_at'] ?? null;
            $user->updated_at = $fila['idUpdate'] ?? $fila['updated_at'] ?? null;
            $user->last_login = $fila['last_login'] ?? null;
            
            return $user;
        }
        return null;
    }

    /**
     * Obtener usuario con datos de persona y rol
     */
    public static function obtenerUsuarioCompleto($conn, $id_usuario)
    {
        // Adaptar consulta a la estructura real de BD
        $sql = "SELECT u.*, p.nombre, p.apellido, p.dni, p.telefono
                FROM usuario u 
                LEFT JOIN persona p ON u.id_persona = p.id_persona 
                WHERE u.id_usuario = ? AND u.habilitado = 1";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparando consulta obtenerUsuarioCompleto: " . $conn->error);
        }
        
        $stmt->bind_param("i", $id_usuario);
        
        if (!$stmt->execute()) {
            throw new Exception("Error ejecutando consulta obtenerUsuarioCompleto: " . $stmt->error);
        }
        
        $resultado = $stmt->get_result();
        if (!$resultado) {
            throw new Exception("Error obteniendo resultado obtenerUsuarioCompleto: " . $stmt->error);
        }
        
        $datos = $resultado->fetch_assoc();
        
        // Si encontramos datos, agregar nombre del rol por defecto
        if ($datos) {
            $datos['role_name'] = 'Usuario'; // Rol por defecto
        }
        
        return $datos;
    }

    /**
     * Obtener todos los usuarios activos
     */
    public static function obtenerTodosActivos($conn, $limit = null, $offset = 0)
    {
        // Adaptar a BD existente
        $sql = "SELECT u.*, p.nombre, p.apellido, 'Usuario' as role_name
                FROM usuario u 
                LEFT JOIN persona p ON u.id_persona = p.id_persona 
                WHERE u.habilitado = 1 
                ORDER BY p.apellido, p.nombre";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
        }
        
        $stmt = $conn->prepare($sql);
        if ($limit) {
            $stmt->bind_param("ii", $limit, $offset);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Obtener usuarios por rol
     */
    public static function obtenerPorRol($conn, $role_id)
    {
        $sql = "SELECT u.*, p.nombre, p.apellido
                FROM usuario u 
                LEFT JOIN persona p ON u.id_persona = p.id_persona 
                WHERE u.id_rol = ? AND u.habilitado = 1 
                ORDER BY p.apellido, p.nombre";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ========================================
    // AUTENTICACIÓN
    // ========================================
    
    /**
     * Verificar contraseña
     */
    public function verificarPassword($password)
    {
        return password_verify($password, $this->password_hash);
    }

    /**
     * Autenticar usuario
     */
    public static function autenticar($conn, $email, $password)
    {
        $user = self::buscarPorEmail($conn, $email);
        
        if ($user && $user->verificarPassword($password)) {
            $user->actualizarUltimoLogin($conn);
            return $user;
        }
        
        return null;
    }

    /**
     * Obtener nombre del rol
     */
    public function getNombreRol($conn)
    {
        $stmt = $conn->prepare("SELECT nombre FROM roles WHERE id_rol = ?");
        $stmt->bind_param("i", $this->role_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($fila = $resultado->fetch_assoc()) {
            return $fila['nombre'];
        }
        return 'Sin rol';
    }

    // ========================================
    // VALIDACIONES
    // ========================================
    
    /**
     * Validar datos del usuario
     */
    public function validar($conn = null)
    {
        $errores = [];
        
        if (empty($this->email)) {
            $errores[] = "El email es obligatorio";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Formato de email inválido";
        } elseif ($conn && $this->emailExiste($conn)) {
            $errores[] = "Este email ya está registrado";
        }
        
        if (!$this->id_usuario && empty($this->password_hash)) {
            $errores[] = "La contraseña es obligatoria";
        }
        
        if (!in_array($this->role_id, [1, 2, 3])) {
            $errores[] = "Rol inválido";
        }
        
        if (empty($this->id_persona)) {
            $errores[] = "Debe estar asociado a una persona";
        }
        
        return $errores;
    }

    /**
     * Verificar si el email ya existe
     */
    public function emailExiste($conn)
    {
        $stmt = $conn->prepare("SELECT id_usuario FROM usuario WHERE email = ? AND id_usuario != ? AND habilitado = 1");
        $id_actual = $this->id_usuario ?? 0;
        $stmt->bind_param("si", $this->email, $id_actual);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    /**
     * Generar token de recuperación de contraseña
     */
    public function generarTokenRecuperacion($conn)
    {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = ?, expires_at = ?");
        $stmt->bind_param("sssss", $this->email, $token, $expires, $token, $expires);
        
        if ($stmt->execute()) {
            return $token;
        }
        return false;
    }

    // ========================================
    // UTILIDADES
    // ========================================
    
    /**
     * Obtener datos para sesión
     */
    public function getDatosSesion($conn)
    {
        try {
            $datos = self::obtenerUsuarioCompleto($conn, $this->id_usuario);
            
            if (!$datos) {
                throw new Exception("No se pudieron obtener datos del usuario ID: " . $this->id_usuario);
            }
            
            return [
                'id_usuario' => $this->id_usuario,
                'email' => $this->email,
                'nombre' => $datos['nombre'] ?? 'Sin nombre',
                'apellido' => $datos['apellido'] ?? 'Sin apellido',
                'nombre_completo' => trim(($datos['nombre'] ?? '') . ' ' . ($datos['apellido'] ?? '')),
                'role_id' => $datos['id_rol'] ?? 1, // Usar el id_rol de la BD real
                'role' => $datos['role_name'] ?? 'Usuario',
                'logged_in' => true,
                'last_login' => $this->last_login
            ];
            
        } catch (Exception $e) {
            error_log("Error en getDatosSesion: " . $e->getMessage());
            throw new Exception("Error obteniendo datos de sesión: " . $e->getMessage());
        }
    }
}
?>