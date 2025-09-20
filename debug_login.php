<?php
/**
 * Debug Login Específico - IFTS15
 * Script para diagnosticar problemas de credenciales
 */

require_once __DIR__ . '/src/config.php';

use App\ConectionBD\ConectionDB;
use App\Model\User;

echo "<h2>🔍 Debug de Credenciales de Login</h2>\n";

try {
    $conectarDB = new ConectionDB();
    $conn = $conectarDB->getConnection();
    
    // Mostrar usuarios existentes
    echo "<h3>👥 Usuarios en Base de Datos:</h3>\n";
    $query = "SELECT id_usuario, email, clave, habilitado, cancelado, id_rol FROM usuario";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        echo "<table border='1' cellpadding='8' style='border-collapse: collapse; margin: 10px 0;'>\n";
        echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Email</th><th>Hash (primeros 30 chars)</th><th>Habilitado</th><th>Cancelado</th><th>Rol</th></tr>\n";
        
        while ($row = $result->fetch_assoc()) {
            $color = $row['habilitado'] && !$row['cancelado'] ? '#e8f5e8' : '#ffe8e8';
            echo "<tr style='background: {$color};'>\n";
            echo "<td>{$row['id_usuario']}</td>\n";
            echo "<td><strong>{$row['email']}</strong></td>\n";
            echo "<td><code>" . substr($row['clave'], 0, 30) . "...</code></td>\n";
            echo "<td>" . ($row['habilitado'] ? '✅ Sí' : '❌ No') . "</td>\n";
            echo "<td>" . ($row['cancelado'] ? '❌ Sí' : '✅ No') . "</td>\n";
            echo "<td>{$row['id_rol']}</td>\n";
            echo "</tr>\n";
        }
        echo "</table>\n";
    } else {
        echo "<p style='color: red; font-size: 18px;'>❌ No hay usuarios en la base de datos</p>\n";
    }
    
    // Test de autenticación con usuario existente
    echo "<h3>🔑 Test de Autenticación:</h3>\n";
    
    $email_test = 'prueba@gmail.com';
    $passwords_to_test = ['123456', 'password', 'admin', 'test', '12345678', 'prueba', 'prueba123'];
    
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<p><strong>Probando con email:</strong> <code>{$email_test}</code></p>\n";
    echo "<p><strong>Contraseñas a probar:</strong></p>\n";
    echo "<ul>\n";
    foreach ($passwords_to_test as $pwd) {
        echo "<li><code>{$pwd}</code></li>\n";
    }
    echo "</ul>\n";
    echo "</div>\n";
    
    // Buscar usuario por email primero
    $user_debug = User::buscarPorEmail($conn, $email_test);
    if (!$user_debug) {
        echo "<p style='color: red; font-size: 16px;'>❌ Usuario no encontrado con email: <code>{$email_test}</code></p>\n";
        echo "<p>¿Has registrado un usuario con este email?</p>\n";
    } else {
        echo "<p style='color: green;'>✅ Usuario encontrado en la base de datos</p>\n";
        
        // Probar cada contraseña
        echo "<h4>Probando contraseñas:</h4>\n";
        $encontrada = false;
        
        foreach ($passwords_to_test as $password_test) {
            $user = User::autenticar($conn, $email_test, $password_test);
            
            if ($user) {
                echo "<p style='color: green; font-size: 16px; font-weight: bold;'>✅ ÉXITO con contraseña: <code>{$password_test}</code></p>\n";
                $encontrada = true;
                break;
            } else {
                echo "<p style='color: red;'>❌ Falló con: <code>{$password_test}</code></p>\n";
            }
        }
        
        if (!$encontrada) {
            echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #ffc107;'>\n";
            echo "<h4>⚠️ Ninguna contraseña funcionó</h4>\n";
            echo "<p>Posibles causas:</p>\n";
            echo "<ul>\n";
            echo "<li>La contraseña real es diferente a las que probé</li>\n";
            echo "<li>El hash en la base de datos está corrupto</li>\n";
            echo "<li>Problema con la función de verificación de contraseña</li>\n";
            echo "</ul>\n";
            echo "</div>\n";
        }
    }
    
    // Información para crear nuevo usuario
    echo "<h3>🆕 Crear Nuevo Usuario de Prueba</h3>\n";
    echo "<div style='background: #e8f4fd; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<p><strong>Si quieres crear un nuevo usuario con credenciales conocidas:</strong></p>\n";
    echo "<ol>\n";
    echo "<li>Ve a: <a href='register.php'>Registro</a></li>\n";
    echo "<li>Usa estas credenciales de prueba:\n";
    echo "<ul>\n";
    echo "<li>Email: <code>test@test.com</code></li>\n";
    echo "<li>Contraseña: <code>123456</code></li>\n";
    echo "<li>Completa el resto de los campos</li>\n";
    echo "</ul></li>\n";
    echo "<li>Después prueba hacer login con esas credenciales</li>\n";
    echo "</ol>\n";
    echo "</div>\n";
    
} catch (Exception $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px; border-radius: 5px;'>\n";
    echo "<h3>❌ Error:</h3>\n";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>\n";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>\n";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>\n";
    echo "</div>\n";
}
?>