<?php
/**
 * Debug Login Completo - IFTS15
 * Simula exactamente el proceso de login paso a paso
 */

require_once __DIR__ . '/src/config.php';

use App\ConectionBD\ConectionDB;
use App\Model\User;
use App\Controllers\AuthController;

echo "<h2>🔍 Debug Login Paso a Paso</h2>\n";

try {
    $conectarDB = new ConectionDB();
    $conn = $conectarDB->getConnection();
    
    // Credenciales de prueba
    $email = 'admin@test.com';
    $password = '123456';
    
    echo "<div style='background: #e8f4fd; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>📝 Credenciales de Prueba</h3>\n";
    echo "<p>Email: <code>{$email}</code></p>\n";
    echo "<p>Password: <code>{$password}</code></p>\n";
    echo "</div>\n";
    
    // PASO 1: Verificar conexión BD
    echo "<h3>1️⃣ Verificando conexión BD</h3>\n";
    if ($conn && !$conn->connect_error) {
        echo "<p style='color: green;'>✅ Conexión BD exitosa</p>\n";
    } else {
        echo "<p style='color: red;'>❌ Error de conexión BD</p>\n";
        throw new Exception("Error de conexión a la base de datos");
    }
    
    // PASO 2: Buscar usuario por email
    echo "<h3>2️⃣ Buscando usuario por email</h3>\n";
    $user = User::buscarPorEmail($conn, $email);
    
    if ($user) {
        echo "<p style='color: green;'>✅ Usuario encontrado</p>\n";
        echo "<ul>\n";
        echo "<li>Email: " . $user->getEmail() . "</li>\n";
        echo "<li>ID Usuario: " . $user->getId() . "</li>\n";
        echo "<li>ID Persona: " . $user->getIdPersona() . "</li>\n";
        echo "<li>Role ID: " . $user->getRoleId() . "</li>\n";
        echo "<li>Activo: " . ($user->getIsActive() ? 'Sí' : 'No') . "</li>\n";
        echo "</ul>\n";
    } else {
        echo "<p style='color: red;'>❌ Usuario NO encontrado</p>\n";
        throw new Exception("Usuario no existe en la base de datos");
    }
    
    // PASO 3: Verificar contraseña
    echo "<h3>3️⃣ Verificando contraseña</h3>\n";
    $passwordOk = $user->verificarPassword($password);
    
    if ($passwordOk) {
        echo "<p style='color: green;'>✅ Contraseña correcta</p>\n";
    } else {
        echo "<p style='color: red;'>❌ Contraseña incorrecta</p>\n";
        
        // Debug del hash
        echo "<h4>🔍 Debug del Hash:</h4>\n";
        $hash_from_db = $user->getPasswordHash();
        echo "<p>Hash desde BD: <code>" . substr($hash_from_db, 0, 60) . "...</code></p>\n";
        
        // Probar crear un nuevo hash con la misma contraseña
        $new_hash = password_hash($password, PASSWORD_DEFAULT);
        echo "<p>Hash nuevo: <code>" . substr($new_hash, 0, 60) . "...</code></p>\n";
        
        // Verificar si password_verify funciona
        $verify_result = password_verify($password, $hash_from_db);
        echo "<p>Resultado password_verify: " . ($verify_result ? 'TRUE' : 'FALSE') . "</p>\n";
        
        throw new Exception("Password verification failed");
    }
    
    // PASO 4: Método autenticar completo
    echo "<h3>4️⃣ Probando método autenticar completo</h3>\n";
    $authenticated_user = User::autenticar($conn, $email, $password);
    
    if ($authenticated_user) {
        echo "<p style='color: green; font-weight: bold;'>✅ AUTENTICACIÓN EXITOSA</p>\n";
        echo "<p>Usuario autenticado: {$authenticated_user->getEmail()}</p>\n";
    } else {
        echo "<p style='color: red; font-weight: bold;'>❌ AUTENTICACIÓN FALLIDA</p>\n";
        throw new Exception("Método autenticar falló");
    }
    
    // PASO 5: Simular POST request
    echo "<h3>5️⃣ Simulando datos POST</h3>\n";
    $_POST['email'] = $email;
    $_POST['password'] = $password;
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    echo "<p>Datos POST simulados:</p>\n";
    echo "<ul>\n";
    echo "<li>_POST['email']: " . ($_POST['email'] ?? 'NO SET') . "</li>\n";
    echo "<li>_POST['password']: " . ($_POST['password'] ?? 'NO SET') . "</li>\n";
    echo "<li>REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "</li>\n";
    echo "</ul>\n";
    
    // PASO 6: Test AuthController
    echo "<h3>6️⃣ Probando AuthController</h3>\n";
    
    // Limpiar session para test
    session_start();
    session_unset();
    
    $authController = new AuthController();
    
    // Capturar la salida del login para ver si hay redirects
    ob_start();
    
    try {
        // Esto debería procesar el login
        $authController->login();
        $output = ob_get_contents();
        echo "<p style='color: green;'>✅ AuthController->login() ejecutado sin errores</p>\n";
        
        // Verificar si hay sesión iniciada
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            echo "<p style='color: green; font-weight: bold;'>✅ SESIÓN INICIADA CORRECTAMENTE</p>\n";
            echo "<ul>\n";
            echo "<li>Logged in: " . ($_SESSION['logged_in'] ? 'Sí' : 'No') . "</li>\n";
            echo "<li>Email: " . ($_SESSION['email'] ?? 'No set') . "</li>\n";
            echo "<li>Role: " . ($_SESSION['role'] ?? 'No set') . "</li>\n";
            echo "</ul>\n";
        } else {
            echo "<p style='color: red;'>❌ Sesión NO iniciada</p>\n";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error en AuthController: " . $e->getMessage() . "</p>\n";
    } finally {
        ob_end_clean();
    }
    
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 20px 0;'>\n";
    echo "<h3>✅ Debug Completado</h3>\n";
    echo "<p>Si todos los pasos anteriores muestran ✅, el login debería funcionar.</p>\n";
    echo "<p><strong>Prueba hacer login con:</strong></p>\n";
    echo "<p>Email: <code>{$email}</code></p>\n";
    echo "<p>Password: <code>{$password}</code></p>\n";
    echo "</div>\n";
    
} catch (Exception $e) {
    echo "<div style='color: red; background: #f8d7da; padding: 15px; border-radius: 5px;'>\n";
    echo "<h3>❌ Error en Debug:</h3>\n";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>\n";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>\n";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>\n";
    echo "</div>\n";
}
?>