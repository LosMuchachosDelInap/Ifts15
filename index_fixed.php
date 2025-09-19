<?php
/**
 * Página Principal - IFTS15 (Versión Corregida)
 * Basada en el patrón MVC de La Canchita de Los Pibes
 */

// Configuración de errores para desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir BASE_URL
if (!defined('BASE_URL')) {
    $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    
    if (strpos($host, ':8000') !== false || strpos($host, ':8001') !== false) {
        $carpeta = '';
    } elseif ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, 'localhost:') === 0) {
        $carpeta = '/Mis_Proyectos/Ifts15';
    } else {
        $carpeta = '';
    }
    
    define('BASE_URL', $protocolo . $host . $carpeta);
}

// Incluir archivos MVC (con manejo de errores)
try {
    require_once __DIR__ . '/src/ConectionBD/CConnection.php';
    require_once __DIR__ . '/src/Model/Person.php';
    require_once __DIR__ . '/src/Model/User.php';
    require_once __DIR__ . '/src/Controllers/AuthController.php';
    
    // Instanciar conexión a la base de datos
    $conectarDB = new ConectionDB();
    $conn = $conectarDB->getConnection();
    
} catch (Exception $e) {
    error_log("Error cargando MVC: " . $e->getMessage());
    // En caso de error, continuar sin MVC para mostrar la página básica
    $conn = null;
}

