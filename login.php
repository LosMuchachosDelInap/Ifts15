<?php
/**
 * Página de Login - IFTS15 Sistema Web
 */

require_once 'includes/init.php';

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
        // MODO DEMO: Solo mostrar mensaje sin procesar realmente
        if (defined('DISABLE_DATABASE') && DISABLE_DATABASE) {
            $error = 'MODO DEMO: El login está deshabilitado. Este es solo un demo visual del formulario.';
        } else {
            try {
                // Buscar usuario en la base de datos (solo cuando BD esté activa)
                $db = Database::getInstance();
                $user = $db->fetchOne(
                    "SELECT * FROM usuarios WHERE email = ? AND activo = 1", 
                    [$email]
                );
            
                if ($user && password_verify($password, $user['password'])) {
                    // Login exitoso
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_data'] = [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'nombre' => $user['nombre'],
                        'apellido' => $user['apellido'],
                        'role' => $user['role']
                    ];
                    
                    showSuccess('¡Bienvenido! Has iniciado sesión correctamente.');
                    redirect('/index.php');
                } else {
                    $error = 'Email o contraseña incorrectos';
                }
            } catch (Exception $e) {
                if (DEBUG_MODE) {
                    $error = "Error de base de datos: " . $e->getMessage();
                } else {
                    $error = "Error interno del sistema";
                }
            }
        }
    }
}
?>

<?php include 'layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="h4 mb-0">
                        <i class="fa fa-sign-in-alt"></i> 
                        Iniciar Sesión
                    </h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" 
                             alt="<?php echo SITE_NAME; ?>" 
                             style="max-height: 80px;">
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-triangle"></i> 
                            <?php echo htmlspecialchars($error); ?>
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
                                   required 
                                   placeholder="tu@email.com">
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fa fa-lock"></i> Contraseña
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   placeholder="Tu contraseña">
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">
                                Recordarme
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-sign-in-alt"></i> 
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-center">
                    <small class="text-muted">
                        <a href="<?php echo SITE_URL; ?>/reset-password.php">¿Olvidaste tu contraseña?</a>
                    </small>
                    <br>
                    <small class="text-muted">
                        ¿No tienes cuenta? 
                        <a href="<?php echo SITE_URL; ?>/register.php">Regístrate aquí</a>
                    </small>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fa fa-info-circle text-info"></i> 
                        Información para Estudiantes
                    </h6>
                    <p class="card-text small">
                        Si eres estudiante activo del IFTS12, puedes usar tus credenciales 
                        del SIU-Guaraní para acceder al sistema.
                    </p>
                    <a href="<?php echo SITE_URL; ?>/pages/siu-guarani.php" class="btn btn-outline-info btn-sm">
                        <i class="fa fa-external-link-alt"></i> 
                        Ir a SIU-Guaraní
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Focus en el campo email al cargar
    document.getElementById('email').focus();
    
    // Validación básica en el frontend
    document.querySelector('form').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            e.preventDefault();
            alert('Por favor completa todos los campos');
            return false;
        }
        
        if (!email.includes('@')) {
            e.preventDefault();
            alert('Por favor ingresa un email válido');
            return false;
        }
    });
});
</script>

<?php include 'layouts/footer.php'; ?>
