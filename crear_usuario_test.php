<?php
/**
 * Crear Usuario de Prueba - IFTS15
 * Script para crear un usuario con credenciales conocidas
 */

require_once __DIR__ . '/src/config.php';

use App\ConectionBD\ConectionDB;
use App\Model\User;
use App\Model\Person;

try {
    $conectarDB = new ConectionDB();
    $conn = $conectarDB->getConnection();
    
    echo "<h2>🔧 Crear Usuario de Prueba</h2>\n";
    
    // Verificar si ya existe
    $email_test = 'admin@test.com';
    $existing = User::buscarPorEmail($conn, $email_test);
    
    if ($existing) {
        echo "<p style='color: orange;'>⚠️ Usuario ya existe con email: <code>{$email_test}</code></p>\n";
        echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
        echo "<p><strong>Credenciales para usar:</strong></p>\n";
        echo "<p>Email: <code>{$email_test}</code></p>\n";
        echo "<p>Contraseña: <code>123456</code></p>\n";
        echo "</div>\n";
    } else {
        echo "<p>Creando nuevo usuario de prueba...</p>\n";
        
        // Iniciar transacción
        $conn->begin_transaction();
        
        // 1. Crear persona
        $persona = new Person(
            'Admin',           // nombre
            'Test',           // apellido
            '1990-01-01',     // fecha_nacimiento
            '12345678',       // dni
            '11-1234-5678',   // telefono
            null,             // direccion
            null,             // localidad
            null,             // provincia
            34                // edad
        );
        
        if ($persona->guardar($conn)) {
            echo "<p style='color: green;'>✅ Persona creada con ID: " . $persona->getId() . "</p>\n";
            
            // 2. Crear usuario
            $user = new User(
                $email_test,      // email
                '123456',         // password (será hasheada automáticamente)
                $persona->getId(), // id_persona
                1,                // role_id (1 = admin)
                1,                // id_carrera
                1,                // id_comision
                1                 // id_añoCursada
            );
            
            if ($user->guardar($conn)) {
                echo "<p style='color: green;'>✅ Usuario creado exitosamente</p>\n";
                
                // Confirmar transacción
                $conn->commit();
                
                echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #28a745;'>\n";
                echo "<h3>✅ Usuario de Prueba Creado</h3>\n";
                echo "<p><strong>Ahora puedes hacer login con:</strong></p>\n";
                echo "<p>Email: <code>{$email_test}</code></p>\n";
                echo "<p>Contraseña: <code>123456</code></p>\n";
                echo "<p><a href='login.php' style='background: #007bff; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;'>Ir a Login</a></p>\n";
                echo "</div>\n";
                
            } else {
                throw new Exception("Error creando usuario");
            }
        } else {
            throw new Exception("Error creando persona");
        }
    }
    
    // Test de autenticación
    echo "<h3>🔑 Verificando Autenticación</h3>\n";
    $user_auth = User::autenticar($conn, $email_test, '123456');
    
    if ($user_auth) {
        echo "<p style='color: green; font-weight: bold;'>✅ Login funciona correctamente</p>\n";
        echo "<p>Usuario autenticado: {$user_auth->getEmail()}</p>\n";
    } else {
        echo "<p style='color: red;'>❌ El login no está funcionando</p>\n";
    }
    
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollback();
    }
    echo "<div style='color: red; background: #f8d7da; padding: 15px; border-radius: 5px;'>\n";
    echo "<h3>❌ Error:</h3>\n";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>\n";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>\n";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>\n";
    echo "</div>\n";
}
?>