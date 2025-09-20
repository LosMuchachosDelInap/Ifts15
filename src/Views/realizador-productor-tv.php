<?php
/**
 * Realizador y Productor Televisivo - IFTS15
 * Carrera específica del instituto
 */

// Iniciar sesión para compatibilidad con templates
session_start();

// Configuración directa para esta página
$pageTitle = 'Realizador y Productor Televisivo - IFTS15';

// Constantes específicas para esta página
define('SITE_NAME', 'INSTITUTO DE FORMACIÓN TÉCNICA SUPERIOR Nº 15');
define('CARD_DESCRIPTION', 'Tecnología Digital plantea una visión integral de la TV digital como parte de un todo más amplio: el universo audiovisual. Explora formatos tradicionales así como los nuevos modos de creación, producción y consumo audiovisual en la era digital.');

// Detectar BASE_URL automáticamente
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptPath = dirname(dirname($_SERVER['SCRIPT_NAME'])); // Sube dos niveles desde src/Views
define('BASE_URL', $protocol . '://' . $host . $scriptPath);

// Variables para el sistema de templates
$isLoggedIn = isset($_SESSION['usuario']) && !empty($_SESSION['usuario']);
$userEmail = $isLoggedIn ? $_SESSION['usuario'] : '';
$userRole = $isLoggedIn ? ($_SESSION['role'] ?? 'estudiante') : '';

?>

<?php include __DIR__ . '/../Template/head.php'; ?>

<?php include __DIR__ . '/../Template/navBar.php'; ?>

<?php include __DIR__ . '/../Template/sidebar.php'; ?>

<!-- CSS específico para esta página -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/Css/informacionCarreraCss.css">

<!-- Contenido principal con margen para navbar fixed -->

