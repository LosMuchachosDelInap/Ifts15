<?php
/**
 * Debug para InfinityFree - IFTS15
 * Archivo para diagnosticar problemas en producción
 */

// Mostrar todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug IFTS15 - InfinityFree</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .debug-section { margin: 20px 0; padding: 15px; border-left: 4px solid #007bff; }
        .debug-ok { border-color: #28a745; background-color: #d4edda; }
        .debug-error { border-color: #dc3545; background-color: #f8d7da; }
        .debug-warning { border-color: #ffc107; background-color: #fff3cd; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">🔧 Debug IFTS15 - InfinityFree</h1>
        
        <!-- Variables de entorno -->
        <div class="debug-section <?php echo file_exists('.env') ? 'debug-ok' : 'debug-error'; ?>">
            <h3>📁 Archivo .env</h3>
            <?php if (file_exists('.env')): ?>
                <p class="text-success">✅ Archivo .env existe</p>
                <pre class="small"><?php echo htmlspecialchars(file_get_contents('.env')); ?></pre>
            <?php else: ?>
                <p class="text-danger">❌ Archivo .env NO encontrado</p>
            <?php endif; ?>
        </div>

        <!-- Verificar carga de configuración -->
        <div class="debug-section">
            <h3>⚙️ Configuración</h3>
            <?php
            try {
                require_once 'src/config.php';
                echo '<p class="text-success">✅ config.php cargado correctamente</p>';
                echo '<p><strong>BASE_URL:</strong> ' . (defined('BASE_URL') ? BASE_URL : 'No definido') . '</p>';
                echo '<p><strong>SITE_NAME:</strong> ' . (defined('SITE_NAME') ? SITE_NAME : 'No definido') . '</p>';
            } catch (Exception $e) {
                echo '<p class="text-danger">❌ Error cargando config.php: ' . $e->getMessage() . '</p>';
            }
            ?>
        </div>

        <!-- Verificar archivos CSS -->
        <div class="debug-section">
            <h3>🎨 Archivos CSS</h3>
            <?php
            $cssFiles = [
                'src/Css/styles.css',
                'src/Css/navbarCss.css',
                'src/Css/sidebarCss.css',
                'src/Css/footerCss.css',
                'src/Css/consultasCss.css'
            ];
            
            foreach ($cssFiles as $file):
                $exists = file_exists($file);
                $class = $exists ? 'text-success' : 'text-danger';
                $icon = $exists ? '✅' : '❌';
                echo "<p class=\"$class\">$icon $file</p>";
            endforeach;
            ?>
        </div>

        <!-- Verificar estructura de directorios -->
        <div class="debug-section">
            <h3>📂 Estructura de Directorios</h3>
            <?php
            $dirs = ['src', 'src/css', 'src/Template', 'src/Views', 'src/Components', 'vendor'];
            foreach ($dirs as $dir):
                $exists = is_dir($dir);
                $class = $exists ? 'text-success' : 'text-danger';
                $icon = $exists ? '✅' : '❌';
                echo "<p class=\"$class\">$icon $dir/</p>";
            endforeach;
            ?>
        </div>

        <!-- Información del servidor -->
        <div class="debug-section debug-warning">
            <h3>🖥️ Información del Servidor</h3>
            <p><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></p>
            <p><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'No disponible'; ?></p>
            <p><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'No disponible'; ?></p>
            <p><strong>Script Name:</strong> <?php echo $_SERVER['SCRIPT_NAME'] ?? 'No disponible'; ?></p>
            <p><strong>HTTP Host:</strong> <?php echo $_SERVER['HTTP_HOST'] ?? 'No disponible'; ?></p>
        </div>

        <!-- Test de Bootstrap y JS -->
        <div class="debug-section">
            <h3>🧪 Test de Funcionalidad</h3>
            
            <!-- Test Modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testModal">
                Probar Modal
            </button>
            
            <!-- Test Cards con fondo -->
            <div class="row mt-3">
                <div class="col-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h5>Test</h5>
                            <p>Info Card</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5>Test</h5>
                            <p>Success Card</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body text-center">
                            <h5>Test</h5>
                            <p>Warning Card</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center">
                            <h5>Test</h5>
                            <p>Secondary Card</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de prueba -->
    <div class="modal fade" id="testModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">🧪 Test Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Si ves este modal con fondo gris y estilos correctos, ¡los modales funcionan!</p>
                    <div class="alert alert-success">✅ Modal funcional</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Test Button</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>