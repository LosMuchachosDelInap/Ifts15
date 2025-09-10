<?php
/**
 * Optimizador de Imágenes para InfinityFree
 * Archivo: optimize-images.php
 * Ejecuta este script para verificar y optimizar imágenes antes de subir
 */

echo "<!DOCTYPE html>";
echo "<html><head><title>Optimización de Imágenes</title>";
echo "<style>body{font-family:Arial;margin:20px;} .ok{color:green;} .warning{color:orange;} .info{color:blue;}</style>";
echo "</head><body>";

echo "<h1>🖼️ Optimización de Imágenes IFTS15</h1>";

$imagen_dir = 'assets/images/';
$max_size = 500 * 1024; // 500KB
$recommended_width = 1200; // pixels

if (!is_dir($imagen_dir)) {
    echo "<p class='error'>❌ Directorio de imágenes no encontrado</p>";
    exit;
}

$archivos = glob($imagen_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

echo "<h2>📊 Análisis de Imágenes</h2>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Archivo</th><th>Tamaño</th><th>Dimensiones</th><th>Estado</th><th>Recomendación</th></tr>";

foreach ($archivos as $archivo) {
    $nombre = basename($archivo);
    $size = filesize($archivo);
    $size_kb = round($size / 1024, 2);
    
    // Obtener dimensiones
    $info = @getimagesize($archivo);
    $width = $info ? $info[0] : 'N/A';
    $height = $info ? $info[1] : 'N/A';
    $dimensions = $width . 'x' . $height;
    
    // Determinar estado
    $estado = "";
    $recomendacion = "";
    
    if ($size > $max_size) {
        $estado = "<span class='warning'>⚠️ Grande</span>";
        $recomendacion = "Comprimir imagen";
    } elseif ($width > $recommended_width) {
        $estado = "<span class='warning'>⚠️ Muy ancha</span>";
        $recomendacion = "Redimensionar a " . $recommended_width . "px";
    } else {
        $estado = "<span class='ok'>✅ OK</span>";
        $recomendacion = "Ninguna";
    }
    
    echo "<tr>";
    echo "<td>$nombre</td>";
    echo "<td>${size_kb} KB</td>";
    echo "<td>$dimensions</td>";
    echo "<td>$estado</td>";
    echo "<td>$recomendacion</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>💡 Consejos de Optimización</h2>";
echo "<ul>";
echo "<li><strong>Tamaño recomendado:</strong> Máximo 500KB por imagen</li>";
echo "<li><strong>Ancho recomendado:</strong> Máximo 1200px para web</li>";
echo "<li><strong>Formato recomendado:</strong> JPG para fotos, PNG para logos</li>";
echo "<li><strong>Herramientas online:</strong> TinyPNG, Squoosh, ImageOptim</li>";
echo "</ul>";

echo "<h2>🔧 URLs de las Imágenes</h2>";
include_once 'config/config.php';
echo "<p><strong>SITE_URL actual:</strong> " . SITE_URL . "</p>";
echo "<ul>";
foreach ($archivos as $archivo) {
    $nombre = basename($archivo);
    $url = SITE_URL . '/assets/images/' . $nombre;
    echo "<li><a href='$url' target='_blank'>$nombre</a></li>";
}
echo "</ul>";

echo "<h2>🧪 Test de Carrusel</h2>";
echo "<div style='max-width: 600px;'>";
echo "<div id='testCarousel' class='carousel slide' data-bs-ride='carousel'>";
echo "<div class='carousel-inner'>";

$primera = true;
// Solo usar las 3 imágenes del carrusel que tienes
$imagenes_carrusel = ['carrussel_1.png', 'carrussel_2.png', 'carrussel_3.png'];
foreach ($imagenes_carrusel as $img) {
    $active = $primera ? 'active' : '';
    if (file_exists($imagen_dir . $img)) {
        echo "<div class='carousel-item $active'>";
        echo "<img src='" . SITE_URL . "/assets/images/$img' class='d-block w-100' alt='Test' style='height:200px;object-fit:cover;'>";
        echo "</div>";
        $primera = false;
    } else {
        echo "<p class='error'>❌ Imagen no encontrada: $img</p>";
    }
}

echo "</div>";
echo "<button class='carousel-control-prev' type='button' data-bs-target='#testCarousel' data-bs-slide='prev'>";
echo "<span class='carousel-control-prev-icon'></span>";
echo "</button>";
echo "<button class='carousel-control-next' type='button' data-bs-target='#testCarousel' data-bs-slide='next'>";
echo "<span class='carousel-control-next-icon'></span>";
echo "</button>";
echo "</div>";
echo "</div>";

echo "<h2>🖼️ Test del Logo</h2>";
if (file_exists($imagen_dir . 'logo.png')) {
    echo "<div style='text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;'>";
    echo "<img src='" . SITE_URL . "/assets/images/logo.png' alt='Logo IFTS15' style='max-height: 150px; width: auto;'>";
    echo "<p><strong>Logo cargado correctamente</strong></p>";
    echo "</div>";
} else {
    echo "<p class='error'>❌ Logo no encontrado: logo.png</p>";
}

// Cargar Bootstrap para el test
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>";

echo "<hr>";
echo "<p><a href='index.php'>← Volver al sitio</a> | <a href='verify-system.php'>Verificar sistema</a></p>";

echo "</body></html>";
?>
