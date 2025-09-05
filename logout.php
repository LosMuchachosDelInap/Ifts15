<?php
/**
 * Logout - Cerrar Sesión
 */

require_once 'includes/init.php';

// Cerrar sesión
session_start();
session_unset();
session_destroy();

// Redirigir con mensaje
showSuccess('Has cerrado sesión correctamente.');
redirect('/login.php');
?>
