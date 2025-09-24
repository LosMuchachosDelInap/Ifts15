<?php
/**
 * Cerrar Sesión - IFTS15
 * Script simple para logout
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir BASE_URL desde variable de entorno o fallback
if (!defined('BASE_URL')) {
    if (getenv('BASE_URL')) {
        define('BASE_URL', getenv('BASE_URL'));
    } else {
        define('BASE_URL', 'http://localhost:8000');
    }
}

// Limpiar todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, borrar también la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redireccionar al inicio
header('Location: ' . BASE_URL . '/?logout=success');
exit;
?>