<div class="container mt-4" style="margin-top: 100px !important;">
    <div class="row">
        <div class="col-12">
            <!-- Header específico IFTS15 -->
            <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);">
                <div class="card-body text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-6 mb-3">
                                <i class="fa fa-video me-3"></i>
                                Tecnicatura Superior en Realizador y Productor Televisivo
                            </h1>
                            <p class="lead mb-0">
                                <?php echo CARD_DESCRIPTION; ?>
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="bg-white rounded p-3 text-dark">
                                <h3 class="text-danger mb-1">3 años</h3>
                                <small class="text-muted">Duración</small>
                                <hr class="my-2">
                                <h5 class="text-primary mb-0">IFTS15</h5>
                                <small class="text-muted">Especialidad</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Características únicas -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card h-100 text-center border-danger">
                        <div class="card-body">
                            <i class="fa fa-tv fa-3x text-danger mb-3"></i>
                            <h5>Producción TV</h5>
                            <p class="text-muted">Desde la conceptualización hasta la emisión</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 text-center border-warning">
                        <div class="card-body">
                            <i class="fa fa-film fa-3x text-warning mb-3"></i>
                            <h5>Realización</h5>
                            <p class="text-muted">Dirección creativa y técnica de contenidos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 text-center border-success">
                        <div class="card-body">
                            <i class="fa fa-broadcast-tower fa-3x text-success mb-3"></i>
                            <h5>TV Digital</h5>
                            <p class="text-muted">Tecnologías y plataformas digitales modernas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del IFTS15 -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-gradient bg-danger text-white">
                            <h4 class="mb-0">
                                <i class="fa fa-info-circle"></i>
                                Información de la Carrera
                            </h4>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Instituto:</dt>
                                <dd class="col-sm-8"><?php echo SITE_NAME; ?></dd>
                                
                                <dt class="col-sm-4">Modalidad:</dt>
                                <dd class="col-sm-8">Presencial con prácticas en estudios de TV</dd>
                                
                                <dt class="col-sm-4">Título de Egreso:</dt>
                                <dd class="col-sm-8">Técnico Superior en Realizador y Productor Televisivo</dd>
                                
                                <dt class="col-sm-4">Requisitos:</dt>
                                <dd class="col-sm-8">Nivel Medio Aprobado + Entrevista vocacional</dd>
                                
                                <dt class="col-sm-4">Duración:</dt>
                                <dd class="col-sm-8">3 años (6 cuatrimestres) + Trabajo Final</dd>
                                
                                <dt class="col-sm-4">Enfoque:</dt>
                                <dd class="col-sm-8">Tecnología Digital y Universo Audiovisual</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fa fa-tools"></i>
                                Tecnologías y Equipos
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <span class="badge bg-danger">Avid Media Composer</span>
                                </div>
                                <div class="col-12 mb-2">
                                    <span class="badge bg-primary">Adobe Premiere Pro</span>
                                </div>
                                <div class="col-12 mb-2">
                                    <span class="badge bg-success">Final Cut Pro</span>
                                </div>
                                <div class="col-12 mb-2">
                                    <span class="badge bg-warning">After Effects</span>
                                </div>
                                <div class="col-12 mb-2">
                                    <span class="badge bg-info">Pro Tools</span>
                                </div>
                                <div class="col-12 mb-2">
                                    <span class="badge bg-secondary">Cámaras 4K</span>
                                </div>
                                <div class="col-12 mb-2">
                                    <span class="badge bg-dark">Estudios HD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filosofía educativa -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fa fa-lightbulb text-warning"></i>
                        Filosofía Educativa - Visión Integral
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="lead">
                                <?php echo CARD_DESCRIPTION; ?>
                            </p>
                            <p>
                                Nuestra carrera se fundamenta en una comprensión profunda de que la TV digital 
                                no es un medio aislado, sino parte de un ecosistema audiovisual más amplio que 
                                incluye plataformas digitales, streaming, redes sociales y nuevas formas de 
                                consumo de contenido.
                            </p>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-3 rounded">
                                <h6 class="text-primary">Metodología:</h6>
                                <ul class="small mb-0">
                                    <li>Aprendizaje basado en proyectos</li>
                                    <li>Prácticas en estudios reales</li>
                                    <li>Producción de contenidos</li>
                                    <li>Trabajo multidisciplinario</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perfil del Egresado -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fa fa-user-graduate text-success"></i>
                        Perfil del Egresado
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-danger">Como Realizador:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0 px-0">
                                    <i class="fa fa-check text-success me-2"></i>
                                    Dirigir la puesta en escena televisiva
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <i class="fa fa-check text-success me-2"></i>
                                    Coordinar equipos técnicos y artísticos
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <i class="fa fa-check text-success me-2"></i>
                                    Desarrollar conceptos creativos innovadores
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <i class="fa fa-check text-success me-2"></i>
                                    Adaptar contenidos a nuevos formatos
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Como Productor:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0 px-0">
                                    <i class="fa fa-check text-success me-2"></i>
                                    Gestionar proyectos audiovisuales integrales
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <i class="fa fa-check text-success me-2"></i>
                                    Administrar recursos y presupuestos
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <i class="fa fa-check text-success me-2"></i>
                                    Negociar contratos y derechos
                                </li>
                                <li class="list-group-item border-0 px-0">
                                    <i class="fa fa-check text-success me-2"></i>
                                    Identificar oportunidades de mercado
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plan de Estudios -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fa fa-graduation-cap text-info"></i>
                        Plan de Estudios - Enfoque Práctico
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Primer Año -->
                        <div class="col-md-4 mb-3">
                            <h5 class="text-danger border-bottom pb-2">
                                <i class="fa fa-play-circle"></i>
                                Primer Año - Fundamentos
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-video text-danger me-2"></i>
                                    Introducción a la TV Digital
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-cut text-primary me-2"></i>
                                    Edición y Postproducción I
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-camera text-success me-2"></i>
                                    Lenguaje Audiovisual
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-history text-warning me-2"></i>
                                    Historia de los Medios
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-pen text-info me-2"></i>
                                    Guión Televisivo
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Segundo Año -->
                        <div class="col-md-4 mb-3">
                            <h5 class="text-warning border-bottom pb-2">
                                <i class="fa fa-cogs"></i>
                                Segundo Año - Producción
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-tv text-danger me-2"></i>
                                    Producción Televisiva I
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-microphone text-primary me-2"></i>
                                    Audio y Sonido Digital
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-magic text-success me-2"></i>
                                    Efectos Especiales
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-chart-line text-warning me-2"></i>
                                    Marketing Audiovisual
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-balance-scale text-info me-2"></i>
                                    Aspectos Legales
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Tercer Año -->
                        <div class="col-md-4 mb-3">
                            <h5 class="text-success border-bottom pb-2">
                                <i class="fa fa-rocket"></i>
                                Tercer Año - Especialización
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-broadcast-tower text-danger me-2"></i>
                                    Producción Televisiva II
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-users text-primary me-2"></i>
                                    Dirección de Equipos
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-wifi text-success me-2"></i>
                                    Transmedia y Streaming
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-briefcase text-warning me-2"></i>
                                    Gestión de Proyectos
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fa fa-star text-info me-2"></i>
                                    Trabajo Final Integrador
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instalaciones -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">
                        <i class="fa fa-building"></i>
                        Instalaciones y Estudios - IFTS15
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>🎬 Estudio de TV</h6>
                            <ul class="small">
                                <li>Set de grabación profesional</li>
                                <li>Sistema de iluminación LED</li>
                                <li>Cámaras 4K con teleprompter</li>
                                <li>Mesa de mezclas de audio</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>💻 Sala de Edición</h6>
                            <ul class="small">
                                <li>Estaciones con software profesional</li>
                                <li>Monitores calibrados para color</li>
                                <li>Sistemas de almacenamiento SAN</li>
                                <li>Equipos de masterización</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campo laboral -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fa fa-briefcase"></i>
                        Oportunidades Profesionales
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-danger">Medios Tradicionales:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-check text-success me-2"></i>Canales de TV abierta y cable</li>
                                <li><i class="fa fa-check text-success me-2"></i>Productoras audiovisuales</li>
                                <li><i class="fa fa-check text-success me-2"></i>Estudios de grabación</li>
                                <li><i class="fa fa-check text-success me-2"></i>Agencias de publicidad</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Nuevos Medios:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-check text-success me-2"></i>Plataformas de streaming</li>
                                <li><i class="fa fa-check text-success me-2"></i>Contenido para redes sociales</li>
                                <li><i class="fa fa-check text-success me-2"></i>Producción independiente</li>
                                <li><i class="fa fa-check text-success me-2"></i>Consultoría en medios digitales</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action específico IFTS15 -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-gradient text-white" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);">
                        <div class="card-body text-center">
                            <h3 class="mb-3">🎬 ¡Comienza tu carrera en TV!</h3>
                            <p class="lead mb-4">
                                Únete al IFTS15 y forma parte de la nueva generación de realizadores y productores televisivos
                            </p>
                            <div class="btn-group" role="group">
                                <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
                                    <i class="fa fa-user-plus text-danger"></i>
                                    Inscribirse Ahora
                                </button>
                                <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalConsultas">
                                    <i class="fa fa-phone"></i>
                                    Contactar
                                </button>
                                <a href="<?php echo BASE_URL; ?>/" class="btn btn-outline-light">
                                    <i class="fa fa-home"></i>
                                    Volver al Inicio
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir footer del sistema -->
<?php include __DIR__ . '/../Template/footer.php'; ?>

