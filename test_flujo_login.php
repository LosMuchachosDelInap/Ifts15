<?php
/**
 * Test completo del flujo de login
 */

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

echo "<h2>🧪 Test Completo del Flujo de Login - IFTS15</h2>";

// Incluir archivos necesarios
require_once 'src/ConectionBD/CConnection.php';
require_once 'src/Model/Person.php';
require_once 'src/Model/User.php';

try {
    echo "<h3>1. Conexión y configuración inicial...</h3>";
    $dbConnection = new ConectionDB();
    $conn = $dbConnection->getConnection();
    echo "✅ Conexión establecida<br>";
    
    $email_prueba = "prueba@gmail.com";
    $password_prueba = "12345678";
    
    echo "<h3>2. Paso 1: User::buscarPorEmail...</h3>";
    $user = User::buscarPorEmail($conn, $email_prueba);
    
    if ($user) {
        echo "✅ Usuario encontrado<br>";
        echo "- ID: " . $user->getId() . "<br>";
        echo "- Email: " . $user->getEmail() . "<br>";
    } else {
        echo "❌ Usuario no encontrado<br>";
        exit;
    }
    
    echo "<h3>3. Paso 2: Verificar contraseña...</h3>";
    if ($user->verificarPassword($password_prueba)) {
        echo "✅ Contraseña correcta<br>";
    } else {
        echo "❌ Contraseña incorrecta<br>";
        exit;
    }
    
    echo "<h3>4. Paso 3: actualizarUltimoLogin...</h3>";
    if ($user->actualizarUltimoLogin($conn)) {
        echo "✅ Último login actualizado<br>";
    } else {
        echo "❌ Error actualizando último login<br>";
    }
    
    echo "<h3>5. Paso 4: getDatosSesion...</h3>";
    try {
        $datosSesion = $user->getDatosSesion($conn);
        echo "✅ Datos de sesión obtenidos<br>";
        echo "<strong>📋 Datos de sesión:</strong><br>";
        echo "<pre>";
        print_r($datosSesion);
        echo "</pre>";
        
        if (!$datosSesion || !is_array($datosSesion)) {
            echo "❌ Los datos de sesión están vacíos o no son válidos<br>";
        } else {
            echo "✅ Datos de sesión válidos<br>";
        }
        
    } catch (Exception $e) {
        echo "❌ Error en getDatosSesion:<br>";
        echo "<strong>Mensaje:</strong> " . $e->getMessage() . "<br>";
        echo "<strong>Archivo:</strong> " . $e->getFile() . "<br>";
        echo "<strong>Línea:</strong> " . $e->getLine() . "<br>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
        exit;
    }
    
    echo "<h3>6. Paso 5: Simulando guardado en sesión...</h3>";
    if ($datosSesion && is_array($datosSesion)) {
        $_SESSION['test_login'] = true;
        
        foreach ($datosSesion as $key => $value) {
            $_SESSION['test_' . $key] = $value;
            echo "- \$_SESSION['$key'] = " . (is_array($value) ? json_encode($value) : $value) . "<br>";
        }
        
        echo "✅ Datos guardados en sesión<br>";
        
        echo "<div style='background: #d4edda; padding: 20px; margin: 20px 0; border-radius: 8px;'>";
        echo "<h3>🎉 ¡TEST COMPLETO EXITOSO!</h3>";
        echo "<p><strong>Todo el flujo de login funciona correctamente.</strong></p>";
        echo "<p>Las credenciales para usar:</p>";
        echo "<ul>";
        echo "<li><strong>Email:</strong> $email_prueba</li>";
        echo "<li><strong>Contraseña:</strong> $password_prueba</li>";
        echo "</ul>";
        
        echo "<p><a href='index_fixed.php' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;'>🚀 Probar Login Real</a></p>";
        echo "</div>";
        
    } else {
        echo "❌ Error: Los datos de sesión no son válidos<br>";
    }
    
    echo "<h3>7. Información adicional de debug:</h3>";
    echo "- Sesión iniciada: " . (session_status() === PHP_SESSION_ACTIVE ? 'Sí' : 'No') . "<br>";
    echo "- Session ID: " . session_id() . "<br>";
    echo "- Datos en $_SESSION: " . count($_SESSION) . " elementos<br>";
    
} catch (Exception $e) {
    echo "<h3>❌ Error capturado en el test:</h3>";
    echo "<div style='background: #f8d7da; padding: 15px; margin: 10px; border-radius: 5px;'>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<strong>Stack Trace:</strong><br>";
    echo "<pre style='white-space: pre-wrap;'>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}
?>