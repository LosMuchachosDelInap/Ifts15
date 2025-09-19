<?php
/**
 * Script de prueba para debug del login
 */

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
session_start();

echo "<h2>🔍 Debug del Sistema de Login - IFTS15</h2>";

// Incluir archivos necesarios
require_once 'src/ConectionBD/CConnection.php';
require_once 'src/Model/Person.php';
require_once 'src/Model/User.php';

try {
    echo "<h3>1. Verificando conexión a BD...</h3>";
    $dbConnection = new ConectionDB();
    $conn = $dbConnection->getConnection();
    
    if ($conn && !$conn->connect_error) {
        echo "✅ Conexión exitosa<br>";
    } else {
        echo "❌ Error de conexión: " . ($conn ? $conn->connect_error : 'Conexión nula') . "<br>";
        exit;
    }
    
    echo "<h3>2. Probando buscar usuario por email...</h3>";
    
    // Intentar buscar un usuario (usar un email que probablemente exista)
    $email_prueba = 'prueba@gmail.com'; // Cambia esto por un email que hayas usado
    
    echo "Buscando usuario con email: <strong>$email_prueba</strong><br>";
    
    $user = User::buscarPorEmail($conn, $email_prueba);
    
    if ($user) {
        echo "✅ Usuario encontrado:<br>";
        echo "- ID Usuario: " . $user->getId() . "<br>";
        echo "- Email: " . $user->getEmail() . "<br>";
        echo "- ID Persona: " . $user->getIdPersona() . "<br>";
        echo "- Role ID: " . $user->getRoleId() . "<br>";
        echo "- Activo: " . ($user->getIsActive() ? 'Sí' : 'No') . "<br>";
    } else {
        echo "❌ Usuario no encontrado con email: $email_prueba<br>";
        
        // Listar usuarios existentes
        echo "<h4>📋 Usuarios disponibles en la BD:</h4>";
        $result = $conn->query("SELECT id_usuario, email, is_active FROM usuario LIMIT 10");
        if ($result && $result->num_rows > 0) {
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>Email</th><th>Activo</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['id_usuario'] . "</td><td>" . $row['email'] . "</td><td>" . ($row['is_active'] ? 'Sí' : 'No') . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No hay usuarios en la tabla o error en consulta: " . $conn->error . "<br>";
        }
    }
    
    echo "<h3>3. Probando autenticación completa...</h3>";
    
    if ($user) {
        // Probar verificación de contraseña
        $password_prueba = '12345678'; // Cambia esto por la contraseña correcta
        echo "Probando con contraseña: <strong>$password_prueba</strong><br>";
        
        if ($user->verificarPassword($password_prueba)) {
            echo "✅ Contraseña correcta<br>";
            
            // Probar obtener datos de sesión
            echo "<h4>4. Obteniendo datos de sesión...</h4>";
            $datosSesion = $user->getDatosSesion($conn);
            
            if ($datosSesion) {
                echo "✅ Datos de sesión obtenidos correctamente:<br>";
                echo "<pre>" . print_r($datosSesion, true) . "</pre>";
            } else {
                echo "❌ Error obteniendo datos de sesión<br>";
            }
            
        } else {
            echo "❌ Contraseña incorrecta<br>";
        }
    }
    
    echo "<h3>5. Información del sistema:</h3>";
    echo "- PHP Version: " . phpversion() . "<br>";
    echo "- MySQL Extension: " . (extension_loaded('mysqli') ? 'Cargada' : 'NO cargada') . "<br>";
    echo "- Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido') . "<br>";
    echo "- Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
    
} catch (Exception $e) {
    echo "<h3>❌ Error capturado:</h3>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<p><strong>Stack Trace:</strong></p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>