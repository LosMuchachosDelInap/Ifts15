<?php
/**
 * Debug de Autenticación - IFTS15
 * Script temporal para diagnosticar problemas de login
 */

// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/src/config.php';

use App\ConectionBD\ConectionDB;
use App\Model\User;

try {
    $conectarDB = new ConectionDB();
    $conn = $conectarDB->getConnection();
    
    echo "<h2>🔍 Debug de Autenticación</h2>\n";
    
    // Mostrar usuarios existentes
    echo "<h3>👥 Usuarios en Base de Datos:</h3>\n";
    $query = "SELECT id_usuario, email, clave, habilitado, cancelado, id_rol FROM usuario";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>\n";
        echo "<tr><th>ID</th><th>Email</th><th>Clave (Hash)</th><th>Habilitado</th><th>Cancelado</th><th>Rol</th></tr>\n";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>\n";
            echo "<td>{$row['id_usuario']}</td>\n";
            echo "<td>{$row['email']}</td>\n";
            echo "<td>" . substr($row['clave'], 0, 30) . "...</td>\n";
            echo "<td>" . ($row['habilitado'] ? '✅' : '❌') . "</td>\n";
            echo "<td>" . ($row['cancelado'] ? '❌' : '✅') . "</td>\n";
            echo "<td>{$row['id_rol']}</td>\n";
            echo "</tr>\n";
        }
        echo "</table>\n";
    } else {
        echo "<p style='color: red;'>❌ No hay usuarios en la base de datos</p>\n";
    }

echo "<h1>🔧 Debug AuthController - IFTS15</h1>";

try {
    // 1. Verificar archivo config.php
    echo "<h3>1. Verificando config.php</h3>";
    if (file_exists(dirname(__DIR__) . '/config.php')) {
        echo "✅ config.php existe<br>";
        require_once dirname(__DIR__) . '/config.php';
        echo "✅ config.php cargado correctamente<br>";
        echo "BASE_URL: " . (defined('BASE_URL') ? BASE_URL : 'No definido') . "<br>";
    } else {
        echo "❌ config.php no encontrado<br>";
    }

    // 2. Verificar modelos
    echo "<h3>2. Verificando modelos</h3>";
    $modelos = [
        'User.php' => dirname(__DIR__) . '/Model/User.php',
        'Person.php' => dirname(__DIR__) . '/Model/Person.php',
        'CConnection.php' => dirname(__DIR__) . '/ConectionBD/CConnection.php'
    ];
    
    foreach ($modelos as $nombre => $ruta) {
        if (file_exists($ruta)) {
            echo "✅ $nombre existe<br>";
            require_once $ruta;
            echo "✅ $nombre cargado<br>";
        } else {
            echo "❌ $nombre no encontrado en $ruta<br>";
        }
    }

    // 3. Verificar conexión a base de datos
    echo "<h3>3. Verificando conexión BD</h3>";
    if (class_exists('ConectionDB')) {
        echo "✅ Clase ConectionDB existe<br>";
        $dbConnection = new ConectionDB();
        $conn = $dbConnection->getConnection();
        
        if ($conn) {
            echo "✅ Conexión a BD establecida<br>";
        } else {
            echo "❌ No se pudo conectar a la BD<br>";
        }
    } else {
        echo "❌ Clase ConectionDB no existe<br>";
    }

    // 4. Verificar clases modelo
    echo "<h3>4. Verificando clases modelo</h3>";
    $clases = ['User', 'Person'];
    foreach ($clases as $clase) {
        if (class_exists($clase)) {
            echo "✅ Clase $clase existe<br>";
        } else {
            echo "❌ Clase $clase no existe<br>";
        }
    }

    // 5. Test del controlador
    echo "<h3>5. Verificando AuthController</h3>";
    if (file_exists(__DIR__ . '/AuthController.php')) {
        echo "✅ AuthController.php existe<br>";
        
        // Probar instanciar el controlador
        require_once __DIR__ . '/AuthController.php';
        if (class_exists('AuthController')) {
            echo "✅ Clase AuthController existe<br>";
            
            try {
                $authController = new AuthController();
                echo "✅ AuthController instanciado correctamente<br>";
            } catch (Exception $e) {
                echo "❌ Error instanciando AuthController: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "❌ Clase AuthController no encontrada<br>";
        }
    } else {
        echo "❌ AuthController.php no existe<br>";
    }

    echo "<h3>✅ Debug completado</h3>";

} catch (Exception $e) {
    echo "<h3 style='color: red;'>❌ ERROR GENERAL</h3>";
    echo "Mensaje: " . $e->getMessage() . "<br>";
    echo "Archivo: " . $e->getFile() . "<br>";
    echo "Línea: " . $e->getLine() . "<br>";
    echo "Stack trace:<br><pre>" . $e->getTraceAsString() . "</pre>";
}
?>