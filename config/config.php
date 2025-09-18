<?php
/**
 * Configuración de Base de Datos - IFTS15 Sistema Web
 * @author: Sistema de Gestión Académica
 * @date: 5 de septiembre de 2025
 */

// Detectar entorno (localhost vs producción)
$isLocalhost = (
    (isset($_SERVER['HTTP_HOST']) && (
        $_SERVER['HTTP_HOST'] === 'localhost' || 
        $_SERVER['HTTP_HOST'] === '127.0.0.1' || 
        strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0
    )) || 
    !isset($_SERVER['HTTP_HOST']) // CLI mode (como desde terminal)
);

if ($isLocalhost) {
    // Configuración para LOCALHOST (PHP embebido)
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'ifts15'); 
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('SITE_URL', 'http://localhost:8000');
    define('DEBUG_MODE', true);
} else {
    // Configuración para PRODUCCIÓN (InfinityFree)

    define('DB_HOST', 'sql103.infinityfree.com'); 
    define('DB_NAME', 'if0_39904770_ifts15'); 
    define('DB_USER', 'if0_39904770'); 
    define('DB_PASS', 'pNPtg1sJhqrygS'); 
    
    // URL automática para producción
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
    define('SITE_URL', $protocol . '://' . $host);
    define('DEBUG_MODE', false);
}

define('DB_CHARSET', 'utf8mb4');

// Control de base de datos - HABILITADA para desarrollo
define('DISABLE_DATABASE', false);

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
