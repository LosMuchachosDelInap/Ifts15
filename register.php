<?php
/**
 * Página de Registro - IFTS15
 * Archivo: register.php
 */

require_once 'includes/init.php';

// Si el usuario ya está logueado, redirigir
if (isLoggedIn()) {
    header('Location: ' . SITE_URL);
    exit;
}

$pageTitle = 'Registro de Usuario';

// Procesar formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? '';
    
    // Validaciones básicas
    if (empty($nombre) || empty($apellido) || empty($email) || empty($dni) || empty($password) || empty($rol)) {
        showError('Todos los campos son obligatorios');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        showError('El email no es válido');
    } elseif (strlen($password) < 6) {
        showError('La contraseña debe tener al menos 6 caracteres');
    } elseif (!in_array($rol, ['estudiante', 'profesor', 'personal'])) {
        showError('Rol no válido');
    } else {
        // MODO DEMO: Solo mostrar mensaje sin procesar realmente
        if (defined('DISABLE_DATABASE') && DISABLE_DATABASE) {
            showError('MODO DEMO: El registro está deshabilitado. Este es solo un demo visual del formulario.');
        } else {
            try {
                $db = Database::getInstance();
                
                // Verificar si el email ya existe
                $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
                $stmt->execute([$email]);
                
                if ($stmt->fetch()) {
                    showError('Ya existe un usuario con ese email');
                } else {
                    // Crear usuario
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    
                    $stmt = $db->prepare("
                        INSERT INTO usuarios (nombre, apellido, email, dni, password, rol, activo, fecha_registro) 
                        VALUES (?, ?, ?, ?, ?, ?, 1, NOW())
                    ");
                    
                    if ($stmt->execute([$nombre, $apellido, $email, $dni, $hashedPassword, $rol])) {
                        showSuccess('Usuario registrado exitosamente. Ya puedes iniciar sesión.');
                        header('Location: ' . SITE_URL . '/login.php');
                        exit;
                    } else {
                        showError('Error al crear el usuario');
                    }
                }
            } catch (Exception $e) {
                if (DEBUG_MODE) {
                    showError("Error: " . $e->getMessage());
                } else {
                    showError('Error interno del sistema');
                }
            }
        }
    }
}

include 'layouts/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fa fa-user-plus"></i> Registro de Usuario
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" 
                                       value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" 
                                   value="<?php echo htmlspecialchars($_POST['dni'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="form-text text-muted">Mínimo 6 caracteres</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="rol" class="form-label">Tipo de Usuario</label>
                            <select class="form-control" id="rol" name="rol" required>
                                <option value="">Seleccionar...</option>
                                <option value="estudiante" <?php echo ($_POST['rol'] ?? '') === 'estudiante' ? 'selected' : ''; ?>>Estudiante</option>
                                <option value="profesor" <?php echo ($_POST['rol'] ?? '') === 'profesor' ? 'selected' : ''; ?>>Profesor</option>
                                <option value="personal" <?php echo ($_POST['rol'] ?? '') === 'personal' ? 'selected' : ''; ?>>Personal</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fa fa-user-plus"></i> Registrarse
                        </button>
                    </form>
                    
                    <hr>
                    <div class="text-center">
                        <small>
                            ¿Ya tienes cuenta? 
                            <a href="<?php echo SITE_URL; ?>/login.php" class="text-decoration-none">
                                Inicia sesión aquí
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
