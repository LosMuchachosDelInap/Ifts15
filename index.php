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

        <!-- Header Main con Logo -->
        <div class="header-main">
            <div class="container-fluid">
                <nav class="navbar navbar-light bg-faded navbar-expand">
                    <a href="<?php echo SITE_URL; ?>/index.php" class="navbar-brand has-logo">
                        <span class="logo">
                            <img src="<?php echo SITE_URL; ?>/pluginfile.php/1/theme_academi/logo/1756827567/logo-ok.png" alt="<?php echo SITE_NAME; ?>">
                        </span>
                    </a>

                    <!-- Navegación Principal -->
                    <div class="primary-navigation">
                        <nav class="moremenu navigation">
                            <ul class="nav more-nav navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo SITE_URL; ?>/index.php">
                                        <i class="fa fa-home"></i> Home
                                    </a>
                                </li>
                                
                                <!-- Instituto Dropdown -->
                                <li class="dropdown nav-item">
                                    <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                        <i class="fa fa-building"></i> Instituto
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/nosotros.php">Nosotros</a></li>
                                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/docentes.php">Nuestros docentes</a></li>
                                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/regimen-estudios.php">Régimen de Estudios</a></li>
                                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/regimen-convivencia.php">Régimen de Convivencia</a></li>
                                    </ul>
                                </li>
                                
                                <!-- Carreras Dropdown -->
                                <li class="dropdown nav-item">
                                    <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                        <i class="fa fa-graduation-cap"></i> Carreras
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/administracion-publica.php">Administración Pública</a></li>
                                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/analisis-sistemas-nuevo.php">Análisis de Sistemas (Nuevo)</a></li>
                                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/ciencia-datos-ia.php">Ciencia de Datos e IA</a></li>
                                        <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/pages/gestion-parlamentaria.php">Gestión Parlamentaria</a></li>
                                    </ul>
                                </li>
                                
                                <!-- Enlaces directos -->
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo SITE_URL; ?>/pages/preguntas-frecuentes.php">
                                        <i class="fa fa-question-circle"></i> FAQ
                                    </a>
                                </li>
                                
                                <?php if ($isLoggedIn): ?>
                                    <?php if (hasRole('admin')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo SITE_URL; ?>/admin/dashboard.php">
                                                <i class="fa fa-cogs"></i> Admin
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo SITE_URL; ?>/login.php">
                                            <i class="fa fa-sign-in-alt"></i> Ingresar
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div id="page" class="container-fluid d-print-block">
            <div id="page-content" class="row">
                <div id="region-main-box" class="col-12">
                    <section id="region-main" class="col-md-9" aria-label="Contenido">
                        <span id="maincontent"></span>
                        
                        <!-- Contenido de la página principal -->
                        <div class="container-fluid">
                            
                            <!-- Hero Section -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h1 class="h3 mb-0">
                                                <i class="fa fa-home"></i> 
                                                Bienvenido al <?php echo SITE_NAME; ?>
                                            </h1>
                                        </div>
                                        <div class="card-body">
                                            <p class="lead">
                                                <?php echo SITE_DESCRIPTION; ?>
                                            </p>
                                            <p>
                                                Nuestro instituto tiene como misión la formación de Técnicos Superiores con habilidades, 
                                                competencias y capacidades de alto nivel adecuadas a las demandas sociales, 
                                                a los avances científicos y tecnológicos y a los requerimientos productivos.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

                            <!-- Información de Contacto -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h3 class="h5 mb-0">
                                                <i class="fa fa-envelope"></i> 
                                                Información de Contacto
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Email:</strong> <a href="mailto:ifts12@gmail.com">ifts12@gmail.com</a></p>
                                                    <p><strong>Teléfono:</strong> (011) 4123-4567</p>
                                                    <p><strong>Dirección:</strong> Av. Ejemplo 123, CABA</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>Horarios de atención:</strong></p>
                                                    <p>Lunes a Viernes: 8:00 - 20:00</p>
                                                    <p>Sábados: 8:00 - 14:00</p>
                                                </div>
                                            </div>
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
        <footer class="bg-dark text-light py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5><?php echo SITE_NAME; ?></h5>
                        <p><?php echo SITE_DESCRIPTION; ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Enlaces Útiles</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo SITE_URL; ?>/pages/nosotros.php" class="text-light">Sobre Nosotros</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/pages/preguntas-frecuentes.php" class="text-light">Preguntas Frecuentes</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/pages/consultas.php" class="text-light">Contacto</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Todos los derechos reservados.</p>
                    <p>Desarrollado con ❤️ para la educación técnica superior</p>
                </div>
            </div>
        </footer>

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
