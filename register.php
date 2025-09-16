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

// Obtener datos para los dropdowns
$carreras = [];
$comisiones = [];
$anios_cursada = [];

try {
    $db = Database::getInstance();
    $carreras = $db->fetchAll("SELECT id_carrera as id, carrera as descripcion FROM carrera WHERE habilitado = 1 ORDER BY carrera");
    $comisiones = $db->fetchAll("SELECT id_comision as id, comision as descripcion FROM comision WHERE habilitado = 1 ORDER BY comision");
    $anios_cursada = $db->fetchAll("SELECT id_añoCursada as id, año as descripcion FROM añocursada WHERE habilitado = 1 ORDER BY id_añoCursada");
} catch (Exception $e) {
    // Si hay error en la BD, continuar sin los datos
}

// Procesar formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $edad = (int)($_POST['edad'] ?? 0);
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $carrera_id = (int)($_POST['carrera_id'] ?? 0);
    $comision_id = (int)($_POST['comision_id'] ?? 0);
    $anio_cursada_id = (int)($_POST['anio_cursada_id'] ?? 0);
    
    // Validaciones básicas
    if (empty($nombre) || empty($apellido) || empty($dni) || empty($telefono) || empty($email) || empty($password)) {
        showError('Todos los campos básicos son obligatorios');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        showError('El email no es válido');
    } elseif (strlen($password) < 6) {
        showError('La contraseña debe tener al menos 6 caracteres');
    } elseif ($edad < 16 || $edad > 100) {
        showError('La edad debe estar entre 16 y 100 años');
    } elseif ($carrera_id <= 0) {
        showError('Debe seleccionar una carrera');
    } elseif ($comision_id <= 0) {
        showError('Debe seleccionar una comisión');
    } elseif ($anio_cursada_id <= 0) {
        showError('Debe seleccionar el año de cursada');
    } else {
        try {
            $db = Database::getInstance();
            
            // Verificar si el email ya existe
            $stmt = $db->prepare("SELECT id FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                showError('Ya existe un usuario con ese email');
            } else {
                // Verificar si el DNI ya existe
                $stmt = $db->prepare("SELECT id FROM persona WHERE dni = ?");
                $stmt->execute([$dni]);
                
                if ($stmt->fetch()) {
                    showError('Ya existe una persona con ese DNI');
                } else {
                    // Obtener el ID del rol "Alumno" (por defecto)
                    $stmt = $db->prepare("SELECT id_rol FROM roles WHERE rol = 'Alumno' AND habilitado = 1");
                    $stmt->execute();
                    $rol_alumno = $stmt->fetch();
                    
                    if (!$rol_alumno) {
                        showError('Error: No se encontró el rol de Alumno en el sistema');
                    } else {
                        // Iniciar transacción
                        $db->beginTransaction();
                        
                        try {
                            // 1. Insertar en tabla persona
                            $stmt = $db->prepare("
                                INSERT INTO persona (apellido, nombre, dni, telefono, edad) 
                                VALUES (?, ?, ?, ?, ?)
                            ");
                            $stmt->execute([$apellido, $nombre, $dni, $telefono, $edad]);
                            $persona_id = $db->lastInsertId();
                            
                            // 2. Insertar en tabla usuario
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            $stmt = $db->prepare("
                                INSERT INTO usuario (email, clave, idpersona, idrol, idcarrera, idcomision, idanocursada, activo) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, 1)
                            ");
                            $stmt->execute([$email, $hashedPassword, $persona_id, $rol_alumno['id_rol'], $carrera_id, $comision_id, $anio_cursada_id]);
                            
                            // Confirmar transacción
                            $db->commit();
                            
                            showSuccess('Usuario registrado exitosamente. Ya puedes iniciar sesión.');
                            // Limpiar POST para mostrar formulario vacío después del éxito
                            $_POST = [];
                            
                        } catch (Exception $e) {
                            // Revertir transacción en caso de error
                            $db->rollback();
                            throw $e;
                        }
                    }
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

include 'layouts/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fa fa-user-plus"></i> Registro de Usuario - IFTS15
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <!-- Datos Personales -->
                        <h5 class="mb-3 text-secondary">
                            <i class="fa fa-user"></i> Datos Personales
                        </h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido *</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" 
                                       value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="dni" class="form-label">DNI *</label>
                                <input type="text" class="form-control" id="dni" name="dni" 
                                       value="<?php echo htmlspecialchars($_POST['dni'] ?? ''); ?>" 
                                       pattern="[0-9]+" title="Solo números" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="telefono" class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" 
                                       value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edad" class="form-label">Edad *</label>
                                <input type="number" class="form-control" id="edad" name="edad" 
                                       value="<?php echo htmlspecialchars($_POST['edad'] ?? ''); ?>" 
                                       min="16" max="100" required>
                            </div>
                        </div>
                        
                        <!-- Datos de Acceso -->
                        <h5 class="mb-3 text-secondary mt-4">
                            <i class="fa fa-key"></i> Datos de Acceso
                        </h5>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                            <small class="form-text text-muted">Se usará como nombre de usuario</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="form-text text-muted">Mínimo 6 caracteres</small>
                        </div>
                        
                        <!-- Datos Académicos -->
                        <h5 class="mb-3 text-secondary mt-4">
                            <i class="fa fa-graduation-cap"></i> Datos Académicos
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="carrera_id" class="form-label">Carrera *</label>
                                <select class="form-control" id="carrera_id" name="carrera_id" required>
                                    <option value="">Seleccionar carrera...</option>
                                    <?php foreach ($carreras as $carrera): ?>
                                        <option value="<?php echo $carrera['id']; ?>" 
                                                <?php echo ($_POST['carrera_id'] ?? '') == $carrera['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($carrera['descripcion']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="comision_id" class="form-label">Comisión *</label>
                                <select class="form-control" id="comision_id" name="comision_id" required>
                                    <option value="">Seleccionar...</option>
                                    <?php foreach ($comisiones as $comision): ?>
                                        <option value="<?php echo $comision['id']; ?>" 
                                                <?php echo ($_POST['comision_id'] ?? '') == $comision['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($comision['descripcion']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="anio_cursada_id" class="form-label">Año *</label>
                                <select class="form-control" id="anio_cursada_id" name="anio_cursada_id" required>
                                    <option value="">Seleccionar...</option>
                                    <?php foreach ($anios_cursada as $anio): ?>
                                        <option value="<?php echo $anio['id']; ?>" 
                                                <?php echo ($_POST['anio_cursada_id'] ?? '') == $anio['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($anio['descripcion']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Campo oculto para rol (siempre Alumno) -->
                        <input type="hidden" name="rol_id" value="1">
                        
                        <button type="submit" class="btn btn-success btn-lg w-100">
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