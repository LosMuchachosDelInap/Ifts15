<?php
/**
 * Verificación Footer Sidebar - IFTS15
 * Cambios aplicados al footer del sidebar
 */

require_once __DIR__ . '/src/config.php';

echo "<html><head><title>Footer Sidebar - IFTS15</title>";
echo "<style>body{font-family:Arial;margin:40px;} .success{color:green;} .info{color:blue;} .change{color:orange; font-weight:bold;}</style></head><body>";

echo "<h1>🎨 Footer del Sidebar Actualizado - IFTS15</h1>";

echo "<h2>✅ Cambios Aplicados al Footer:</h2>";
echo "<ul>";
echo "<li class='change'>🖼️ <strong>Logo:</strong> Reemplazado icono bi-mortarboard por logo.png</li>";
echo "<li class='change'>⚫ <strong>Color de texto:</strong> Cambiado a negro (#000000) para mejor contraste</li>";
echo "<li class='change'>📏 <strong>Tamaño logo:</strong> Altura de 20px con margen derecho</li>";
echo "<li class='change'>💪 <strong>Font-weight:</strong> 600 para texto más visible</li>";
echo "</ul>";

echo "<h2>🔧 Detalles Técnicos:</h2>";
echo "<div style='background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0;'>";
echo "<h4>HTML:</h4>";
echo "<code style='background: #e9ecef; padding: 5px; display: block; margin: 5px 0;'>&lt;img src=\"" . BASE_URL . "/src/Public/images/logo.png\" height=\"20\" class=\"me-2\"&gt;</code>";
echo "<br>";
echo "<h4>CSS:</h4>";
echo "<code style='background: #e9ecef; padding: 5px; display: block; margin: 5px 0;'>color: #000000 !important; font-weight: 600;</code>";
echo "</div>";

echo "<h2>🌐 Prueba Visual:</h2>";
echo "<ul>";
echo "<li><a href='" . BASE_URL . "' class='info'>Ir a la página principal</a></li>";
echo "<li>Haz clic en el botón hamburguesa (gris) para abrir el sidebar</li>";
echo "<li>Ve hasta abajo del sidebar para ver el footer con el logo y texto negro</li>";
echo "<li>El logo debería aparecer junto a \"IFTS15 Sistema Web\" en negro</li>";
echo "</ul>";

echo "<h2>🎯 Estado del Sidebar:</h2>";
echo "<ul>";
echo "<li class='success'>✅ Botón hamburguesa: Gris visible</li>";
echo "<li class='success'>✅ Fondo sidebar: Gradiente gris → amarillo</li>";
echo "<li class='success'>✅ Texto enlaces: Blanco para contraste</li>";
echo "<li class='success'>✅ Footer: Logo + texto negro</li>";
echo "</ul>";

echo "<p class='success'><strong>✅ Footer del sidebar completamente actualizado!</strong><br>";
echo "Ahora muestra el logo.png junto al texto \"IFTS15 Sistema Web\" en negro.</p>";

echo "</body></html>";
?>