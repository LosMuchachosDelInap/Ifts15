<!DOCTYPE html>
<html>
<head>
    <title>Test Formulario Login - IFTS15</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .form-section { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test de Formulario Login - IFTS15</h1>
        
        <?php
        // Definir BASE_URL
        if (!defined('BASE_URL')) {
            $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            
            // Para servidor PHP built-in (localhost:8000), no agregar carpeta adicional
            if (strpos($host, ':8000') !== false) {
                $carpeta = '';
            } elseif ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, 'localhost:') === 0) {
                $carpeta = '/Mis_Proyectos/Ifts15';
            } else {
                $carpeta = '';
            }
            
            define('BASE_URL', $protocolo . $host . $carpeta);
        }
        
        echo "<p><strong>BASE_URL configurada:</strong> <code>" . BASE_URL . "</code></p>";
        ?>
        
        <div class="form-section">
            <h2>🔐 Formulario de Login (Idéntico al modal)</h2>
            <p>Este formulario es exactamente igual al del modal de login:</p>
            
            <form action="<?php echo BASE_URL; ?>/src/Controllers/AuthController.php" method="POST">
                <input type="hidden" name="action" value="login">
                
                <div style="margin-bottom: 15px;">
                    <label for="email">Email:</label><br>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="prueba@gmail.com"
                           required 
                           style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="password">Contraseña:</label><br>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           value="12345678"
                           required 
                           style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                
                <button type="submit" class="btn">
                    🚀 Probar Login (Enviar a AuthController)
                </button>
            </form>
            
            <p style="margin-top: 15px;">
                <strong>Action URL:</strong> 
                <code><?php echo BASE_URL; ?>/src/Controllers/AuthController.php</code>
            </p>
        </div>
        
        <div class="form-section">
            <h2>🔍 Información de Debug</h2>
            <pre>
<?php
echo "Método actual: " . $_SERVER['REQUEST_METHOD'] . "\n";
echo "Script actual: " . $_SERVER['PHP_SELF'] . "\n";
echo "Query string: " . ($_SERVER['QUERY_STRING'] ?? 'N/A') . "\n";
echo "HTTP Host: " . $_SERVER['HTTP_HOST'] . "\n";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "\n=== DATOS POST RECIBIDOS ===\n";
    print_r($_POST);
}
?>
            </pre>
        </div>
        
        <div class="form-section">
            <h2>📋 Enlaces de Prueba</h2>
            <p>Para comparar con otros métodos:</p>
            <ul>
                <li><a href="simular_authcontroller.php">🔬 Simulación AuthController</a></li>
                <li><a href="test_flujo_login.php">🧪 Test Flujo Login</a></li>
                <li><a href="debug_mysql_detallado.php">🔍 Debug MySQL Detallado</a></li>
                <li><a href="index_fixed.php">🏠 Página Principal</a></li>
            </ul>
        </div>
    </div>
</body>
</html>