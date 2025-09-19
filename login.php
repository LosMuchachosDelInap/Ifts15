<?php
/**
 * Página de Login - IFTS15 Sistema Web
 * Migrada a phpdotenv
 */

// Cargar configuración central con phpdotenv
require_once __DIR__ . '/src/config.php';
require_once __DIR__ . '/src/Database.php';

// Si ya está logueado, redirigir
if (isLoggedIn()) {
    redirect('/index.php');
}

$pageTitle = 'Iniciar Sesión';
$error = '';

// Procesar formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Email y contraseña son requeridos';
    } else {
        try {
            $db = Database::getInstance();
            
            // Buscar usuario con todos los datos relacionados
            $sql = "
                SELECT 
                    u.id_usuario as usuario_id,
                    u.email,
                    u.clave,
                    u.habilitado,
                    p.nombre,
                    p.apellido,
                    p.dni,
                    p.telefono,
                    p.edad,
                    r.rol,
                    c.carrera,
                    com.comision,
                    a.año as anio_cursada
                FROM usuario u
                INNER JOIN persona p ON u.id_persona = p.id_persona
                INNER JOIN roles r ON u.id_rol = r.id_rol
                LEFT JOIN carrera c ON u.id_carrera = c.id_carrera
                LEFT JOIN comision com ON u.id_comision = com.id_comision
                LEFT JOIN añocursada a ON u.id_añoCursada = a.id_añoCursada
                WHERE u.email = ? AND u.habilitado = 1
            ";
            
            $user = $db->fetchOne($sql, [$email]);
        
            if ($user && password_verify($password, $user['clave'])) {
                // Login exitoso - Guardar datos en sesión
                $_SESSION['user_id'] = $user['usuario_id'];
                $_SESSION['user_data'] = [
                    'id' => $user['usuario_id'],
                    'email' => $user['email'],
                    'nombre' => $user['nombre'],
                    'apellido' => $user['apellido'],
                    'dni' => $user['dni'],
                    'telefono' => $user['telefono'],
                    'edad' => $user['edad'],
                    'rol' => $user['rol'],
                    'carrera' => $user['carrera'],
                    'comision' => $user['comision'],
                    'anio_cursada' => $user['anio_cursada']
                ];
                
                showSuccess('¡Bienvenido ' . $user['nombre'] . '! Has iniciado sesión correctamente.');
                redirect('/index.php');
            } else {
                $error = 'Email o contraseña incorrectos';
            }
            
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                $error = "Error de sistema: " . $e->getMessage();
            } else {
                $error = 'Error interno del sistema. Intenta nuevamente.';
            }
        }
    }
}

include __DIR__ . '/src/Template/head.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">
                        <i class="fa fa-sign-in-alt"></i> Iniciar Sesión
                    </h3>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fa fa-envelope"></i> Email
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo htmlspecialchars($email ?? ''); ?>"
                                   placeholder="Ingresa tu email" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fa fa-lock"></i> Contraseña
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Ingresa tu contraseña" 
                                   required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-sign-in-alt"></i> Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <hr>
                    
                    <div class="text-center">
                        <p class="mb-2">
                            <small class="text-muted">¿No tienes una cuenta?</small>
                        </p>
                        <a href="<?php echo SITE_URL; ?>/register.php" 
                           class="btn btn-outline-success">
                            <i class="fa fa-user-plus"></i> Registrarse
                        </a>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="<?php echo SITE_URL; ?>" class="text-decoration-none text-muted">
                            <i class="fa fa-home"></i> Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/src/Template/footer.php'; ?>