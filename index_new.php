<?php
/**
 * Página Principal - IFTS15
 * Basada en el patrón MVC de La Canchita de Los Pibes
 * 
 * @package IFTS15
 * @version 2.0
 */

// Configuración de errores para desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir clase de conexión
require_once __DIR__ . '/src/ConectionBD/CConnection.php';

// Instanciar conexión a la base de datos
try {
    $conectarDB = new ConectionDB();
    $conn = $conectarDB->getConnection();
} catch (Exception $e) {
    error_log("Error de conexión: " . $e->getMessage());
    // En producción, mostrar página de error genérica
    die("Error interno del servidor. Por favor, inténtelo más tarde.");
}

// Verificar estado de sesión
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userEmail = $_SESSION['email'] ?? '';
$userRole = $_SESSION['role'] ?? 'estudiante';
?>
<!DOCTYPE html>
<html lang="es">

<?php include_once(__DIR__ . "/src/Template/head.php"); ?>

<body class="d-flex flex-column min-vh-100">
    
    <?php include_once(__DIR__ . "/src/Template/navBar.php"); ?>

    <!-- Contenido Principal -->
    <main class="flex-fill">
        <div class="container-fluid py-navbar">
            
            <?php
            // Mostrar mensajes de error o éxito
            if (isset($_GET['error'])):
                $error_messages = [
                    'campos_vacios' => 'Por favor complete todos los campos obligatorios',
                    'credenciales_incorrectas' => 'Email o contraseña incorrectos',
                    'error_interno' => 'Error interno del servidor. Inténtelo más tarde',
                    'login_requerido' => 'Debe iniciar sesión para acceder',
                    'acceso_denegado' => 'No tiene permisos para acceder a esta sección',
                    'metodo_invalido' => 'Método de solicitud no válido'
                ];
                $error_msg = $error_messages[$_GET['error']] ?? urldecode($_GET['error']);
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Error:</strong> <?php echo htmlspecialchars($error_msg, ENT_QUOTES, 'UTF-8'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <?php
            // Mostrar mensajes de éxito
            if (isset($_GET['login']) && $_GET['login'] === 'success'):
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <strong>¡Bienvenido!</strong> Has iniciado sesión correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <strong>¡Registro exitoso!</strong> Su cuenta ha sido creada. Ya puede iniciar sesión.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['logout']) && $_GET['logout'] === 'success'): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Sesión cerrada:</strong> Ha cerrado sesión correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <!-- Card de Bienvenida -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="card card-welcome mb-4 fade-in">
                        <div class="card-header">
                            <h4 class="mb-0">
                                <i class="bi bi-mortarboard me-2"></i>
                                Bienvenido a IFTS15 - Instituto de Formación Técnica Superior
                                <?php if ($isLoggedIn): ?>
                                    <div class="d-block d-sm-inline mt-2 mt-sm-0">
                                        <span class="text-muted mx-2">|</span>
                                        <span class="text-warning">
                                            <i class="bi bi-person-circle me-1"></i>
                                            <?= htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                
                                <!-- Información Principal -->
                                <div class="col-12 col-lg-8">
                                    <h3 class="text-warning mb-3">
                                        <i class="bi bi-award me-2"></i>
                                        Realizador y Productor de TV
                                    </h3>
                                    <p class="lead mb-4">
                                        Formamos profesionales creativos y técnicos en el campo audiovisual. 
                                        Desarrolla tu talento en producción televisiva, dirección y post-producción.
                                    </p>
                                    
                                    <?php if (!$isLoggedIn): ?>
                                    <div class="alert alert-info slide-in-left">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>¿Eres estudiante?</strong> 
                                        Inicia sesión para acceder a tu panel académico, calificaciones y materiales de estudio.
                                    </div>
                                    <?php endif; ?>
                                    
                                    <!-- Estadísticas -->
                                    <div class="row text-center mt-4">
                                        <div class="col-6 col-md-3 mb-3">
                                            <div class="card bg-info text-white">
                                                <div class="card-body py-3">
                                                    <i class="bi bi-people-fill fs-2 mb-2"></i>
                                                    <h5 class="mb-0">250+</h5>
                                                    <small>Estudiantes</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-3">
                                            <div class="card bg-success text-white">
                                                <div class="card-body py-3">
                                                    <i class="bi bi-mortarboard-fill fs-2 mb-2"></i>
                                                    <h5 class="mb-0">15</h5>
                                                    <small>Profesores</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-3">
                                            <div class="card bg-warning text-dark">
                                                <div class="card-body py-3">
                                                    <i class="bi bi-camera-video-fill fs-2 mb-2"></i>
                                                    <h5 class="mb-0">8</h5>
                                                    <small>Estudios</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-3">
                                            <div class="card bg-secondary text-white">
                                                <div class="card-body py-3">
                                                    <i class="bi bi-award-fill fs-2 mb-2"></i>
                                                    <h5 class="mb-0">180+</h5>
                                                    <small>Graduados</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Panel Lateral -->
                                <div class="col-12 col-lg-4">
                                    <?php if ($isLoggedIn): ?>
                                        <!-- Usuario Logueado - Accesos Rápidos -->
                                        <div class="card mb-3">
                                            <div class="card-header bg-success text-white">
                                                <h6 class="mb-0">
                                                    <i class="bi bi-lightning-charge me-2"></i>
                                                    Accesos Rápidos
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-grid gap-2">
                                                    <a href="<?php echo BASE_URL; ?>/src/Views/dashboard.php" 
                                                       class="btn btn-outline-success btn-sm">
                                                        <i class="bi bi-speedometer2 me-2"></i>Mi Dashboard
                                                    </a>
                                                    <?php if ($userRole === 'estudiante'): ?>
                                                    <a href="<?php echo BASE_URL; ?>/src/Views/mis-materias.php" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-book me-2"></i>Mis Materias
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/src/Views/calificaciones.php" 
                                                       class="btn btn-outline-warning btn-sm">
                                                        <i class="bi bi-star me-2"></i>Calificaciones
                                                    </a>
                                                    <?php elseif ($userRole === 'profesor'): ?>
                                                    <a href="<?php echo BASE_URL; ?>/src/Views/mis-cursos.php" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-easel me-2"></i>Mis Cursos
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/src/Views/calificar.php" 
                                                       class="btn btn-outline-info btn-sm">
                                                        <i class="bi bi-pencil me-2"></i>Calificar
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <!-- Usuario No Logueado - Información y Acceso -->
                                        <div class="card mb-3">
                                            <div class="card-header bg-warning text-dark">
                                                <h6 class="mb-0">
                                                    <i class="bi bi-person-plus me-2"></i>
                                                    Acceso al Sistema
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <p class="small mb-3">
                                                    Inicia sesión para acceder a tus materiales de estudio, 
                                                    calificaciones y comunicarte con profesores.
                                                </p>
                                                <div class="d-grid gap-2">
                                                    <button type="button" 
                                                            class="btn btn-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalLogin">
                                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                                        Iniciar Sesión
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-outline-secondary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalRegistrar">
                                                        <i class="bi bi-person-plus me-2"></i>
                                                        Registrarse
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Novedades -->
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0">
                                                <i class="bi bi-megaphone me-2"></i>
                                                Novedades
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="small">
                                                <div class="mb-2">
                                                    <i class="bi bi-calendar3 me-1 text-muted"></i>
                                                    <strong>15/09/2025:</strong> Inscripción abierta para 2026
                                                </div>
                                                <div class="mb-2">
                                                    <i class="bi bi-camera-video me-1 text-muted"></i>
                                                    <strong>10/09/2025:</strong> Nuevos equipos de grabación
                                                </div>
                                                <div class="mb-0">
                                                    <i class="bi bi-award me-1 text-muted"></i>
                                                    <strong>05/09/2025:</strong> Graduación promoción 2024
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (!$isLoggedIn): ?>
            <!-- Sección de Información Institucional -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="row g-4">
                        <div class="col-12 col-md-4">
                            <div class="card h-100 card-info">
                                <div class="card-body text-center">
                                    <i class="bi bi-camera-reels text-primary fs-1 mb-3"></i>
                                    <h5>Producción Audiovisual</h5>
                                    <p class="small text-muted">
                                        Aprende las técnicas más avanzadas en producción 
                                        de contenido audiovisual para televisión y medios digitales.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card h-100 card-success">
                                <div class="card-body text-center">
                                    <i class="bi bi-people text-success fs-1 mb-3"></i>
                                    <h5>Formación Integral</h5>
                                    <p class="small text-muted">
                                        Desarrollo de competencias técnicas y creativas 
                                        con docentes especializados en la industria.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card h-100 card-warning">
                                <div class="card-body text-center">
                                    <i class="bi bi-briefcase text-warning fs-1 mb-3"></i>
                                    <h5>Inserción Laboral</h5>
                                    <p class="small text-muted">
                                        Preparación para el mundo profesional con 
                                        prácticas en empresas del sector audiovisual.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>
                        <i class="bi bi-mortarboard me-2"></i>
                        IFTS15
                    </h5>
                    <p class="small">
                        Instituto de Formación Técnica Superior N° 15<br>
                        Realizador y Productor de TV<br>
                        Educación técnica de calidad para el futuro audiovisual.
                    </p>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Enlaces Útiles</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Sobre Nosotros
                        </a></li>
                        <li><a href="#" class="text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Plan de Estudios
                        </a></li>
                        <li><a href="#" class="text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Biblioteca
                        </a></li>
                        <li><a href="#" class="text-decoration-none">
                            <i class="bi bi-chevron-right me-1"></i>Contacto
                        </a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Contacto</h6>
                    <p class="small">
                        <i class="bi bi-geo-alt me-1"></i>
                        Av. Ejemplo 1234, CABA<br>
                        <i class="bi bi-telephone me-1"></i>
                        (011) 4555-1234<br>
                        <i class="bi bi-envelope me-1"></i>
                        info@ifts15.edu.ar
                    </p>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col-md-6">
                    <small>© <?php echo date('Y'); ?> IFTS15. Todos los derechos reservados.</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small>Sistema Web v2.0 - Bootstrap 5.3.2</small>
                </div>
            </div>
        </div>
    </footer>

    <?php if (!$isLoggedIn): ?>
        <!-- Modales de Login y Registro -->
        <?php include_once(__DIR__ . "/src/Components/modalLogin.php"); ?>
        <?php include_once(__DIR__ . "/src/Components/modalRegistrar.php"); ?>
    <?php endif; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
            crossorigin="anonymous"></script>

    <!-- Script para auto-hide alerts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts después de 5 segundos
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                if (alert.classList.contains('show')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        });
        
        // Activar tooltips si existen
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>

</body>
</html>