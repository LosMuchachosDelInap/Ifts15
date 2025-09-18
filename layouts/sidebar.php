<?php
/**
 * Barra Lateral Vertical - IFTS15
 * Archivo: layouts/sidebar.php
 * Solo se muestra para usuarios logueados
 */

if (!isLoggedIn()) return;

$currentUser = getCurrentUser();
$userRole = $currentUser['role'] ?? 'estudiante';
?>

<!-- Bootstrap Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start text-bg-dark" 
     tabindex="-1" 
     id="sidebarOffcanvas" 
     aria-labelledby="sidebarOffcanvasLabel">
    
    <!-- Header del offcanvas -->
    <div class="offcanvas-header bg-secondary text-white">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">
            <i class="fa fa-user-circle me-2"></i>
            Panel de Usuario
        </h5>
        <button type="button" 
                class="btn-close btn-close-white" 
                data-bs-dismiss="offcanvas" 
                aria-label="Close"></button>
    </div>
    
    <!-- Información del usuario -->
    <div class="p-3 border-bottom border-secondary">
        <div class="text-center">
            <i class="fa fa-user-circle fs-2 text-warning mb-2"></i>
            <p class="mb-1 text-light">
                <strong>
                    <?php echo htmlspecialchars($currentUser['email'] ?? 'Usuario', ENT_QUOTES, 'UTF-8'); ?>
                </strong>
            </p>
            <p class="mb-0 text-muted small">
                <i class="fa fa-shield-alt me-1"></i>
                <?php echo ucfirst($userRole); ?>
            </p>
        </div>
    </div>
    
    <!-- Navegación del sidebar -->
    <div class="offcanvas-body p-0">
        <ul class="nav nav-pills flex-column p-3">
            
            <!-- Dashboard / Inicio -->
            <li class="nav-item mb-2">
                <a class="nav-link text-light d-flex align-items-center" href="<?php echo SITE_URL; ?>/dashboard.php">
                    <i class="fa fa-tachometer-alt me-3"></i>
                    Dashboard
                </a>
            </li>
            
            <!-- Académico -->
            <li class="nav-item mb-2">
                <a class="nav-link text-light d-flex align-items-center" 
                   data-bs-toggle="collapse" 
                   data-bs-target="#academico-menu" 
                   role="button" 
                   aria-expanded="false">
                    <i class="fa fa-graduation-cap me-3"></i>
                    Académico
                    <i class="fa fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="academico-menu">
                    <ul class="nav nav-pills flex-column ms-4">
                        <?php if ($userRole === 'estudiante'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo SITE_URL; ?>/pages/mis-materias.php">
                                <i class="fa fa-book me-2"></i> Mis Materias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo SITE_URL; ?>/pages/calificaciones.php">
                                <i class="fa fa-star me-2"></i> Calificaciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo SITE_URL; ?>/pages/horarios.php">
                                <i class="fa fa-clock me-2"></i> Horarios
                            </a>
                        </li>
                        <?php elseif ($userRole === 'profesor'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo SITE_URL; ?>/pages/mis-cursos.php">
                                <i class="fa fa-chalkboard-teacher me-2"></i> Mis Cursos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo SITE_URL; ?>/pages/calificar.php">
                                <i class="fa fa-edit me-2"></i> Calificar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo SITE_URL; ?>/pages/asistencia.php">
                                <i class="fa fa-check-square me-2"></i> Asistencia
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
            
            <!-- Recursos -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#recursos-menu">
                    <i class="fa fa-folder"></i>
                    Recursos
                    <i class="fa fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="recursos-menu">
                    <ul class="nav nav-pills flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/biblioteca.php">
                                <i class="fa fa-book-open"></i> Biblioteca
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/documentos.php">
                                <i class="fa fa-file-pdf"></i> Documentos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/enlaces-utiles.php">
                                <i class="fa fa-link"></i> Enlaces Útiles
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Comunicación -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#comunicacion-menu">
                    <i class="fa fa-comments"></i>
                    Comunicación
                    <i class="fa fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="comunicacion-menu">
                    <ul class="nav nav-pills flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/mensajes.php">
                                <i class="fa fa-envelope"></i> Mensajes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/foros.php">
                                <i class="fa fa-comments"></i> Foros
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/anuncios.php">
                                <i class="fa fa-bullhorn"></i> Anuncios
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Perfil -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/perfil.php">
                    <i class="fa fa-user"></i>
                    Mi Perfil
                </a>
            </li>
            
            <!-- Configuración -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/configuracion.php">
                    <i class="fa fa-cog"></i>
                    Configuración
                </a>
            </li>
            
            <?php if (hasRole('admin')): ?>
            <!-- Administración (solo admin) -->
            <li class="nav-item mt-3">
                <h6 class="sidebar-heading px-3 text-muted">
                    <i class="fa fa-shield-alt"></i> ADMINISTRACIÓN
                </h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#admin-menu">
                    <i class="fa fa-cogs"></i>
                    Sistema
                    <i class="fa fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="admin-menu">
                    <ul class="nav nav-pills flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/admin/usuarios.php">
                                <i class="fa fa-users"></i> Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/admin/carreras.php">
                                <i class="fa fa-graduation-cap"></i> Carreras
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/admin/materias.php">
                                <i class="fa fa-book"></i> Materias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/admin/reportes.php">
                                <i class="fa fa-chart-bar"></i> Reportes
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>
            
        </ul>
        
        <!-- Footer del sidebar -->
        <div class="mt-auto p-3 border-top border-secondary">
            <small class="text-muted">
                <i class="fa fa-graduation-cap me-2"></i> 
                IFTS15 Sistema Web
            </small>
        </div>
    </div>
</div>
