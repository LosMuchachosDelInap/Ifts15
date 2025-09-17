<?php
require_once 'includes/init.php';

echo "<h2>🔍 Verificación de Estructura de Tablas</h2>";

try {
    $db = Database::getInstance();
    
    $tablas = ['persona', 'usuario'];
    
    foreach ($tablas as $tabla) {
        echo "<h3>Tabla: $tabla</h3>";
        $estructura = $db->fetchAll("DESCRIBE $tabla");
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th><th>Extra</th></tr>";
        foreach ($estructura as $campo) {
            echo "<tr>";
            echo "<td>" . $campo['Field'] . "</td>";
            echo "<td>" . $campo['Type'] . "</td>";
            echo "<td>" . $campo['Null'] . "</td>";
            echo "<td>" . $campo['Key'] . "</td>";
            echo "<td>" . ($campo['Default'] ?? 'NULL') . "</td>";
            echo "<td>" . ($campo['Extra'] ?? '') . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>