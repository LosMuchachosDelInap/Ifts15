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
        
        <!-- Logo y nombre del sitio -->
        <a class="navbar-brand" href="<?php echo SITE_URL; ?>">
            <i class="fa fa-graduation-cap me-2"></i>
            IFTS15
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
                    <a class="nav-link dropdown-toggle" href="#" id="carrerasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                <?php if ($isLoggedIn): ?>
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
                                    <?php echo htmlspecialchars($currentUser['nombre'] . ' ' . $currentUser['apellido']); ?>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">
                    <i class="fa fa-user-plus"></i> Crear Cuenta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo SITE_URL; ?>/register.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modalRegisterNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="modalRegisterNombre" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modalRegisterApellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="modalRegisterApellido" name="apellido" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="modalRegisterEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="modalRegisterEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalRegisterDni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="modalRegisterDni" name="dni" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalRegisterPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="modalRegisterPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalRegisterRole" class="form-label">Tipo de Usuario</label>
                        <select class="form-control" id="modalRegisterRole" name="rol" required>
                            <option value="">Seleccionar...</option>
                            <option value="estudiante">Estudiante</option>
                            <option value="profesor">Profesor</option>
                            <option value="personal">Personal</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
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
