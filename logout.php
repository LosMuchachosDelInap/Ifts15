<?php
/**
 * Logout - Cerrar Sesión
 */

require_once 'includes/init.php';

// Verificar que el usuario esté logueado
if (!isLoggedIn()) {
    redirect('/index.php');
}

// Obtener nombre para mensaje de despedida
$currentUser = getCurrentUser();
$nombre = $currentUser['nombre'] ?? 'Usuario';

// Cerrar sesión completamente
session_start();
session_unset();
session_destroy();

// Iniciar nueva sesión para el mensaje
session_start();

// Redirigir con mensaje de despedida
showSuccess("¡Hasta pronto, $nombre! Has cerrado sesión correctamente.");
redirect('/index.php');
?>
