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
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fa fa-graduation-cap"></i> Carreras
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/carrera-desarrollo.php">Desarrollo de Software</a></li>
                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/carrera-redes.php">Redes y Seguridad</a></li>
                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/carrera-sistemas.php">Análisis de Sistemas</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/nosotros.php">
                        <i class="fa fa-info-circle"></i> Nosotros
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/contacto.php">
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
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/login.php">
                            <i class="fa fa-sign-in-alt"></i> Ingresar
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Espacio para compensar navbar fixed -->
<div style="height: 70px;"></div>

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
