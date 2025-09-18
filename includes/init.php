<?php
/**
 * Archivo de inicialización del sistema
 * Carga configuraciones y dependencias
 */

// Iniciar sesión
session_start();

// Cargar configuración
require_once __DIR__ . '/../config/config.php';

// Solo cargar database.php si no está desactivada
if (!defined('DISABLE_DATABASE') || !DISABLE_DATABASE) {
    // Usar MySQLi como alternativa a PDO
    require_once __DIR__ . '/../config/database_mysqli.php';
}

// Funciones helper
function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit();
}

function isLoggedIn() {
    // Para demo sin BD, siempre retorna false
    if (defined('DISABLE_DATABASE') && DISABLE_DATABASE) {
        return false;
    }
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    // Para demo sin BD, retorna datos de ejemplo
    if (defined('DISABLE_DATABASE') && DISABLE_DATABASE) {
        return [
            'id' => 1,
            'nombre' => 'Usuario',
            'apellido' => 'Demo',
            'email' => 'demo@ifts15.edu.ar',
            'rol' => 'demo'
        ];
    }
    
    if (!isLoggedIn()) {
        return null;
    }
    
    // Si ya tenemos datos en sesión, usarlos
    if (isset($_SESSION['user_data'])) {
        return $_SESSION['user_data'];
    }
    
    try {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT 
                u.id_usuario as id,
                u.email,
                p.nombre,
                p.apellido,
                p.dni,
                p.telefono,
                p.edad,
                r.rol,
                c.carrera,
                com.comision,
                a.año as anio_cursada
            FROM usuario u 
            LEFT JOIN persona p ON u.id_persona = p.id_persona 
            LEFT JOIN roles r ON u.id_rol = r.id_rol
            LEFT JOIN carrera c ON u.id_carrera = c.id_carrera
            LEFT JOIN comision com ON u.id_comision = com.id_comision
            LEFT JOIN añocursada a ON u.id_añoCursada = a.id_añoCursada
            WHERE u.id_usuario = ? AND u.habilitado = 1
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        // Guardar en sesión para próximas consultas
        if ($user) {
            $_SESSION['user_data'] = $user;
        }
        
        return $user;
    } catch (Exception $e) {
        if (DEBUG_MODE) {
            error_log("Error en getCurrentUser(): " . $e->getMessage());
        }
        return null;
    }
}

function hasRole($role) {
    // Para demo sin BD, siempre retorna false
    if (defined('DISABLE_DATABASE') && DISABLE_DATABASE) {
        return false;
    }
    
    $user = getCurrentUser();
    return $user && $user['rol'] === $role;
}

function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function generateToken() {
    return bin2hex(random_bytes(32));
}

function formatDate($date) {
    return date('d/m/Y H:i', strtotime($date));
}

function showError($message) {
    $_SESSION['error'] = $message;
}

function showSuccess($message) {
    $_SESSION['success'] = $message;
}

function getError() {
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
        return $error;
    }
    return null;
}

function getSuccess() {
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
        return $success;
    }
    return null;
}

/**
 * Función para formatear bytes
 */
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    for ($i = 0; $bytes > 1024; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}

// Cargar controladores
function loadController($controller) {
    $file = __DIR__ . "/controllers/{$controller}.php";
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    return false;
}

// Cargar modelos
function loadModel($model) {
    $file = __DIR__ . "/models/{$model}.php";
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    return false;
}
?>
