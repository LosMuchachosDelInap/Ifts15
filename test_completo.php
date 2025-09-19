<?php
// Test completo incluyendo todos los archivos paso a paso
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Test Paso a Paso</h1>";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "✅ Paso 1: Sesión iniciada<br>";

// Test CConnection
try {
    require_once __DIR__ . '/src/ConectionBD/CConnection.php';
    echo "✅ Paso 2: CConnection incluido<br>";
    
    $db = new ConectionDB();
    $conexion = $db->getConnection();
    echo "✅ Paso 3: Conexión BD exitosa<br>";
} catch (Exception $e) {
    echo "❌ Error en conexión: " . $e->getMessage() . "<br>";
    exit;
}

// Test Models
try {
    require_once __DIR__ . '/src/Model/Person.php';
    echo "✅ Paso 4: Person.php incluido<br>";
    
    require_once __DIR__ . '/src/Model/User.php';
    echo "✅ Paso 5: User.php incluido<br>";
} catch (Exception $e) {
    echo "❌ Error en modelos: " . $e->getMessage() . "<br>";
    exit;
}

// Test Controllers
try {
    require_once __DIR__ . '/src/Controllers/AuthController.php';
    echo "✅ Paso 6: AuthController incluido<br>";
} catch (Exception $e) {
    echo "❌ Error en controladores: " . $e->getMessage() . "<br>";
    exit;
}

// Test Templates
try {
    echo "✅ Paso 7: Intentando incluir head.php...<br>";
    ob_start();
    include_once(__DIR__ . "/src/Template/head.php");
    $head_content = ob_get_clean();
    echo "✅ Paso 8: head.php incluido exitosamente<br>";
    
    echo "✅ Paso 9: Intentando incluir navBar.php...<br>";
    $isLoggedIn = false;
    $userEmail = '';
    $userRole = 'estudiante';
    ob_start();
    include_once(__DIR__ . "/src/Template/navBar.php");
    $navbar_content = ob_get_clean();
    echo "✅ Paso 10: navBar.php incluido exitosamente<br>";
    
} catch (Exception $e) {
    echo "❌ Error en templates: " . $e->getMessage() . "<br>";
    exit;
}

echo "<h2>✅ ¡Todos los archivos se cargan correctamente!</h2>";
echo "<p>El problema debe estar en otro lado...</p>";
?>