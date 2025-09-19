<?php
/**
 * Script para corregir usuario de prueba con contraseña hasheada
 */

require_once 'src/ConectionBD/CConnection.php';

try {
    $dbConn = new ConectionDB();
    $conn = $dbConn->getConnection();
    
    echo "<h2>🔧 Corregir Usuario de Prueba - IFTS15</h2>";
    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    $email_prueba = "prueba@gmail.com";
    $password_prueba = "12345678";
    
    // Verificar usuario existente
    $result = $conn->query("SELECT * FROM usuario WHERE email = '$email_prueba'");
    
    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        
        echo "<h3>👤 Usuario existente encontrado:</h3>";
        echo "<p><strong>ID:</strong> " . $user_data['id_usuario'] . "</p>";
        echo "<p><strong>Email:</strong> " . $user_data['email'] . "</p>";
        echo "<p><strong>Hash actual:</strong> " . substr($user_data['clave'], 0, 30) . "...</p>";
        echo "<p><strong>Habilitado:</strong> " . ($user_data['habilitado'] ? 'Sí' : 'No') . "</p>";
        
        // Verificar si la contraseña actual funciona
        echo "<h3>🔍 Probando contraseña actual...</h3>";
        if (password_verify($password_prueba, $user_data['clave'])) {
            echo "<p>✅ La contraseña actual YA funciona correctamente</p>";
        } else {
            echo "<p>❌ La contraseña actual NO funciona</p>";
            
            if (isset($_GET['corregir']) && $_GET['corregir'] === 'si') {
                echo "<h3>🛠️ Corrigiendo hash de contraseña...</h3>";
                
                // Crear nuevo hash
                $nuevo_hash = password_hash($password_prueba, PASSWORD_DEFAULT);
                
                $stmt = $conn->prepare("UPDATE usuario SET clave = ? WHERE id_usuario = ?");
                $stmt->bind_param("si", $nuevo_hash, $user_data['id_usuario']);
                
                if ($stmt->execute()) {
                    echo "<p>✅ Hash de contraseña actualizado correctamente</p>";
                    echo "<p><strong>Nuevo hash:</strong> " . substr($nuevo_hash, 0, 30) . "...</p>";
                    
                    // Verificar que funciona
                    if (password_verify($password_prueba, $nuevo_hash)) {
                        echo "<p>✅ Verificación exitosa del nuevo hash</p>";
                    } else {
                        echo "<p>❌ Error: El nuevo hash no funciona</p>";
                    }
                } else {
                    echo "<p>❌ Error actualizando hash: " . $conn->error . "</p>";
                }
                
            } else {
                echo "<p><strong>⚡ <a href='corregir_usuario.php?corregir=si'>CLICK AQUÍ PARA CORREGIR EL HASH</a></strong></p>";
            }
        }
        
    } else {
        echo "<h3>🆕 Usuario no existe, creando nuevo...</h3>";
        
        // Crear persona primero
        $persona_result = $conn->query("SELECT MAX(id_persona) as max_id FROM persona");
        $max_id = 0;
        if ($persona_result && $row = $persona_result->fetch_assoc()) {
            $max_id = (int)$row['max_id'];
        }
        
        $nuevo_id_persona = $max_id + 1;
        
        echo "<p>Creando persona con ID: $nuevo_id_persona</p>";
        
        $stmt_persona = $conn->prepare("INSERT INTO persona (id_persona, nombre, apellido, edad, dni, telefono) VALUES (?, 'Juan', 'Pérez', '25', '12345678', '1122334455')");
        $stmt_persona->bind_param("i", $nuevo_id_persona);
        
        if ($stmt_persona->execute()) {
            echo "<p>✅ Persona creada</p>";
            
            // Crear usuario
            $hash_password = password_hash($password_prueba, PASSWORD_DEFAULT);
            
            $stmt_user = $conn->prepare("INSERT INTO usuario (email, clave, id_persona, habilitado) VALUES (?, ?, ?, 1)");
            $stmt_user->bind_param("ssi", $email_prueba, $hash_password, $nuevo_id_persona);
            
            if ($stmt_user->execute()) {
                echo "<p>✅ Usuario creado exitosamente</p>";
                echo "<p><strong>Hash creado:</strong> " . substr($hash_password, 0, 30) . "...</p>";
            } else {
                echo "<p>❌ Error creando usuario: " . $conn->error . "</p>";
            }
            
        } else {
            echo "<p>❌ Error creando persona: " . $conn->error . "</p>";
        }
    }
    
    echo "<h3>🧪 Prueba final de autenticación:</h3>";
    
    // Probar login completo
    $test_result = $conn->query("SELECT * FROM usuario WHERE email = '$email_prueba' AND habilitado = 1");
    
    if ($test_result && $user = $test_result->fetch_assoc()) {
        if (password_verify($password_prueba, $user['clave'])) {
            echo "<div style='background: #d4edda; padding: 15px; margin: 10px; border-radius: 5px;'>";
            echo "<h4>🎉 ¡PRUEBA EXITOSA!</h4>";
            echo "<p><strong>Email:</strong> $email_prueba</p>";
            echo "<p><strong>Contraseña:</strong> $password_prueba</p>";
            echo "<p>El usuario está listo para hacer login.</p>";
            echo "<p><a href='index_fixed.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Probar Login Ahora</a></p>";
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; padding: 15px; margin: 10px; border-radius: 5px;'>";
            echo "<h4>❌ Prueba Fallida</h4>";
            echo "<p>La contraseña aún no funciona correctamente.</p>";
            echo "</div>";
        }
    } else {
        echo "<div style='background: #fff3cd; padding: 15px; margin: 10px; border-radius: 5px;'>";
        echo "<h4>⚠️ Usuario no encontrado</h4>";
        echo "<p>No se pudo encontrar el usuario para la prueba.</p>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
}
?>