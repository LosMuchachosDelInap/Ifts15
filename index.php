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
                <div >

                    <!-- Carreras Destacadas -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h2 class="h4 mb-3">
                                <i class="fa fa-graduation-cap"></i>
                                Nuestras Carreras
                            </h2>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fa fa-laptop-code text-primary"></i>
                                        Análisis de Sistemas
                                    </h5>
                                    <p class="card-text">
                                        Formamos profesionales capaces de analizar, diseñar e implementar
                                        sistemas de información.
                                    </p>
                                    <a href="<?php echo SITE_URL; ?>/pages/analisis-sistemas-nuevo.php" class="btn btn-primary btn-sm">Ver más</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fa fa-brain text-success"></i>
                                        Ciencia de Datos e IA
                                    </h5>
                                    <p class="card-text">
                                        Carrera de vanguardia enfocada en análisis de datos,
                                        machine learning e inteligencia artificial.
                                    </p>
                                    <a href="<?php echo SITE_URL; ?>/pages/ciencia-datos-ia.php" class="btn btn-success btn-sm">Ver más</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fa fa-university text-warning"></i>
                                        Administración Pública
                                    </h5>
                                    <p class="card-text">
                                        Formación integral para el desempeño en organismos
                                        del sector público.
                                    </p>
                                    <a href="<?php echo SITE_URL; ?>/pages/administracion-publica.php" class="btn btn-warning btn-sm">Ver más</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accesos Rápidos -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h2 class="h4 mb-3">
                                <i class="fa fa-bolt"></i>
                                Accesos Rápidos
                            </h2>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fa fa-clock fa-2x text-info mb-2"></i>
                                    <h6 class="card-title">Horarios</h6>
                                    <a href="<?php echo SITE_URL; ?>/pages/horarios.php" class="btn btn-outline-info btn-sm">Ver</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fa fa-file-alt fa-2x text-secondary mb-2"></i>
                                    <h6 class="card-title">SIU-Guaraní</h6>
                                    <a href="<?php echo SITE_URL; ?>/pages/siu-guarani.php" class="btn btn-outline-secondary btn-sm">Acceder</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fa fa-question-circle fa-2x text-primary mb-2"></i>
                                    <h6 class="card-title">Consultas</h6>
                                    <a href="<?php echo SITE_URL; ?>/pages/consultas.php" class="btn btn-outline-primary btn-sm">Hacer</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fa fa-newspaper fa-2x text-danger mb-2"></i>
                                    <h6 class="card-title">Novedades</h6>
                                    <a href="<?php echo SITE_URL; ?>/pages/noticias-actuales.php" class="btn btn-outline-danger btn-sm">Leer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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