// Verificar estado de sesión
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userEmail = $_SESSION['email'] ?? '';
$userRole = $_SESSION['role'] ?? 'estudiante';
?>
<?php include __DIR__ . '/src/Template/head.php'; ?>
    
    <?php include __DIR__ . '/src/Template/navBar.php'; ?>

    <!-- Sidebar Offcanvas -->
    <?php if ($isLoggedIn): ?>
        <?php include __DIR__ . '/src/Template/sidebar.php'; ?>
    <?php else: ?>
        <!-- Sidebar para usuarios no logueados -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
            <div class="offcanvas-header offcanvas-custom-header">
                <h5 class="offcanvas-title fw-bold" id="sidebarOffcanvasLabel" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">
                    Menú Principal
                </h5>
                <button type="button" class="btn-close btn-close-custom" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body offcanvas-custom-body">
                <div class="list-group list-group-flush">
                    <a href="<?php echo BASE_URL; ?>/index_fixed.php" class="list-group-item list-group-item-action list-group-item-custom">
                        <i class="bi bi-house-door me-2 text-primary"></i>Inicio
                    </a>
                    <a href="#" class="list-group-item list-group-item-action list-group-item-custom" data-bs-toggle="modal" data-bs-target="#modalLogin">
                        <i class="bi bi-box-arrow-in-right me-2 text-success"></i>Iniciar Sesión
                    </a>
                    <a href="#" class="list-group-item list-group-item-action list-group-item-custom" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
                        <i class="bi bi-person-plus me-2 text-warning"></i>Registrarse
                    </a>
                    <hr class="border-warning">
                    <a href="#" class="list-group-item list-group-item-action list-group-item-custom" data-bs-toggle="modal" data-bs-target="#consultasModal">
                        <i class="bi bi-question-circle me-2 text-warning"></i>Consultas
                    </a>
                    <a href="#" class="list-group-item list-group-item-action list-group-item-custom">
                        <i class="bi bi-info-circle me-2 text-info"></i>Acerca de
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Contenido Principal -->
    <main class="flex-fill">
        
        <!-- Carrusel Hero Section -->
        <div id="carouselHero" class="carousel slide carousel-hero" data-bs-ride="carousel" data-bs-interval="5000">
            <!-- Indicadores -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselHero" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselHero" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselHero" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            
            <!-- Slides -->
            <div class="carousel-inner">
                <!-- Slide 1: Contenidos y Modelos Digitales -->
                <div class="carousel-item active">
                    <img src="/src/Public/images/carrussel_1.png" 
                         class="d-block w-100" 
                         alt="Contenidos y Modelos Digitales"
                         onerror="this.src='https://via.placeholder.com/1200x400/333333/ffd700?text=IMAGEN+1+NO+ENCONTRADA'">
                    <div class="carousel-caption d-none d-md-block">
                        <div class="carousel-caption-custom">
                            <h2 class="fw-bold text-white">Contenidos y Modelos Digitales</h2>
                            <p class="lead text-light">Creación de contenido audiovisual para medios digitales y televisión</p>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 2: Instituto -->
                <div class="carousel-item">
                    <img src="/src/Public/images/carrussel_2.png" 
                         class="d-block w-100" 
                         alt="Instituto de Formación Técnica Superior 15"
                         onerror="this.src='https://via.placeholder.com/1200x400/495057/ffd700?text=IMAGEN+2+NO+ENCONTRADA'">
                    <div class="carousel-caption d-none d-md-block">
                        <div class="carousel-caption-custom">
                            <h2 class="fw-bold text-warning">Instituto de Formación Técnica Superior N° 15</h2>
                            <p class="lead text-white">Carrera: Realizador y Productor Televisivo</p>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 3: Taller de Prácticas -->
                <div class="carousel-item">
                    <img src="/src/Public/images/carrussel_3.png" 
                         class="d-block w-100" 
                         alt="Taller de Prácticas Pre Profesionales"
                         onerror="this.src='https://via.placeholder.com/1200x400/1e3a8a/ffd700?text=IMAGEN+3+NO+ENCONTRADA'">
                    <div class="carousel-caption d-none d-md-block">
                        <div class="carousel-caption-custom">
                            <h2 class="fw-bold text-white">Taller de Prácticas Pre Profesionales</h2>
                            <p class="lead text-light">Experiencia práctica en entornos profesionales reales</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Controles -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHero" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselHero" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        
        <div class="container-fluid py-4">
            <!-- Contenido de la página principal -->
            
            <?php
            // Mostrar mensajes de error o éxito
            if (isset($_GET['error'])):
                $error_messages = [
                    'campos_vacios' => 'Por favor complete todos los campos obligatorios.',
                    'email_invalido' => 'El formato del email no es válido.',
                    'passwords_no_match' => 'Las contraseñas no coinciden.',
                    'password_weak' => 'La contraseña debe tener al menos 8 caracteres.',
                    'email_exists' => 'Ya existe una cuenta con este email.',
                    'dni_exists' => 'Ya existe una persona registrada con este DNI.',
                    'login_failed' => 'Email o contraseña incorrectos.',
                    'db_error' => 'Error en la base de datos. Intente nuevamente.',
                    'metodo_invalido' => 'Método de solicitud no válido.',
                    'accion_invalida' => 'Acción no válida.'
                ];
                
                $error_message = $error_messages[$_GET['error']] ?? 'Error desconocido.';
            ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo htmlspecialchars($error_message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php
                    $success_messages = [
                        'registro_exitoso' => '¡Registro exitoso! Ya puedes iniciar sesión.',
                        'login_exitoso' => '¡Bienvenido! Has iniciado sesión correctamente.',
                        'logout_exitoso' => 'Sesión cerrada correctamente.'
                    ];
                    
                    $success_message = $success_messages[$_GET['success']] ?? '¡Operación exitosa!';
                    echo htmlspecialchars($success_message);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                                    
                                    <!-- Botón Ver Información Completa -->
                                    <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <a href="<?php echo BASE_URL; ?>/src/Views/realizador-productor-tv.php" 
                                               class="btn btn-primary btn-lg">
                                                <i class="bi bi-info-circle-fill me-2"></i>
                                                Ver Información Completa de la Carrera
                                            </a>
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
                            <div class="card h-100 card-info">
                                <div class="card-body text-center">
                                    <i class="bi bi-broadcast text-success fs-1 mb-3"></i>
                                    <h5>Dirección Televisiva</h5>
                                    <p class="small text-muted">
                                        Desarrolla habilidades de dirección para programas 
                                        de televisión, documentales y contenido streaming.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-4">
                            <div class="card h-100 card-info">
                                <div class="card-body text-center">
                                    <i class="bi bi-film text-warning fs-1 mb-3"></i>
                                    <h5>Post-Producción</h5>
                                    <p class="small text-muted">
                                        Domina las herramientas de edición, efectos visuales 
                                        y sonorización profesional.
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

    <?php include __DIR__ . '/src/Template/footer.php'; ?>

    <?php if (!$isLoggedIn && $conn): ?>
        <!-- Modales de Login y Registro -->
        <?php 
        // Solo incluir modales si la conexión a BD está funcionando
        try {
            include_once(__DIR__ . "/src/Components/modalLogin.php");
            include_once(__DIR__ . "/src/Components/modalRegistrar.php");
        } catch (Exception $e) {
            // Si hay error con los modales, mostrar botones simples
            echo "<!-- Error cargando modales: " . htmlspecialchars($e->getMessage()) . " -->";
        }
        ?>
    <?php endif; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
            crossorigin="anonymous"></script>
    
    <!-- JavaScript personalizado -->
    <script>
        // Auto-ocultar alertas después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
            
            // Inicializar tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Funcionalidad del footer
            const currentYear = new Date().getFullYear();
            document.querySelector('footer p').innerHTML = 
                '© ' + currentYear + ' IFTS N° 15. Todos los derechos reservados.';
            
            // Smooth scroll para enlaces internos
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>

</body>
</html>