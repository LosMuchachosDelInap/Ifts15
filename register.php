<?php
/**
 * Procesamiento de Registro - IFTS15
 * Archivo: register.php (solo procesamiento, sin vista)
 * Migrado a PSR-4 con AuthController
 */

// Cargar configuración central con phpdotenv
require_once __DIR__ . '/src/config.php';

use App\Controllers\AuthController;

// Si el usuario ya está logueado, redirigir
if (isLoggedIn()) {
    header('Location: ' . BASE_URL);
    exit;
}

// Si alguien accede directamente sin POST, redirigir al inicio
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL);
    exit;
}

// Procesar formulario de registro usando AuthController
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $authController = new AuthController();
        $authController->register();
    } catch (Exception $e) {
        if (DEBUG_MODE) {
            showError("Error: " . $e->getMessage());
        } else {
            showError('Error interno del sistema');
        }
        header('Location: ' . BASE_URL . '/#register');
        exit;
    }
}
?>
