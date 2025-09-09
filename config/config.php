<?php
/**
 * Configuración de Base de Datos - IFTS15 Sistema Web
 * @author: Sistema de Gestión Académica
 * @date: 5 de septiembre de 2025
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'ifts15_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuración del sitio
define('SITE_URL', 'http://localhost/Mis_Proyectos/Ifts15');
define('SITE_NAME', 'INSTITUTO DE FORMACIÓN TÉCNICA SUPERIOR Nº 15');
define('SITE_DESCRIPTION', 'Realizador y Productor Televisivo');
define('CARD_DESCRIPTION','Tecnología Digital plantea una visión integral de la TV digital como parte de un todo más amplio: el universo audiovisual. Explora formatos tradicionales así como los nuevos modos de creación, producción y consumo audiovisual en la era digital. Busca profundizar y articular los saberes específicos con los de las demás materias de la carrera, así como también de las materias troncales de años anteriores.');

// Configuración de sessiones
define('SESSION_TIMEOUT', 3600); // 1 hora
define('LOGIN_ATTEMPTS', 3);

// Configuración de errores
define('DEBUG_MODE', true);

// Timezone
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Configuración de PHP
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
