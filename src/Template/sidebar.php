<?php

/**
 * Barra Lateral Vertical - IFTS15
 * Archivo: Template/sidebar.php
 * Solo se muestra para usuarios logueados
 */

// Verificar si el usuario está logueado
if (!isset($isLoggedIn) || !$isLoggedIn) return;

// Obtener información del usuario actual desde la sesión
$currentUser = [];
if (isset($_SESSION['usuario'])) {
    $currentUser['email'] = $_SESSION['usuario'];

    // Intentar obtener el nombre completo de diferentes fuentes
    if (!empty($_SESSION['nombre_completo']) && $_SESSION['nombre_completo'] !== ' ') {
        $currentUser['nombre_completo'] = $_SESSION['nombre_completo'];
    } elseif (!empty($_SESSION['nombre']) || !empty($_SESSION['apellido'])) {
        $nombre = $_SESSION['nombre'] ?? '';
        $apellido = $_SESSION['apellido'] ?? '';
        $currentUser['nombre_completo'] = trim($nombre . ' ' . $apellido);
    } else {
        // Si no hay nombre, usar el email (parte antes del @)
        $emailParts = explode('@', $currentUser['email']);
        $currentUser['nombre_completo'] = !empty($emailParts[0]) ? ucfirst($emailParts[0]) : 'Usuario';
    }

    $userIdRol = isset($_SESSION['id_rol']) ? intval($_SESSION['id_rol']) : (isset($_SESSION['role_id']) ? intval($_SESSION['role_id']) : null);
    // Mapear nombre legible del rol según la tabla roles en la BD (agregado id 5 Administrador)
    $roleNames = [
        1 => 'Alumno',
        2 => 'Profesor',
        3 => 'Administrativo',
        4 => 'Directivo',
        5 => 'Administrador'
    ];
    $currentUser['role'] = $roleNames[$userIdRol] ?? 'Alumno';
} else {
    $currentUser['email'] = 'Usuario';
    $currentUser['nombre_completo'] = 'Usuario';
    $currentUser['role'] = 'Alumno';
    $userIdRol = null;
}

$userRole = $currentUser['role'];
?>

