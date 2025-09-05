<?php
/**
 * Archivo de inicialización del sistema
 * Carga configuraciones y dependencias
 */

// Iniciar sesión
session_start();

// Cargar configuración
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

// Funciones helper
function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    if (isLoggedIn()) {
        return $_SESSION['user_data'] ?? null;
    }
    return null;
}

function hasRole($role) {
    $user = getCurrentUser();
    return $user && isset($user['role']) && $user['role'] === $role;
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
