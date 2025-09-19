<?php
/**
 * Script para mostrar la estructura actual de las tablas y corregirlas
 */

require_once 'src/ConectionBD/CConnection.php';

try {
    $dbConn = new ConectionDB();
    $conn = $dbConn->getConnection();
    
    echo "<h2>🔧 Corrección de Estructura de Base de Datos - IFTS15</h2>";
    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    echo "<h3>📋 Estructura actual de la tabla 'usuario':</h3>";
    
    // Mostrar estructura actual
    $resultado = $conn->query("DESCRIBE usuario");
    if ($resultado) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por defecto</th><th>Extra</th></tr>";
        
        $columnas_existentes = [];
        while ($campo = $resultado->fetch_assoc()) {
            $columnas_existentes[] = $campo['Field'];
            echo "<tr>";
            echo "<td><strong>" . $campo['Field'] . "</strong></td>";
            echo "<td>" . $campo['Type'] . "</td>";
            echo "<td>" . $campo['Null'] . "</td>";
            echo "<td>" . $campo['Key'] . "</td>";
            echo "<td>" . $campo['Default'] . "</td>";
            echo "<td>" . $campo['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h3>🔍 Verificando columnas necesarias:</h3>";
        
        // Columnas que necesitamos
        $columnas_requeridas = [
            'is_active' => "TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Usuario activo'",
            'created_at' => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación'",
            'updated_at' => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de actualización'",
            'last_login' => "TIMESTAMP NULL DEFAULT NULL COMMENT 'Último login'"
        ];
        
        $columnas_a_agregar = [];
        
        foreach ($columnas_requeridas as $columna => $definicion) {
            if (in_array($columna, $columnas_existentes)) {
                echo "<p>✅ Columna <strong>$columna</strong> ya existe</p>";
            } else {
                echo "<p>❌ Falta columna <strong>$columna</strong></p>";
                $columnas_a_agregar[$columna] = $definicion;
            }
        }
        
        if (!empty($columnas_a_agregar)) {
            echo "<h3>🛠️ SQL para agregar columnas faltantes:</h3>";
            echo "<div style='background: #f0f0f0; padding: 15px; margin: 10px; border-radius: 5px;'>";
            
            foreach ($columnas_a_agregar as $columna => $definicion) {
                $sql = "ALTER TABLE usuario ADD COLUMN $columna $definicion;";
                echo "<p><strong>$columna:</strong></p>";
                echo "<code>$sql</code><br><br>";
            }
            echo "</div>";
            
            // Ofrecer ejecutar automáticamente
            if (isset($_GET['ejecutar']) && $_GET['ejecutar'] === 'si') {
                echo "<h3>⚡ Ejecutando correcciones...</h3>";
                
                foreach ($columnas_a_agregar as $columna => $definicion) {
                    $sql = "ALTER TABLE usuario ADD COLUMN $columna $definicion";
                    
                    if ($conn->query($sql)) {
                        echo "<p>✅ Columna <strong>$columna</strong> agregada exitosamente</p>";
                    } else {
                        echo "<p>❌ Error agregando <strong>$columna</strong>: " . $conn->error . "</p>";
                    }
                }
                
                echo "<p><strong>🔄 <a href='corregir_tabla_usuario.php'>Actualizar página para ver cambios</a></strong></p>";
                
            } else {
                echo "<p><strong>⚠️ <a href='corregir_tabla_usuario.php?ejecutar=si' onclick='return confirm(\"¿Estás seguro de que quieres modificar la tabla usuario?\")'>CLICK AQUÍ PARA EJECUTAR LAS CORRECCIONES</a></strong></p>";
            }
        } else {
            echo "<p><strong>🎉 ¡Todas las columnas necesarias ya existen!</strong></p>";
        }
        
        // Verificar también la tabla roles
        echo "<h3>📋 Estructura de la tabla 'roles':</h3>";
        $resultado_roles = $conn->query("DESCRIBE roles");
        if ($resultado_roles) {
            echo "<table border='1' style='border-collapse: collapse; margin: 10px;'>";
            echo "<tr><th>Campo</th><th>Tipo</th></tr>";
            
            while ($campo = $resultado_roles->fetch_assoc()) {
                echo "<tr><td><strong>" . $campo['Field'] . "</strong></td><td>" . $campo['Type'] . "</td></tr>";
            }
            echo "</table>";
            
            // Verificar si hay datos en roles
            $count_roles = $conn->query("SELECT COUNT(*) as total FROM roles");
            if ($count_roles) {
                $total = $count_roles->fetch_assoc()['total'];
                echo "<p><strong>📊 Total de roles:</strong> $total</p>";
                
                if ($total == 0) {
                    echo "<p>⚠️ <strong>La tabla roles está vacía. Necesitas insertar roles básicos.</strong></p>";
                    echo "<div style='background: #fff3cd; padding: 10px; margin: 10px; border-radius: 5px;'>";
                    echo "<h4>SQL para insertar roles básicos:</h4>";
                    echo "<code>INSERT INTO roles (nombre) VALUES ('admin'), ('usuario');</code>";
                    echo "</div>";
                }
            }
        }
        
    } else {
        echo "<p>❌ Error al obtener estructura: " . $conn->error . "</p>";
    }
    
} catch (Exception $e) {
    echo "<h3>❌ Error:</h3>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
}
?>