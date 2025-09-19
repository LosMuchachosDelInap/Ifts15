<?php
/**
 * Script detallado para debuggar el error de login MySQL
 */

// Configuración de errores detallada
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

echo "<h2>🔍 Debug Detallado del Error MySQL - IFTS15</h2>";

// Incluir archivos necesarios
require_once 'src/ConectionBD/CConnection.php';
require_once 'src/Model/Person.php';
require_once 'src/Model/User.php';

try {
    echo "<h3>1. Probando conexión básica...</h3>";
    $dbConnection = new ConectionDB();
    $conn = $dbConnection->getConnection();
    
    if ($conn && !$conn->connect_error) {
        echo "✅ Conexión exitosa<br>";
        echo "📊 Info de conexión:<br>";
        echo "- Host info: " . $conn->host_info . "<br>";
        echo "- Server version: " . $conn->server_version . "<br>";
        echo "- Protocol version: " . $conn->protocol_version . "<br>";
    } else {
        echo "❌ Error de conexión: " . ($conn ? $conn->connect_error : 'Conexión nula') . "<br>";
        exit;
    }
    
    echo "<h3>2. Verificando estructura de tabla usuario...</h3>";
    
    $structure = $conn->query("DESCRIBE usuario");
    if ($structure) {
        echo "✅ Tabla usuario encontrada. Columnas:<br>";
        echo "<ul>";
        while ($col = $structure->fetch_assoc()) {
            echo "<li><strong>" . $col['Field'] . "</strong> - " . $col['Type'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "❌ Error obteniendo estructura: " . $conn->error . "<br>";
        exit;
    }
    
    echo "<h3>3. Probando consulta directa de usuario...</h3>";
    
    $email_prueba = 'prueba@gmail.com';
    echo "Buscando email: <strong>$email_prueba</strong><br>";
    
    // Probar consulta manual primero
    $query_manual = "SELECT * FROM usuario WHERE email = '$email_prueba' AND habilitado = 1";
    echo "🔧 Query manual: <code>$query_manual</code><br>";
    
    $result_manual = $conn->query($query_manual);
    if ($result_manual) {
        if ($result_manual->num_rows > 0) {
            echo "✅ Usuario encontrado con query manual<br>";
            $user_data = $result_manual->fetch_assoc();
            
            echo "<strong>📋 Datos encontrados:</strong><br>";
            foreach ($user_data as $key => $value) {
                echo "- $key: " . ($value ?? 'NULL') . "<br>";
            }
        } else {
            echo "❌ No se encontró usuario con query manual<br>";
        }
    } else {
        echo "❌ Error en query manual: " . $conn->error . "<br>";
    }
    
    echo "<h3>4. Probando consulta con prepared statement...</h3>";
    
    try {
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ? AND habilitado = 1");
        if (!$stmt) {
            throw new Exception("Error preparando statement: " . $conn->error);
        }
        
        $stmt->bind_param("s", $email_prueba);
        
        if (!$stmt->execute()) {
            throw new Exception("Error ejecutando statement: " . $stmt->error);
        }
        
        $resultado = $stmt->get_result();
        if (!$resultado) {
            throw new Exception("Error obteniendo resultado: " . $stmt->error);
        }
        
        if ($fila = $resultado->fetch_assoc()) {
            echo "✅ Usuario encontrado con prepared statement<br>";
            echo "<strong>📋 Datos del usuario:</strong><br>";
            foreach ($fila as $key => $value) {
                echo "- $key: " . ($value ?? 'NULL') . "<br>";
            }
            
            // Verificar la contraseña
            echo "<h4>5. Probando verificación de contraseña...</h4>";
            $password_prueba = '12345678';
            
            $password_hash = $fila['clave'] ?? null;
            if ($password_hash) {
                echo "Hash en BD: <code>" . substr($password_hash, 0, 30) . "...</code><br>";
                
                if (password_verify($password_prueba, $password_hash)) {
                    echo "✅ Contraseña verificada correctamente<br>";
                } else {
                    echo "❌ Contraseña no coincide<br>";
                    
                    // Verificar si el hash está correcto
                    echo "<strong>🔍 Análisis del hash:</strong><br>";
                    echo "- Longitud: " . strlen($password_hash) . "<br>";
                    echo "- Comienza con: " . substr($password_hash, 0, 10) . "<br>";
                    
                    // Intentar crear un hash nuevo para comparar
                    $new_hash = password_hash($password_prueba, PASSWORD_DEFAULT);
                    echo "- Hash nuevo: " . substr($new_hash, 0, 30) . "...<br>";
                }
            } else {
                echo "❌ No hay hash de contraseña en la BD<br>";
            }
            
        } else {
            echo "❌ No se encontró usuario con prepared statement<br>";
        }
        
    } catch (mysqli_sql_exception $e) {
        echo "<h4>❌ Error MySQL específico:</h4>";
        echo "<p><strong>Código:</strong> " . $e->getCode() . "</p>";
        echo "<p><strong>SQLSTATE:</strong> " . $e->getSqlState() . "</p>";
        echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    }
    
    echo "<h3>6. Probando método User::buscarPorEmail directamente...</h3>";
    
    try {
        $user = User::buscarPorEmail($conn, $email_prueba);
        if ($user) {
            echo "✅ User::buscarPorEmail funciona correctamente<br>";
            echo "- ID: " . $user->getId() . "<br>";
            echo "- Email: " . $user->getEmail() . "<br>";
            echo "- ID Persona: " . $user->getIdPersona() . "<br>";
        } else {
            echo "❌ User::buscarPorEmail devolvió null<br>";
        }
    } catch (Exception $e) {
        echo "<h4>❌ Error en User::buscarPorEmail:</h4>";
        echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
        echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
        echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    }
    
    echo "<h3>7. Información del sistema:</h3>";
    echo "- PHP Version: " . phpversion() . "<br>";
    echo "- MySQLi Version: " . mysqli_get_client_info() . "<br>";
    echo "- Error Reporting Level: " . error_reporting() . "<br>";
    
} catch (Exception $e) {
    echo "<h3>❌ Error general capturado:</h3>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<p><strong>Stack Trace:</strong></p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>