<?php
/**
 * Configuración de Base de Datos - IFTS15 Sistema Web
 * @author: Sistema de Gestión Académica
 * @date: 5 de septiembre de 2025
 */

// Detectar entorno (localhost vs producción)
$isLocalhost = (
    $_SERVER['HTTP_HOST'] === 'localhost' || 
    $_SERVER['HTTP_HOST'] === '127.0.0.1' || 
    strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0
);

if ($isLocalhost) {
    // Configuración para LOCALHOST (XAMPP)
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'ifts15_db');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('SITE_URL', 'http://localhost/Mis_Proyectos/Ifts15');
    define('DEBUG_MODE', true);
} else {
    // Configuración para PRODUCCIÓN (InfinityFree)
    // IMPORTANTE: Cambia estos valores por los de tu hosting
    define('DB_HOST', 'sqlXXX.infinityfree.com'); // Cambiar por tu host de DB
    define('DB_NAME', 'epizXXX_ifts15'); // Cambiar por tu nombre de DB
    define('DB_USER', 'epizXXX_usuario'); // Cambiar por tu usuario de DB
    define('DB_PASS', 'tu_password_aqui'); // Cambiar por tu password de DB
    
    // URL automática para producción
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    define('SITE_URL', $protocol . '://' . $_SERVER['HTTP_HOST']);
    define('DEBUG_MODE', false);
}

define('DB_CHARSET', 'utf8mb4');

// Configuración del sitio
define('SITE_NAME', 'INSTITUTO DE FORMACIÓN TÉCNICA SUPERIOR Nº 15');
define('SITE_DESCRIPTION', 'Realizador y Productor Televisivo');
define('CARD_DESCRIPTION','Tecnología Digital plantea una visión integral de la TV digital como parte de un todo más amplio: el universo audiovisual. Explora formatos tradicionales así como los nuevos modos de creación, producción y consumo audiovisual en la era digital. Busca profundizar y articular los saberes específicos con los de las demás materias de la carrera, así como también de las materias troncales de años anteriores.');

// Configuración de sessiones
define('SESSION_TIMEOUT', 3600); // 1 hora
define('LOGIN_ATTEMPTS', 3);

// Timezone
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Configuración de PHP según entorno
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
