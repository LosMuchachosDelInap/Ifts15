<?php

/**
 * Página Principal - IFTS15 Sistema Web
 * @author: Sistema de Gestión Académica
 * @date: 5 de septiembre de 2025
 */

// Cargar inicialización
require_once 'includes/init.php';

// Configurar página
$pageTitle = 'Home';

// Obtener datos para la página principal
try {
    // Aquí se podrían cargar noticias, anuncios, etc. desde la base de datos
    $noticias = []; // Por ahora vacío, se puede cargar dinámicamente
    $anuncios = []; // Por ahora vacío
} catch (Exception $e) {
    if (DEBUG_MODE) {
        showError("Error al cargar datos: " . $e->getMessage());
    } else {
        showError("Error interno del sistema");
    }
}
?>

<?php include 'layouts/header.php'; ?>

<!-- Carrusel de Imágenes - Ancho completo -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="carousel-image" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('<?php echo SITE_URL; ?>/assets/images/carrussel_3.png');">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Contenidos y Modelos Digitales</h2>
                    <p>Creación y desarrollo de contenidos audiovisuales digitales</p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="carousel-image" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('<?php echo SITE_URL; ?>/assets/images/carrussel_1.png');">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Instituto de Formación Técnica Superior - 15</h2>
                    <p>Carrera: Realizador y Productor Televisivo</p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="carousel-image" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('<?php echo SITE_URL; ?>/assets/images/carrussel_2.png');">
                <div class="carousel-caption d-none d-md-block">
                    <h2>Taller de Prácticas Pre Profesionales</h2>
                    <p>Experiencia práctica en el campo audiovisual</p>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>

<!-- Hero Section - Ancho completo -->
<div class="hero-card">
    <div class="container-fluid p-0">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" 
                                 alt="Logo IFTS15" 
                                 class="img-fluid" 
                                 style="max-height: 150px; width: auto;">
                        </div>
                        <!-- Contenido -->
                        <div class="col-md-9">
                            <h2 class="h3 mb-3 text-primary">
                                <i class="fa fa-graduation-cap me-2"></i>
                                <?php echo SITE_DESCRIPTION; ?>
                            </h2>
                            <p class="lead mb-0">
                                <?php echo CARD_DESCRIPTION; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
<div id="page" class="container-fluid d-print-block">
    <div id="page-content" class="row">
        <div id="region-main-box" class="col-12">
            <section id="region-main" class="col-md-9" aria-label="Contenido">
                <span id="maincontent"></span>
                <!-- Contenido de la página principal -->
                <div></div>
            </section>
        </div>
    </div>
    
    <!-- Carrera Principal - Fuera del contenedor limitado -->
    <div class="container">
        <div class="row mb-4 justify-content-center">
            <div class="col-12 text-center">
                <h2 class="h4 mb-4">
                    <i class="fa fa-graduation-cap"></i>
                    Nuestra Carrera
                </h2>
            </div>

            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card h-100 shadow-lg">
                    <div class="card-body text-center p-4">
                        <h5 class="card-title">
                            <i class="fa fa-video text-primary fs-1 d-block mb-3"></i>
                            Realizador y Productor Televisivo
                        </h5>
                        <p class="card-text lead">
                            Carrera específica del IFTS15. Tecnología Digital plantea una visión 
                            integral de la TV digital como parte del universo audiovisual.
                        </p>
                        <p class="card-text">
                            Formamos profesionales capacitados para desenvolverse en el campo de la 
                            producción audiovisual, con conocimientos técnicos y creativos para el 
                            desarrollo de contenidos televisivos y multimedia.
                        </p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="<?php echo SITE_URL; ?>/pages/realizador-productor-tv.php" class="btn btn-primary btn-lg">
                                <i class="fa fa-info-circle"></i> Ver Información Completa
                            </a>
                            <a href="<?php echo SITE_URL; ?>/pages/consultas.php" class="btn btn-outline-primary btn-lg">
                                <i class="fa fa-envelope"></i> Consultar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'layouts/footer.php'; ?>

</div> <!-- page-wrapper -->

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Funcionalidad básica para el sidebar y dropdowns
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-cerrar alerts después de 5 segundos
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>

</body>

</html>