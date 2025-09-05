<?php
/**
 * Test de conexión a la base de datos
 * Este archivo sirve para probar que la configuración sea correcta
 */

require_once 'includes/init.php';

$pageTitle = 'Test de Conexión - Base de Datos';
?>

<?php include 'layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="h4 mb-0">
                        <i class="fa fa-database"></i> 
                        Test de Conexión a Base de Datos
                    </h3>
                </div>
                <div class="card-body">
                    
                    <h5>1. Configuración de Conexión</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td><strong>Host:</strong></td>
                                <td><?php echo DB_HOST; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Database:</strong></td>
                                <td><?php echo DB_NAME; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Usuario:</strong></td>
                                <td><?php echo DB_USER; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Charset:</strong></td>
                                <td><?php echo DB_CHARSET; ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <h5>2. Test de Conexión</h5>
                    <?php
                    try {
                        $db = Database::getInstance();
                        echo '<div class="alert alert-success">';
                        echo '<i class="fa fa-check-circle"></i> ';
                        echo '<strong>¡Conexión exitosa!</strong> La base de datos está funcionando correctamente.';
                        echo '</div>';
                        
                        // Test de query básico
                        echo '<h5>3. Test de Query</h5>';
                        $result = $db->query("SHOW TABLES");
                        $tables = $result->fetchAll(PDO::FETCH_COLUMN);
                        
                        if (count($tables) > 0) {
                            echo '<div class="alert alert-success">';
                            echo '<i class="fa fa-table"></i> ';
                            echo '<strong>Tablas encontradas:</strong> ' . count($tables) . ' tablas en la base de datos.';
                            echo '</div>';
                            
                            echo '<div class="row">';
                            echo '<div class="col-md-6">';
                            echo '<h6>Tablas disponibles:</h6>';
                            echo '<ul class="list-group">';
                            foreach ($tables as $table) {
                                echo '<li class="list-group-item">';
                                echo '<i class="fa fa-table text-primary"></i> ' . $table;
                                echo '</li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                            
                            // Test usuarios
                            echo '<div class="col-md-6">';
                            if (in_array('usuarios', $tables)) {
                                $usuarios = $db->fetchAll("SELECT COUNT(*) as total FROM usuarios");
                                $totalUsuarios = $usuarios[0]['total'];
                                
                                echo '<h6>Test de datos:</h6>';
                                echo '<div class="card">';
                                echo '<div class="card-body">';
                                echo '<h6 class="card-title"><i class="fa fa-users"></i> Usuarios</h6>';
                                echo '<p class="card-text">Total de usuarios registrados: <strong>' . $totalUsuarios . '</strong></p>';
                                echo '</div>';
                                echo '</div>';
                                
                                if ($totalUsuarios > 0) {
                                    $adminUser = $db->fetchOne("SELECT email, nombre, apellido, role FROM usuarios WHERE role = 'admin' LIMIT 1");
                                    if ($adminUser) {
                                        echo '<div class="card mt-2">';
                                        echo '<div class="card-body">';
                                        echo '<h6 class="card-title"><i class="fa fa-user-shield"></i> Administrador</h6>';
                                        echo '<p class="card-text">';
                                        echo '<strong>Email:</strong> ' . $adminUser['email'] . '<br>';
                                        echo '<strong>Nombre:</strong> ' . $adminUser['nombre'] . ' ' . $adminUser['apellido'];
                                        echo '</p>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                            }
                            echo '</div>';
                            echo '</div>';
                        } else {
                            echo '<div class="alert alert-warning">';
                            echo '<i class="fa fa-exclamation-triangle"></i> ';
                            echo '<strong>Atención:</strong> La base de datos está vacía. ';
                            echo 'Ejecuta el archivo <code>database/ifts15_schema.sql</code> para crear las tablas.';
                            echo '</div>';
                        }
                        
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger">';
                        echo '<i class="fa fa-times-circle"></i> ';
                        echo '<strong>Error de conexión:</strong> ' . htmlspecialchars($e->getMessage());
                        echo '</div>';
                        
                        echo '<div class="alert alert-info">';
                        echo '<h6><i class="fa fa-info-circle"></i> Pasos para solucionarlo:</h6>';
                        echo '<ol>';
                        echo '<li>Verifica que MySQL esté ejecutándose</li>';
                        echo '<li>Confirma los datos de conexión en <code>config/config.php</code></li>';
                        echo '<li>Crea la base de datos ejecutando: <code>database/ifts15_schema.sql</code></li>';
                        echo '<li>Verifica los permisos del usuario de base de datos</li>';
                        echo '</ol>';
                        echo '</div>';
                    }
                    ?>
                    
                    <h5>4. Información del Sistema</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>PHP Version:</strong></td>
                                <td><?php echo PHP_VERSION; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Debug Mode:</strong></td>
                                <td><?php echo DEBUG_MODE ? '<span class="badge bg-warning">Activado</span>' : '<span class="badge bg-success">Desactivado</span>'; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Timezone:</strong></td>
                                <td><?php echo date_default_timezone_get(); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Memory Limit:</strong></td>
                                <td><?php echo ini_get('memory_limit'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Upload Max Size:</strong></td>
                                <td><?php echo ini_get('upload_max_filesize'); ?></td>
                            </tr>
                        </table>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">
                        <i class="fa fa-home"></i> Volver al Inicio
                    </a>
                    <?php if (!isLoggedIn()): ?>
                    <a href="<?php echo SITE_URL; ?>/login.php" class="btn btn-success">
                        <i class="fa fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