<!-- Agregar modal de registro específico para esta página -->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarLabel">
                    <i class="fas fa-user-plus me-2"></i>
                    Registro - Realizador y Productor Televisivo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="registroForm" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="carrera" class="form-label">Carrera de Interés</label>
                        <select class="form-select" id="carrera" name="carrera" required disabled>
                            <option value="realizador-productor-tv" selected>Realizador y Productor Televisivo</option>
                        </select>
                        <div class="form-text">Esta carrera ha sido preseleccionada automáticamente.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="registroForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Registrarse
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar envío del formulario de registro
        const registroForm = document.getElementById('registroForm');
        if (registroForm) {
            registroForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('¡Gracias por tu interés en la carrera de Realizador y Productor Televisivo! Pronto nos pondremos en contacto contigo.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalRegistrar'));
                if (modal) modal.hide();
            });
        }
    });
</script>

</body>
</html>

<!-- Modal de Registro -->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarLabel">
                    <i class="fas fa-user-plus me-2"></i>
                    Registro de Estudiantes - IFTS15
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="registroForm" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="carrera" class="form-label">Carrera de Interés</label>
                        <select class="form-select" id="carrera" name="carrera" required>
                            <option value="">Seleccionar carrera...</option>
                            <option value="realizador-productor-tv">Realizador y Productor Televisivo</option>
                            <option value="otras">Otras carreras</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="registroForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Registrarse
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Consultas -->
<div class="modal fade" id="modalConsultas" tabindex="-1" aria-labelledby="modalConsultasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConsultasLabel">
                    <i class="fas fa-envelope me-2"></i>
                    Consultas - IFTS15
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6>Formulario de Consulta</h6>
                        <form id="consultaForm" method="POST">
                            <div class="mb-3">
                                <label for="consultaNombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="consultaNombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="consultaEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="consultaEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="consultaTema" class="form-label">Tema de Consulta</label>
                                <select class="form-select" id="consultaTema" name="tema" required>
                                    <option value="">Seleccionar tema...</option>
                                    <option value="admision">Proceso de Admisión</option>
                                    <option value="carrera">Información de Carreras</option>
                                    <option value="inscripcion">Inscripciones</option>
                                    <option value="becas">Becas y Ayudas</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="consultaMensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="consultaMensaje" name="mensaje" rows="4" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <h6>Información de Contacto</h6>
                        <div class="bg-light p-3 rounded">
                            <p class="small mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <strong>Teléfono:</strong><br>
                                (011) 4xxx-xxxx
                            </p>
                            <p class="small mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <strong>Email:</strong><br>
                                info@ifts15.edu.ar
                            </p>
                            <p class="small mb-2">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <strong>Horario de Atención:</strong><br>
                                Lun a Vie: 9:00 - 18:00
                            </p>
                            <p class="small mb-0">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <strong>Dirección:</strong><br>
                                Buenos Aires, Argentina
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="consultaForm" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>Enviar Consulta
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Footer autónomo -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="text-warning">
                        <i class="fas fa-graduation-cap me-2"></i>
                        IFTS15
                    </h5>
                    <p class="small">
                        Instituto de Formación Técnica Superior N° 15<br>
                        Formando profesionales en tecnología audiovisual
                    </p>
                </div>
                <div class="col-md-4">
                    <h6 class="text-warning">Enlaces Útiles</h6>
                    <ul class="list-unstyled small">
                        <li><a href="<?php echo BASE_URL; ?>/" class="text-light text-decoration-none">Inicio</a></li>
                        <li><a href="#" class="text-light text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalConsultas">Contacto</a></li>
                        <li><a href="#" class="text-light text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalRegistrar">Inscripciones</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-warning">Contacto</h6>
                    <p class="small mb-1">
                        <i class="fas fa-phone me-2"></i>
                        (011) 4xxx-xxxx
                    </p>
                    <p class="small mb-1">
                        <i class="fas fa-envelope me-2"></i>
                        info@ifts15.edu.ar
                    </p>
                    <p class="small">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Buenos Aires, Argentina
                    </p>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="small mb-0">
                        &copy; 2025 IFTS15. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para manejar los formularios -->
    <script>
        // Manejar envío del formulario de registro
        document.getElementById('registroForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('¡Gracias por tu interés! Pronto nos pondremos en contacto contigo.');
            bootstrap.Modal.getInstance(document.getElementById('modalRegistrar')).hide();
        });
        
        // Manejar envío del formulario de consulta
        document.getElementById('consultaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('¡Tu consulta ha sido enviada! Te responderemos a la brevedad.');
            bootstrap.Modal.getInstance(document.getElementById('modalConsultas')).hide();
        });
        
        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                // Solo si el href no es solo "#"
                if (href && href !== '#') {
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>