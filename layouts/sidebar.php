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

<!-- Sidebar vertical -->
<div id="sidebar" class="sidebar bg-dark text-white">
    <div class="sidebar-header p-3">
        <h5 class="mb-0">
            <i class="fa fa-user-circle"></i> 
            Panel de Usuario
        </h5>
        <small class="text-muted">
            <?php echo ucfirst($userRole); ?>
        </small>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav nav-pills flex-column">
            
            <!-- Dashboard / Inicio -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo SITE_URL; ?>/dashboard.php">
                    <i class="fa fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            
            <!-- Académico -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#academico-menu">
                    <i class="fa fa-graduation-cap"></i>
                    Académico
                    <i class="fa fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="academico-menu">
                    <ul class="nav nav-pills flex-column ms-3">
                        <?php if ($userRole === 'estudiante'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/mis-materias.php">
                                <i class="fa fa-book"></i> Mis Materias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/calificaciones.php">
                                <i class="fa fa-star"></i> Calificaciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/horarios.php">
                                <i class="fa fa-clock"></i> Horarios
                            </a>
                        </li>
                        <?php elseif ($userRole === 'profesor'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/mis-cursos.php">
                                <i class="fa fa-chalkboard-teacher"></i> Mis Cursos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/calificar.php">
                                <i class="fa fa-edit"></i> Calificar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/asistencia.php">
                                <i class="fa fa-check-square"></i> Asistencia
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
    </nav>
    
    <!-- Footer del sidebar -->
    <div class="sidebar-footer p-3 mt-auto">
        <small class="text-muted">
            <i class="fa fa-graduation-cap"></i> 
            IFTS15 Sistema
        </small>
    </div>
</div>
