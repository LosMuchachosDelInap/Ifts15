<?php
/**
 * Verificación del Sistema para InfinityFree
 * Archivo: verify-system.php
 * Ejecuta este archivo después de subir a InfinityFree para verificar que todo funciona
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Verificación IFTS15</title>";
echo "<style>body{font-family:Arial;margin:20px;} .ok{color:green;} .error{color:red;} .warning{color:orange;}</style>";
echo "</head><body>";

echo "<h1>🔍 Verificación del Sistema IFTS15</h1>";
echo "<p><strong>Fecha:</strong> " . date('Y-m-d H:i:s') . "</p>";

// 1. Verificar archivos de configuración
echo "<h2>📁 Archivos de Configuración</h2>";
if (file_exists('config/config.php')) {
    echo "<p class='ok'>✅ config/config.php existe</p>";
    include_once 'config/config.php';
    echo "<p class='ok'>✅ config.php cargado correctamente</p>";
    echo "<p><strong>SITE_URL:</strong> " . SITE_URL . "</p>";
    echo "<p><strong>DEBUG_MODE:</strong> " . (DEBUG_MODE ? 'true' : 'false') . "</p>";
} else {
    echo "<p class='error'>❌ config/config.php NO EXISTE</p>";
}

// 2. Verificar conexión a base de datos
echo "<h2>🗄️ Conexión a Base de Datos</h2>";
try {
    if (file_exists('config/database.php')) {
        include_once 'config/database.php';
        $db = Database::getInstance();
        echo "<p class='ok'>✅ Conexión a base de datos exitosa</p>";
        
        // Verificar tablas
        $stmt = $db->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p><strong>Tablas encontradas:</strong> " . count($tables) . "</p>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
        
    } else {
        echo "<p class='error'>❌ database.php NO EXISTE</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Error de conexión: " . $e->getMessage() . "</p>";
}

// 3. Verificar archivos principales
echo "<h2>📄 Archivos Principales</h2>";
$archivos = [
    'index.php',
    'login.php',
    'register.php',
    'layouts/header.php',
    'layouts/navbar.php',
    'layouts/footer.php',
    'assets/css/custom.css',
    'assets/js/main.js'
];

foreach ($archivos as $archivo) {
    if (file_exists($archivo)) {
        echo "<p class='ok'>✅ $archivo existe</p>";
    } else {
        echo "<p class='error'>❌ $archivo NO EXISTE</p>";
    }
}

// 4. Verificar imágenes del carrusel
echo "<h2>🖼️ Imágenes del Carrusel</h2>";
$imagenes = [
    'assets/images/carrussel_1.png',
    'assets/images/carrussel_2.png',
    'assets/images/carrussel_3.png',
    'assets/images/logo.png'
];

foreach ($imagenes as $imagen) {
    if (file_exists($imagen)) {
        $size = filesize($imagen);
        echo "<p class='ok'>✅ $imagen existe (" . round($size/1024, 2) . " KB)</p>";
    } else {
        echo "<p class='error'>❌ $imagen NO EXISTE</p>";
    }
}

// 5. Verificar permisos
echo "<h2>🔐 Permisos de Archivos</h2>";
$permisos = [
    'assets/images/' => '755',
    'config/' => '755',
    'includes/' => '755',
    'layouts/' => '755'
];

foreach ($permisos as $ruta => $permiso_esperado) {
    if (file_exists($ruta)) {
        $permiso_actual = substr(sprintf('%o', fileperms($ruta)), -3);
        if ($permiso_actual >= $permiso_esperado) {
            echo "<p class='ok'>✅ $ruta permisos OK ($permiso_actual)</p>";
        } else {
            echo "<p class='warning'>⚠️ $ruta permisos pueden ser insuficientes ($permiso_actual)</p>";
        }
    } else {
        echo "<p class='error'>❌ $ruta NO EXISTE</p>";
    }
}

// 6. Información del servidor
echo "<h2>🖥️ Información del Servidor</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido') . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>HTTP Host:</strong> " . $_SERVER['HTTP_HOST'] . "</p>";

// 7. Test de funciones PHP
echo "<h2>⚙️ Funciones PHP</h2>";
$funciones = ['curl_init', 'mysqli_connect', 'json_encode', 'password_hash'];
foreach ($funciones as $funcion) {
    if (function_exists($funcion)) {
        echo "<p class='ok'>✅ $funcion disponible</p>";
    } else {
        echo "<p class='warning'>⚠️ $funcion NO disponible</p>";
    }
}

echo "<hr>";
echo "<p><strong>✅ Verificación completada</strong></p>";
echo "<p><a href='index.php'>← Volver al sitio</a></p>";

echo "</body></html>";
?>
