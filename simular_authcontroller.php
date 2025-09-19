<?php
/**
 * Simulación exacta del proceso de login del AuthController
 */

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h2>🔬 Simulación AuthController - IFTS15</h2>";

// Incluir archivos necesarios
require_once 'src/ConectionBD/CConnection.php';
require_once 'src/Model/Person.php';
require_once 'src/Model/User.php';

// Simular datos POST
$_POST['email'] = 'prueba@gmail.com';
$_POST['password'] = '12345678';

try {
    echo "<h3>🚀 Iniciando simulación de AuthController->login()...</h3>";
    
    // Simular el constructor de AuthController
    echo "<p><strong>1. Creando conexión (AuthController constructor):</strong></p>";
    $dbConnection = new ConectionDB();
    $conn = $dbConnection->getConnection();
    echo "✅ Conexión creada<br>";
    
    // Simular método login()
    echo "<p><strong>2. Verificando REQUEST_METHOD:</strong></p>";
    $_SERVER['REQUEST_METHOD'] = 'POST'; // Simular POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo "❌ Método no válido<br>";
        exit;
    }
    echo "✅ Método POST válido<br>";
    
    echo "<p><strong>3. Obteniendo datos POST:</strong></p>";
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    echo "- Email: $email<br>";
    echo "- Password: [HIDDEN]<br>";
    
    echo "<p><strong>4. Validaciones básicas:</strong></p>";
    if (empty($email) || empty($password)) {
        echo "❌ Campos vacíos<br>";
        exit;
    }
    echo "✅ Campos válidos<br>";
    
    echo "<p><strong>5. Iniciando bloque try...</strong></p>";
    
    // Verificar conexión
    echo "<p><strong>6. Verificando conexión:</strong></p>";
    if (!$conn || $conn->connect_error) {
        echo "❌ Error de conexión<br>";
        exit;
    }
    echo "✅ Conexión válida<br>";
    
    // Intentar autenticar
    echo "<p><strong>7. Llamando User::autenticar:</strong></p>";
    $user = User::autenticar($conn, $email, $password);
    
    if ($user) {
        echo "✅ Usuario autenticado<br>";
        echo "- ID: " . $user->getId() . "<br>";
        
        echo "<p><strong>8. Obteniendo datos de sesión:</strong></p>";
        $datosCompletos = $user->getDatosSesion($conn);
        
        echo "<p><strong>9. Validando datos obtenidos:</strong></p>";
        if (!$datosCompletos) {
            echo "❌ Error: datos vacíos<br>";
            exit;
        }
        echo "✅ Datos obtenidos correctamente<br>";
        echo "<pre>"; print_r($datosCompletos); echo "</pre>";
        
        echo "<p><strong>10. Guardando en sesión:</strong></p>";
        foreach ($datosCompletos as $key => $value) {
            $_SESSION[$key] = $value;
            echo "- \$_SESSION['$key'] guardado<br>";
        }
        echo "✅ Todos los datos guardados en sesión<br>";
        
        echo "<p><strong>11. Log de actividad:</strong></p>";
        error_log("Login exitoso: {$email}");
        echo "✅ Log registrado<br>";
        
        echo "<div style='background: #d4edda; padding: 20px; margin: 20px 0; border-radius: 8px;'>";
        echo "<h3>🎉 ¡SIMULACIÓN COMPLETA EXITOSA!</h3>";
        echo "<p><strong>El proceso completo funciona sin errores.</strong></p>";
        echo "<p>En este punto, AuthController haría:</p>";
        echo "<code style='background: #f8f9fa; padding: 5px;'>\$this->redirect('/?login=success');</code>";
        echo "<p><a href='index_fixed.php?login=success' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;'>🔗 Simular redirect a login=success</a></p>";
        echo "</div>";
        
    } else {
        echo "❌ Usuario no autenticado<br>";
    }
    
} catch (mysqli_sql_exception $e) {
    echo "<div style='background: #f8d7da; padding: 15px; margin: 10px; border-radius: 5px;'>";
    echo "<h4>❌ Error MySQL capturado (esto causaría bd_mysql):</h4>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Código:</strong> " . $e->getCode() . "</p>";
    echo "<p><strong>SQLSTATE:</strong> " . $e->getSqlState() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #fff3cd; padding: 15px; margin: 10px; border-radius: 5px;'>";
    echo "<h4>❌ Error general capturado:</h4>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<strong>Stack Trace:</strong><br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}

echo "<h3>📊 Estado final de la sesión:</h3>";
echo "<p><strong>Datos en \$_SESSION:</strong></p>";
echo "<pre>";
foreach ($_SESSION as $key => $value) {
    echo "$key = " . (is_array($value) ? json_encode($value) : $value) . "\n";
}
echo "</pre>";
?>