<!-- Bootstrap Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start text-bg-dark"
    tabindex="-1"
    id="sidebarOffcanvas"
    aria-labelledby="sidebarOffcanvasLabel">

    <!-- Header del offcanvas -->
    <div class="offcanvas-header bg-secondary text-white">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">
            <i class="bi bi-person-circle me-2"></i>
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
            <i class="bi bi-person-circle fs-2 text-warning mb-2"></i>
            <p class="mb-1 text-light">
                <strong>
                    <?php echo htmlspecialchars($currentUser['nombre_completo'], ENT_QUOTES, 'UTF-8'); ?>
                </strong>
            </p>
            <p class="mb-0 text-muted small">
                <i class="bi bi-shield-check me-1"></i>
                <?php echo ucfirst($userRole); ?>
            </p>
        </div>
    </div>

    <!-- Navegación del sidebar -->
    <div class="offcanvas-body p-0">
        <ul class="nav nav-pills flex-column p-3">

            <!-- Dashboard / Inicio -->
            <li class="nav-item mb-2">
                <a class="nav-link text-light d-flex align-items-center" href="<?php echo BASE_URL; ?>/index.php">
                    <i class="bi bi-speedometer2 me-3"></i>
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
                    <i class="bi bi-mortarboard me-3"></i>
                    Académico
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="academico-menu">
                    <ul class="nav nav-pills flex-column ms-4">
                        <?php if ($userIdRol === 1): ?>
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/mis-materias.php">
                                    <i class="bi bi-book me-2"></i> Mis Materias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/calificaciones.php">
                                    <i class="bi bi-star me-2"></i> Calificaciones
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/horarios.php">
                                    <i class="bi bi-clock me-2"></i> Horarios
                                </a>
                            </li>
                        <?php elseif ($userIdRol === 2): ?>
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/mis-cursos.php">
                                    <i class="bi bi-easel me-2"></i> Mis Cursos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/calificar.php">
                                    <i class="bi bi-pencil-square me-2"></i> Calificar
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/asistencia.php">
                                    <i class="bi bi-check2-square me-2"></i> Asistencia
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>

            <!-- Recursos -->
            <li class="nav-item mb-2">
                <a class="nav-link text-light d-flex align-items-center"
                    data-bs-toggle="collapse"
                    data-bs-target="#recursos-menu"
                    role="button"
                    aria-expanded="false">
                    <i class="bi bi-folder me-3"></i>
                    Recursos
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="recursos-menu">
                    <ul class="nav nav-pills flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/biblioteca.php">
                                <i class="bi bi-journal-bookmark me-2"></i> Biblioteca
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/documentos.php">
                                <i class="bi bi-file-earmark-pdf me-2"></i> Documentos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/enlaces-utiles.php">
                                <i class="bi bi-link-45deg me-2"></i> Enlaces Útiles
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Comunicación -->
            <li class="nav-item mb-2">
                <a class="nav-link text-light d-flex align-items-center"
                    data-bs-toggle="collapse"
                    data-bs-target="#comunicacion-menu"
                    role="button"
                    aria-expanded="false">
                    <i class="bi bi-chat-dots me-3"></i>
                    Comunicación
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="comunicacion-menu">
                    <ul class="nav nav-pills flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/mensajes.php">
                                <i class="bi bi-envelope me-2"></i> Mensajes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/foros.php">
                                <i class="bi bi-chat-square-text me-2"></i> Foros
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/pages/anuncios.php">
                                <i class="bi bi-megaphone me-2"></i> Anuncios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light py-1" href="#" data-bs-toggle="modal" data-bs-target="#consultasModal">
                                <i class="bi bi-question-circle me-2"></i> Consultas
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Perfil -->
            <li class="nav-item mb-2">
                <a class="nav-link text-light d-flex align-items-center" href="<?php echo BASE_URL; ?>/pages/perfil.php">
                    <i class="bi bi-person me-3"></i>
                    Mi Perfil
                </a>
            </li>

            <?php if (isAdminRole()): ?>
                <!-- Administración (solo admin) -->
                <li class="nav-item mt-3">
                    <h6 class="sidebar-heading px-3 text-muted">
                        <i class="bi bi-shield-check"></i> ADMINISTRACIÓN
                    </h6>
                </li>

                <li class="nav-item mb-2">
                    <a class="nav-link text-light d-flex align-items-center"
                        data-bs-toggle="collapse"
                        data-bs-target="#admin-menu"
                        role="button"
                        aria-expanded="false">
                        <i class="bi bi-gear-fill me-3"></i>
                        Sistema
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse" id="admin-menu">
                        <ul class="nav nav-pills flex-column ms-4">
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/src/Controllers/UsuarioController.php?action=listar">
                                    <i class="bi bi-people me-2"></i> 
                                    Usuarios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/src/Controllers/carreras.php">
                                    <i class="bi bi-mortarboard me-2"></i> 
                                    Carreras
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/src/Controllers/materias.php">
                                    <i class="bi bi-book me-2"></i> 
                                    Materias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/src/Controllers/reportes.php">
                                    <i class="bi bi-bar-chart me-2"></i>
                                     Reportes
                                </a>
                            </li>
                            <!-- Configuración -->
                            <li class="nav-item mb-2">
                                <a class="nav-link text-light py-1" href="<?php echo BASE_URL; ?>/src/Controllers/configuracion.php">
                                    <i class="bi bi-gear me-3"></i>
                                    Configuración
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <!-- Cerrar Sesión -->
            <li class="nav-item mt-3">
                <a class="nav-link text-light d-flex align-items-center text-danger"
                    href="<?php echo BASE_URL; ?>/src/Controllers/cerrarSesion.php">
                    <i class="bi bi-box-arrow-right me-3"></i>
                    Cerrar Sesión
                </a>
            </li>

        </ul>

        <!-- Footer del sidebar -->
        <div class="mt-auto p-3 border-top border-secondary">
            <small style="color: #ffd700 !important; font-weight: 600; text-shadow: 1px 1px 3px rgba(0,0,0,0.8), -1px -1px 3px rgba(0,0,0,0.8), 1px -1px 3px rgba(0,0,0,0.8), -1px 1px 3px rgba(0,0,0,0.8);">
                <img src="<?php echo BASE_URL; ?>/src/Public/images/logo.png"
                    alt="IFTS15"
                    height="20"
                    class="me-2">
                IFTS15 Sistema Web
            </small>
        </div>
    </div>
</div>

<!-- Modal de Consultas -->
<?php include_once __DIR__ . '/../Components/modalConsultas.php'; ?>
<!-- Modal de Registro (para que funcione desde el sidebar) -->
<?php include_once __DIR__ . '/../Components/modalRegistrar.php'; ?>