<?php
/**
 * Test básico de funcionamiento
 */

// Mostrar errores siempre
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>";
echo "<html><head><title>Test IFTS15</title></head><body>";
echo "<h1>Test de Funcionamiento</h1>";

// Test 1: PHP básico
echo "<p><strong>✅ PHP funciona:</strong> " . phpversion() . "</p>";

// Test 2: Archivos críticos
$archivos_criticos = [
    'includes/init.php',
    'config/config.php', 
    'layouts/header.php',
    'layouts/footer.php'
];

foreach ($archivos_criticos as $archivo) {
    if (file_exists($archivo)) {
        echo "<p>✅ <strong>$archivo:</strong> Existe</p>";
    } else {
        echo "<p>❌ <strong>$archivo:</strong> NO EXISTE</p>";
    }
}

// Test 3: Include de configuración
echo "<h2>Test de Configuración</h2>";
try {
    require_once 'config/config.php';
    echo "<p>✅ <strong>config.php:</strong> Cargado correctamente</p>";
    echo "<p><strong>SITE_URL:</strong> " . (defined('SITE_URL') ? SITE_URL : 'NO DEFINIDO') . "</p>";
    echo "<p><strong>DEBUG_MODE:</strong> " . (defined('DEBUG_MODE') ? (DEBUG_MODE ? 'true' : 'false') : 'NO DEFINIDO') . "</p>";
} catch (Exception $e) {
    echo "<p>❌ <strong>config.php:</strong> ERROR - " . $e->getMessage() . "</p>";
}

// Test 4: Include de init
echo "<h2>Test de Init</h2>";
try {
    require_once 'includes/init.php';
    echo "<p>✅ <strong>init.php:</strong> Cargado correctamente</p>";
} catch (Exception $e) {
    echo "<p>❌ <strong>init.php:</strong> ERROR - " . $e->getMessage() . "</p>";
}

// Test 5: Base de datos
echo "<h2>Test de Base de Datos</h2>";
if (defined('DB_HOST')) {
    echo "<p><strong>DB_HOST:</strong> " . DB_HOST . "</p>";
    echo "<p><strong>DB_NAME:</strong> " . DB_NAME . "</p>";
    echo "<p><strong>DB_USER:</strong> " . DB_USER . "</p>";
    
    try {
        require_once 'config/database_mysqli.php';
        $db = Database::getInstance();
        echo "<p>✅ <strong>Conexión BD:</strong> Exitosa</p>";
    } catch (Exception $e) {
        echo "<p>❌ <strong>Conexión BD:</strong> ERROR - " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>❌ <strong>BD:</strong> Configuración no cargada</p>";
}

echo "</body></html>";
?>