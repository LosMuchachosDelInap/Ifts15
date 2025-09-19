<?php
// Test de debug simple
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Paso 1: PHP funcionando<br>";

// Test sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "Paso 2: Sesión iniciada<br>";

// Test conexión
echo "Paso 3: Intentando incluir CConnection...<br>";
try {
    require_once __DIR__ . '/src/ConectionBD/CConnection.php';
    echo "Paso 4: CConnection incluido exitosamente<br>";
    
    // Test de conexión a BD
    echo "Paso 5: Intentando conectar a BD...<br>";
    $db = new ConectionDB();
    $conexion = $db->getConnection();
    echo "Paso 6: Conexión exitosa<br>";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "<br>";
    echo "TRACE: " . $e->getTraceAsString() . "<br>";
}

echo "Test completado.";
?>