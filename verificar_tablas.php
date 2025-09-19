<?php
/**
 * Script para verificar las tablas de la base de datos
 */

require_once 'src/ConectionBD/CConnection.php';

try {
    $dbConn = new ConectionDB();
    $conn = $dbConn->getConnection();
    
    echo "<h2>Verificación de Base de Datos - IFTS15</h2>";
    
    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    echo "<p><strong>✅ Conexión exitosa a la base de datos</strong></p>";
    
    // Listar todas las tablas
    $result = $conn->query("SHOW TABLES");
    
    if ($result) {
        echo "<h3>📋 Tablas existentes:</h3><ul>";
        while ($row = $result->fetch_array()) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
        
        // Verificar tablas específicas necesarias
        $tablasRequeridas = ['usuario', 'persona', 'roles'];
        
        echo "<h3>🔍 Verificación de tablas requeridas:</h3>";
        
        foreach ($tablasRequeridas as $tabla) {
            $result = $conn->query("SHOW TABLES LIKE '$tabla'");
            if ($result && $result->num_rows > 0) {
                echo "<p>✅ Tabla <strong>$tabla</strong> existe</p>";
                
                // Mostrar estructura de la tabla
                $estructura = $conn->query("DESCRIBE $tabla");
                echo "<details><summary>Ver estructura de $tabla</summary>";
                echo "<table border='1' style='border-collapse: collapse; margin: 10px;'>";
                echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por defecto</th><th>Extra</th></tr>";
                
                while ($campo = $estructura->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $campo['Field'] . "</td>";
                    echo "<td>" . $campo['Type'] . "</td>";
                    echo "<td>" . $campo['Null'] . "</td>";
                    echo "<td>" . $campo['Key'] . "</td>";
                    echo "<td>" . $campo['Default'] . "</td>";
                    echo "<td>" . $campo['Extra'] . "</td>";
                    echo "</tr>";
                }
                echo "</table></details>";
                
            } else {
                echo "<p>❌ Tabla <strong>$tabla</strong> NO existe</p>";
            }
        }
        
        // Verificar si hay usuarios en la tabla usuario
        $result = $conn->query("SELECT COUNT(*) as total FROM usuario WHERE 1");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p><strong>👥 Total de usuarios en la tabla:</strong> " . $row['total'] . "</p>";
            
            if ($row['total'] > 0) {
                echo "<h4>📝 Usuarios existentes:</h4>";
                $usuarios = $conn->query("SELECT id_usuario, email, is_active, created_at FROM usuario LIMIT 5");
                echo "<table border='1' style='border-collapse: collapse;'>";
                echo "<tr><th>ID</th><th>Email</th><th>Activo</th><th>Creado</th></tr>";
                while ($user = $usuarios->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $user['id_usuario'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td>" . ($user['is_active'] ? 'Sí' : 'No') . "</td>";
                    echo "<td>" . $user['created_at'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        
    } else {
        echo "<p>❌ Error al obtener tablas: " . $conn->error . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p><strong>❌ Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>📍 Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>📍 Línea:</strong> " . $e->getLine() . "</p>";
}
?>