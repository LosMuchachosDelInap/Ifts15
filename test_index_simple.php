<?php
// Página de prueba simplificada de index_fixed
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir BASE_URL
if (!defined('BASE_URL')) {
    $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    
    if (strpos($host, ':8000') !== false || strpos($host, ':8001') !== false) {
        $carpeta = '';
    } elseif ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, 'localhost:') === 0) {
        $carpeta = '/Mis_Proyectos/Ifts15';
    } else {
        $carpeta = '';
    }
    
    define('BASE_URL', $protocolo . $host . $carpeta);
}

$isLoggedIn = false;
$conn = null;
?>

<?php include __DIR__ . '/src/Template/head.php'; ?>
    
<?php include __DIR__ . '/src/Template/navBar.php'; ?>

<!-- Contenido Principal Simplificado -->
<main class="flex-fill">
    <div class="container py-5">
        <h1>Prueba Index Simplificado</h1>
        <p>Esta es una versión simplificada de index_fixed.php para probar el footer.</p>
        <p>El footer debería aparecer abajo ↓</p>
        
        <div style="height: 500px; background: #f8f9fa; border: 1px dashed #dee2e6; display: flex; align-items: center; justify-content: center;">
            <p>Contenido de relleno para que la página tenga altura</p>
        </div>
    </div>
</main>

<?php include __DIR__ . '/src/Template/footer.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous"></script>

</body>
</html>