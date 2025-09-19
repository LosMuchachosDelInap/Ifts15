<?php
/**
 * Script para crear usuario de prueba
 */

require_once 'src/ConectionBD/CConnection.php';
require_once 'src/Model/Person.php';
require_once 'src/Model/User.php';

try {
    $dbConn = new ConectionDB();
    $conn = $dbConn->getConnection();
    
    echo "<h2>🧑‍💻 Crear Usuario de Prueba - IFTS15</h2>";
    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    // Verificar si ya existe el usuario
    $email_prueba = "prueba@gmail.com";
    $result = $conn->query("SELECT id_usuario FROM usuario WHERE email = '$email_prueba'");
    
    if ($result && $result->num_rows > 0) {
        echo "<p>⚠️ <strong>El usuario $email_prueba ya existe.</strong></p>";
        
        // Mostrar datos del usuario existente
        $user_data = $result->fetch_assoc();
        $id_usuario = $user_data['id_usuario'];
        
        $user_complete = $conn->query("SELECT u.*, p.nombre, p.apellido 
                                      FROM usuario u 
                                      LEFT JOIN persona p ON u.id_persona = p.id_persona 
                                      WHERE u.id_usuario = $id_usuario");
        
        if ($user_complete && $user_row = $user_complete->fetch_assoc()) {
            echo "<div style='background: #e3f2fd; padding: 15px; margin: 10px; border-radius: 5px;'>";
            echo "<h3>📋 Datos del usuario existente:</h3>";
            echo "<p><strong>Email:</strong> " . $user_row['email'] . "</p>";
            echo "<p><strong>Nombre:</strong> " . ($user_row['nombre'] ?? 'No definido') . " " . ($user_row['apellido'] ?? '') . "</p>";
            echo "<p><strong>ID Usuario:</strong> " . $user_row['id_usuario'] . "</p>";
            echo "<p><strong>ID Persona:</strong> " . $user_row['id_persona'] . "</p>";
            echo "<p><strong>Habilitado:</strong> " . ($user_row['habilitado'] ? 'Sí' : 'No') . "</p>";
            echo "</div>";
            
            echo "<div style='background: #fff3cd; padding: 15px; margin: 10px; border-radius: 5px;'>";
            echo "<h3>🔑 Credenciales para login:</h3>";
            echo "<p><strong>Email:</strong> prueba@gmail.com</p>";
            echo "<p><strong>Contraseña:</strong> 12345678</p>";
            echo "</div>";
        }
        
    } else {
        echo "<p>🆕 <strong>Creando nuevo usuario de prueba...</strong></p>";
        
        // Paso 1: Crear persona
        echo "<h3>1. Creando persona...</h3>";
        $persona = new Person("Juan", "Pérez", "12345678", "1122334455");
        
        if ($persona->guardar($conn)) {
            $id_persona = $persona->getId();
            echo "<p>✅ Persona creada con ID: $id_persona</p>";
            
            // Paso 2: Crear usuario
            echo "<h3>2. Creando usuario...</h3>";
            $usuario = new User($email_prueba, "12345678", $id_persona, 2); // role_id = 2
            
            if ($usuario->guardar($conn)) {
                echo "<p>✅ Usuario creado exitosamente!</p>";
                
                echo "<div style='background: #d4edda; padding: 15px; margin: 10px; border-radius: 5px;'>";
                echo "<h3>🎉 ¡Usuario de prueba creado!</h3>";
                echo "<p><strong>Email:</strong> prueba@gmail.com</p>";
                echo "<p><strong>Contraseña:</strong> 12345678</p>";
                echo "<p><strong>ID Usuario:</strong> " . $usuario->getId() . "</p>";
                echo "<p><strong>ID Persona:</strong> " . $id_persona . "</p>";
                echo "</div>";
                
                echo "<div style='background: #cce5ff; padding: 15px; margin: 10px; border-radius: 5px;'>";
                echo "<h3>🚀 Próximo paso:</h3>";
                echo "<p>Ve a la página principal e intenta hacer login con estas credenciales.</p>";
                echo "<p><a href='index_fixed.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Ir a la página principal</a></p>";
                echo "</div>";
                
            } else {
                echo "<p>❌ Error creando usuario</p>";
            }
        } else {
            echo "<p>❌ Error creando persona</p>";
        }
    }
    
    // Mostrar todos los usuarios existentes
    echo "<h3>📊 Todos los usuarios en la base de datos:</h3>";
    $all_users = $conn->query("SELECT u.id_usuario, u.email, u.habilitado, p.nombre, p.apellido 
                               FROM usuario u 
                               LEFT JOIN persona p ON u.id_persona = p.id_persona 
                               ORDER BY u.id_usuario");
    
    if ($all_users && $all_users->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Email</th><th>Nombre</th><th>Habilitado</th></tr>";
        
        while ($user = $all_users->fetch_assoc()) {
            $nombre_completo = trim(($user['nombre'] ?? '') . ' ' . ($user['apellido'] ?? ''));
            echo "<tr>";
            echo "<td>" . $user['id_usuario'] . "</td>";
            echo "<td>" . $user['email'] . "</td>";
            echo "<td>" . ($nombre_completo ?: 'Sin datos') . "</td>";
            echo "<td>" . ($user['habilitado'] ? '✅' : '❌') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay usuarios en la base de datos.</p>";
    }
    
} catch (Exception $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<p><strong>Stack Trace:</strong></p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>