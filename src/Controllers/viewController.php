<?php
namespace App\Controllers;

// Controlador genérico para servir vistas desde /src/Views a través de una URL controlada
// Uso: viewController.php?view=nombre-de-la-vista (sin extensión)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config.php';

// Sanitizar el nombre de la vista: permitir solo letras, numeros, guiones y subrayados
$view = $_GET['view'] ?? '';
$view = preg_replace('/[^a-zA-Z0-9_\-]/', '', $view);

if (empty($view)) {
    // Redirigir al index si no hay vista
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

$file = __DIR__ . '/../Views/' . $view . '.php';
if (!file_exists($file)) {
    // Vista no encontrada
    header('Location: ' . BASE_URL . '/index.php?error=accion_invalida');
    exit;
}

// Incluir la vista a través del controlador (la vista puede requerir variables de sesión)
include $file;
exit;

?>
