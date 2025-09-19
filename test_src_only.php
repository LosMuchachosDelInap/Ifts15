<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Footer Solo SRC</title>
    
    <!-- Bootstrap 5.3.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
          crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Font Awesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
          crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- CSS de src/ -->
    <link rel="stylesheet" href="src/Css/styles.css">
    <link rel="stylesheet" href="src/Css/footerCss.css">
    <link rel="stylesheet" href="src/Css/consultasCss.css">
</head>
<body class="d-flex flex-column min-vh-100">

<main class="flex-fill">
    <div class="container py-5">
        <h1 style="color: #FFD700;">🔧 Test Footer - Solo archivos SRC</h1>
        <p>Esta página usa únicamente archivos de la carpeta <code>src/</code></p>
        <p><strong>El footer debería aparecer abajo con:</strong></p>
        <ul>
            <li>✅ Fondo oscuro</li>
            <li>✅ Texto blanco</li>
            <li>✅ Enlaces funcionales</li>
            <li>✅ <span style="color: #FFD700;">📧 Contacto (Modal)</span> - debe abrir el modal de consultas</li>
        </ul>
        
        <div style="height: 400px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 2px dashed #FFD700; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
            <div style="text-align: center;">
                <h3 style="color: #343a40;">📄 Contenido de prueba</h3>
                <p style="color: #6c757d;">Espacio de relleno para verificar el layout</p>
            </div>
        </div>
        
        <div class="mt-4 p-3" style="background: #fff3cd; border-radius: 8px; border-left: 4px solid #FFD700;">
            <strong>📋 Instrucciones de prueba:</strong><br>
            1. Hacer scroll hasta abajo<br>
            2. Verificar que el footer sea visible<br>
            3. Clickear en "📧 Contacto (Modal)" para probar el modal de consultas
        </div>
    </div>
</main>

<?php 
define('BASE_URL', 'http://localhost:8001');
include __DIR__ . '/src/Template/footer.php'; 
?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous"></script>

</body>
</html>