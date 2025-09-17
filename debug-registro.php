<?php
require_once 'includes/init.php';

echo "<h2>🔧 Debug del Sistema de Registro</h2>";

try {
    $db = Database::getInstance();
    echo "<p style='color: green;'>✅ Conexión a BD: OK</p>";
    
    // Verificar tablas
    $tables = ['persona', 'usuario', 'roles', 'carrera', 'comision', 'añocursada'];
    
    foreach ($tables as $table) {
        $count = $db->fetchOne("SELECT COUNT(*) as total FROM $table");
        echo "<p><strong>$table:</strong> {$count['total']} registros</p>";
    }
    
    echo "<hr>";
    
    // Simular datos de registro
    $test_data = [
        'nombre' => 'Juan',
        'apellido' => 'Pérez', 
        'dni' => '12345678',
        'telefono' => '1234567890',
        'edad' => 25,
        'email' => 'test@test.com',
        'password' => 'test123'
    ];
    
    echo "<h3>🧪 Simulación de Registro</h3>";
    
    // Verificar si existe rol Alumno
    $rol_alumno = $db->fetchOne("SELECT id_rol FROM roles WHERE rol = 'Alumno' AND habilitado = 1");
    if ($rol_alumno) {
        echo "<p style='color: green;'>✅ Rol Alumno encontrado: ID {$rol_alumno['id_rol']}</p>";
    } else {
        echo "<p style='color: red;'>❌ Rol Alumno NO encontrado</p>";
        
        // Mostrar roles disponibles
        $roles = $db->fetchAll("SELECT * FROM roles");
        echo "<p><strong>Roles disponibles:</strong></p><ul>";
        foreach ($roles as $rol) {
            echo "<li>ID: {$rol['id_rol']}, Rol: {$rol['rol']}, Habilitado: {$rol['habilitado']}</li>";
        }
        echo "</ul>";
    }
    
    // Verificar si el email ya existe
    $existing = $db->fetchOne("SELECT id_usuario FROM usuario WHERE email = ?", [$test_data['email']]);
    if ($existing) {
        echo "<p style='color: orange;'>⚠️ Email de prueba ya existe, saltando inserción</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ Email de prueba disponible</p>";
        
        // Intentar inserción de prueba
        if ($rol_alumno) {
            echo "<h4>📝 Intentando inserción de prueba...</h4>";
            
            // Obtener valores por defecto para claves foráneas
            $carrera_default = $db->fetchOne("SELECT id_carrera FROM carrera LIMIT 1");
            $comision_default = $db->fetchOne("SELECT id_comision FROM comision LIMIT 1");
            $anio_default = $db->fetchOne("SELECT id_añoCursada FROM añocursada LIMIT 1");
            
            try {
                $db->beginTransaction();
                
                // 1. Insertar persona
                $db->query("
                    INSERT INTO persona (apellido, nombre, dni, telefono, edad) 
                    VALUES (?, ?, ?, ?, ?)
                ", [$test_data['apellido'], $test_data['nombre'], $test_data['dni'], $test_data['telefono'], $test_data['edad']]);
                
                $persona_id = $db->lastInsertId();
                echo "<p style='color: green;'>✅ Persona insertada con ID: $persona_id</p>";
                
                // 2. Insertar usuario - usando password_hash seguro
                $hashedPassword = password_hash($test_data['password'], PASSWORD_DEFAULT);
                $db->query("
                    INSERT INTO usuario (email, clave, id_persona, id_rol, id_carrera, id_comision, id_añoCursada, habilitado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 1)
                ", [
                    $test_data['email'], 
                    $hashedPassword, 
                    $persona_id, 
                    $rol_alumno['id_rol'],
                    $carrera_default['id_carrera'],
                    $comision_default['id_comision'],
                    $anio_default['id_añoCursada']
                ]);
                
                $user_id = $db->lastInsertId();
                echo "<p style='color: green;'>✅ Usuario insertado con ID: $user_id</p>";
                
                $db->commit();
                echo "<p style='color: green;'><strong>✅ REGISTRO DE PRUEBA EXITOSO</strong></p>";
                
            } catch (Exception $e) {
                $db->rollback();
                echo "<p style='color: red;'>❌ Error en inserción: " . $e->getMessage() . "</p>";
            }
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='register.php'>[Volver al registro]</a> | <a href='index.php'>[Inicio]</a></p>";
?>