<?php
/**
 * Test específico de conexión a base de datos
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test de Conexión a Base de Datos</h1>";

// Credenciales
$host = 'sql103.infinityfree.com';  // ⚠️ NOTA: Puede ser diferente
$dbname = 'if0_39904770_ifts15';
$username = 'if0_39904770';
$password = 'pNPtg1sJhqrygS';

echo "<p><strong>Host:</strong> $host</p>";
echo "<p><strong>DB Name:</strong> $dbname</p>";
echo "<p><strong>Username:</strong> $username</p>";
echo "<p><strong>Password:</strong> " . str_repeat('*', strlen($password)) . "</p>";

// Test conexión MySQLi directa
echo "<h2>Test MySQLi Directo</h2>";
try {
    $connection = new mysqli($host, $username, $password, $dbname);
    
    if ($connection->connect_error) {
        echo "<p>❌ <strong>Error MySQLi:</strong> " . $connection->connect_error . "</p>";
        echo "<p><strong>Error Number:</strong> " . $connection->connect_errno . "</p>";
        
        // Errores comunes
        if ($connection->connect_errno == 1045) {
            echo "<p>🔍 <strong>Posible causa:</strong> Usuario/contraseña incorrectos</p>";
        } elseif ($connection->connect_errno == 2002) {
            echo "<p>🔍 <strong>Posible causa:</strong> Host incorrecto</p>";
        } elseif ($connection->connect_errno == 1049) {
            echo "<p>🔍 <strong>Posible causa:</strong> Base de datos no existe</p>";
        }
    } else {
        echo "<p>✅ <strong>Conexión exitosa!</strong></p>";
        echo "<p><strong>Servidor:</strong> " . $connection->server_info . "</p>";
        echo "<p><strong>Protocolo:</strong> " . $connection->protocol_version . "</p>";
        
        // Test query simple
        $result = $connection->query("SELECT 1 as test");
        if ($result) {
            echo "<p>✅ <strong>Query de prueba exitosa</strong></p>";
        } else {
            echo "<p>❌ <strong>Error en query:</strong> " . $connection->error . "</p>";
        }
        
        $connection->close();
    }
} catch (Exception $e) {
    echo "<p>❌ <strong>Excepción:</strong> " . $e->getMessage() . "</p>";
}

// Test con diferentes hosts posibles
echo "<h2>Test de Hosts Alternativos</h2>";
$possible_hosts = [
    'sql103.infinityfree.com',
    'sql203.infinityfree.com',
    'sql303.infinityfree.com',
    '103sql.infinityfree.com'  // Tu configuración actual
];

foreach ($possible_hosts as $test_host) {
    echo "<p><strong>Probando:</strong> $test_host... ";
    try {
        $test_conn = new mysqli($test_host, $username, $password, $dbname);
        if ($test_conn->connect_error) {
            echo "❌ Error: " . $test_conn->connect_errno;
        } else {
            echo "✅ <strong>FUNCIONA!</strong>";
            $test_conn->close();
        }
    } catch (Exception $e) {
        echo "❌ Excepción: " . $e->getMessage();
    }
    echo "</p>";
}
?>