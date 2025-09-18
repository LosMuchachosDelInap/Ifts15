<?php
/**
 * Barra de Navegación Horizontal - IFTS15
 * Archivo: layouts/navbar.php
 */

$currentUser = getCurrentUser();
$isLoggedIn = isLoggedIn();
?>

<!-- Header Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <!-- Botón del sidebar (solo para usuarios logueados) -->
        <?php if ($isLoggedIn): ?>
        <button class="btn btn-outline-light me-3" id="sidebarToggle" onclick="IFTS15.toggleSidebar()">
            <i class="fa fa-bars"></i>
        </button>
        <?php endif; ?>
        
        <!-- Logo -->
        <a class="navbar-brand" href="<?php echo SITE_URL; ?>">
            <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" 
                 alt="IFTS15 - Instituto de Formación Técnica Superior" 
                 class="navbar-logo" 
                 style="height: 55px; width: auto; object-fit: contain;"
                 onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjU1IiB2aWV3Qm94PSIwIDAgMTIwIDU1IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8cmVjdCB3aWR0aD0iMTIwIiBoZWlnaHQ9IjU1IiByeD0iOCIgZmlsbD0iI0ZGRDcwMCIgc3Ryb2tlPSIjNkM3NTdEIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRleHQgeD0iNjAiIHk9IjM1IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjMkMzRTUwIiBmb250LXNpemU9IjE4IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiIGZvbnQtd2VpZ2h0PSJib2xkIj5JRlRTMTU8L3RleHQ+Cjwvc3ZnPgo='; this.style.maxWidth='120px'; console.log('Logo principal no encontrado, usando SVG de respaldo');">
        </a>
        
        <!-- Botón toggle para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menú de navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Navegación principal (centro) -->
            <ul class="navbar-nav me-auto">
                <?php if (!$isLoggedIn): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>">
                        <i class="fa fa-home"></i> Inicio
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="carrerasDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-graduation-cap"></i> Carreras
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="carrerasDropdown">
                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/realizador-productor-tv.php">Realizador y Productor Televisivo</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/nosotros.php">
                        <i class="fa fa-info-circle"></i> Nosotros
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/consultas.php">
                        <i class="fa fa-envelope"></i> Contacto
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            
            <!-- Información de contacto (solo visitantes) -->
            <?php if (!$isLoggedIn): ?>
            <div class="navbar-text me-3 d-none d-lg-block">
                <small>
                    <i class="fa fa-envelope"></i> 
                    <a href="mailto:info@ifts15.edu.ar" class="text-light text-decoration-none">
                        info@ifts15.edu.ar
                    </a>
                </small>
            </div>
            <?php endif; ?>
            
            <!-- Menú de usuario -->
            <ul class="navbar-nav">
                <?php if ($isLoggedIn && $currentUser): ?>
                    <!-- Usuario logueado -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fa fa-user-circle"></i> 
                            <?php echo htmlspecialchars($currentUser['nombre'] ?? 'Usuario'); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="fa fa-user"></i> 
                                    <?php echo htmlspecialchars(($currentUser['nombre'] ?? 'Usuario') . ' ' . ($currentUser['apellido'] ?? '')); ?>
                                </h6>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/perfil.php">
                                    <i class="fa fa-user-edit"></i> Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/configuracion.php">
                                    <i class="fa fa-cog"></i> Configuración
                                </a>
                            </li>
                            
                            <?php if (hasRole('admin')): ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?php echo SITE_URL; ?>/admin/">
                                    <i class="fa fa-shield-alt"></i> Panel Admin
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?php echo SITE_URL; ?>/logout.php">
                                    <i class="fa fa-sign-out-alt"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Usuario no logueado -->
                    <li class="nav-item">
                        <button class="nav-link btn btn-link text-white border-0" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fa fa-sign-in-alt"></i> Ingresar
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link btn btn-link text-white border-0" type="button" data-bs-toggle="modal" data-bs-target="#registerModal">
                            <i class="fa fa-user-plus"></i> Registrarse
                        </button>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal de Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">
                    <i class="fa fa-sign-in-alt"></i> Iniciar Sesión
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo SITE_URL; ?>/login.php" method="POST">
                    <div class="mb-3">
                        <label for="modalLoginEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="modalLoginEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalLoginPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="modalLoginPassword" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-sign-in-alt"></i> Ingresar
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <small class="text-muted">
                    ¿No tienes cuenta? 
                    <a href="#" class="text-decoration-none" onclick="switchToRegister()">Regístrate aquí</a>
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Registro -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="registerModalLabel">
                    <i class="fa fa-user-plus"></i> Crear Cuenta - IFTS15
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo SITE_URL; ?>/register.php" method="POST">
                    <!-- Datos Personales -->
                    <h6 class="mb-3 text-secondary">
                        <i class="fa fa-user"></i> Datos Personales
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modalRegisterNombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control" id="modalRegisterNombre" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modalRegisterApellido" class="form-label">Apellido *</label>
                            <input type="text" class="form-control" id="modalRegisterApellido" name="apellido" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="modalRegisterDni" class="form-label">DNI *</label>
                            <input type="text" class="form-control" id="modalRegisterDni" name="dni" 
                                   pattern="[0-9]+" title="Solo números" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="modalRegisterTelefono" class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control" id="modalRegisterTelefono" name="telefono" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="modalRegisterEdad" class="form-label">Edad *</label>
                            <input type="number" class="form-control" id="modalRegisterEdad" name="edad" 
                                   min="16" max="100" required>
                        </div>
                    </div>
                    
                    <!-- Datos de Acceso -->
                    <h6 class="mb-3 text-secondary mt-4">
                        <i class="fa fa-key"></i> Datos de Acceso
                    </h6>
                    
                    <div class="mb-3">
                        <label for="modalRegisterEmail" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="modalRegisterEmail" name="email" required>
                        <small class="form-text text-muted">Se usará como nombre de usuario</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modalRegisterPassword" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control" id="modalRegisterPassword" name="clave" required>
                        <small class="form-text text-muted">Mínimo 6 caracteres</small>
                    </div>
                    
                    <!-- Datos Académicos -->
                    <h6 class="mb-3 text-secondary mt-4">
                        <i class="fa fa-graduation-cap"></i> Datos Académicos
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modalRegisterCarrera" class="form-label">Carrera</label>
                            <select class="form-control" id="modalRegisterCarrera" name="id_carrera">
                                <option value="">Seleccionar carrera...</option>
                                <?php
                                // Obtener carreras para el modal
                                try {
                                    $db = Database::getInstance();
                                    $modal_carreras = $db->fetchAll("SELECT id_carrera as id, carrera as descripcion FROM carrera WHERE habilitado = 1 ORDER BY carrera");
                                    foreach ($modal_carreras as $carrera): ?>
                                        <option value="<?php echo $carrera['id']; ?>">
                                            <?php echo htmlspecialchars($carrera['descripcion']); ?>
                                        </option>
                                    <?php endforeach;
                                } catch (Exception $e) {
                                    // Silenciar errores en modal
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="modalRegisterComision" class="form-label">Comisión</label>
                            <select class="form-control" id="modalRegisterComision" name="id_comision">
                                <option value="">Seleccionar...</option>
                                <?php
                                // Obtener comisiones para el modal
                                try {
                                    $modal_comisiones = $db->fetchAll("SELECT id_comision as id, comision as descripcion FROM comision WHERE habilitado = 1 ORDER BY comision");
                                    foreach ($modal_comisiones as $comision): ?>
                                        <option value="<?php echo $comision['id']; ?>">
                                            <?php echo htmlspecialchars($comision['descripcion']); ?>
                                        </option>
                                    <?php endforeach;
                                } catch (Exception $e) {
                                    // Silenciar errores en modal
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="modalRegisterAnio" class="form-label">Año</label>
                            <select class="form-control" id="modalRegisterAnio" name="id_añoCursada">
                                <option value="">Seleccionar...</option>
                                <?php
                                // Obtener años para el modal
                                try {
                                    $modal_anios = $db->fetchAll("SELECT id_añoCursada as id, año as descripcion FROM añocursada WHERE habilitado = 1 ORDER BY id_añoCursada");
                                    foreach ($modal_anios as $anio): ?>
                                        <option value="<?php echo $anio['id']; ?>">
                                            <?php echo htmlspecialchars($anio['descripcion']); ?>
                                        </option>
                                    <?php endforeach;
                                } catch (Exception $e) {
                                    // Silenciar errores en modal
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        <strong>Nota:</strong> Te registrarás automáticamente como <strong>Alumno</strong>. 
                        Los datos académicos son opcionales y pueden completarse después.
                    </div>
                    
                    <!-- Campo oculto para rol (siempre Alumno) -->
                    <input type="hidden" name="rol" value="Alumno">
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-user-plus"></i> Registrarse
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <small class="text-muted">
                    ¿Ya tienes cuenta? 
                    <a href="#" class="text-decoration-none" onclick="switchToLogin()">Inicia sesión aquí</a>
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Alertas del sistema -->
<div class="toast-wrapper mx-auto py-0" role="status" aria-live="polite">
    <?php 
    $error = getError();
    $success = getSuccess();
    if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="fa fa-exclamation-triangle"></i> 
            <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fa fa-check-circle"></i> 
            <?php echo htmlspecialchars($success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
</div>

<!-- Scripts para manejo de modales -->
<script>
function switchToRegister() {
    document.getElementById('loginModal').querySelector('.btn-close').click();
    setTimeout(() => {
        const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
        registerModal.show();
    }, 300);
}

function switchToLogin() {
    document.getElementById('registerModal').querySelector('.btn-close').click();
    setTimeout(() => {
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }, 300);
}

// Manejo de anclas para mostrar modales automáticamente
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    
    if (hash === '#register') {
        const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
        registerModal.show();
        // Limpiar el hash después de mostrar el modal
        history.replaceState(null, null, window.location.pathname);
    } else if (hash === '#login') {
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
        // Limpiar el hash después de mostrar el modal
        history.replaceState(null, null, window.location.pathname);
    }
});
</script>
