<?php
/**
 * Cerrar Sesión - IFTS15
 * Script simple para logout
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir BASE_URL
if (!defined('BASE_URL')) {
    $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    
    if ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, 'localhost:') === 0) {
        $carpeta = '/Mis_Proyectos/Ifts15';
    } else {
        $carpeta = '';
    }
    
    define('BASE_URL', $protocolo . $host . $carpeta);
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