<?php
/**
 * Dashboard Principal - IFTS15
 * Solo para usuarios logueados
 */

require_once '../includes/init.php';

// Verificar que esté logueado
if (!isLoggedIn()) {
    redirect('/login.php');
}

$pageTitle = 'Dashboard';
$currentUser = getCurrentUser();
$userRole = $currentUser['role'] ?? 'estudiante';

?>

<?php include '../layouts/header.php'; ?>

<div class="main-content">
    <div class="container-fluid">
        <!-- Hero personalizado -->
        <div class="hero-section">
            <h1>
                <i class="fa fa-tachometer-alt"></i>
                ¡Bienvenido, <?php echo htmlspecialchars($currentUser['nombre']); ?>!
            </h1>
            <p class="lead">
                Panel de control - <?php echo ucfirst($userRole); ?>
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <?php if ($userRole === 'estudiante'): ?>
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-book fa-2x me-3"></i>
                            <div>
                                <h5 class="card-title">Mis Materias</h5>
                                <h3>6</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-star fa-2x me-3"></i>
                            <div>
                                <h5 class="card-title">Promedio</h5>
                                <h3>8.5</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php elseif ($userRole === 'profesor'): ?>
            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-chalkboard-teacher fa-2x me-3"></i>
                            <div>
                                <h5 class="card-title">Mis Cursos</h5>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-users fa-2x me-3"></i>
                            <div>
                                <h5 class="card-title">Estudiantes</h5>
                                <h3>85</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="col-md-3 mb-3">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-envelope fa-2x me-3"></i>
                            <div>
                                <h5 class="card-title">Mensajes</h5>
                                <h3>3</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fa fa-bolt"></i>
                            Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php if ($userRole === 'estudiante'): ?>
                            <div class="col-md-6 mb-3">
                                <a href="<?php echo SITE_URL; ?>/pages/mis-materias.php" class="quick-access-card">
                                    <i class="fa fa-book fa-2x mb-2"></i>
                                    <h6>Ver Materias</h6>
                                    <small>Consulta tu cronograma académico</small>
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="<?php echo SITE_URL; ?>/pages/calificaciones.php" class="quick-access-card">
                                    <i class="fa fa-star fa-2x mb-2"></i>
                                    <h6>Calificaciones</h6>
                                    <small>Revisa tus notas y promedio</small>
                                </a>
                            </div>
                            <?php elseif ($userRole === 'profesor'): ?>
                            <div class="col-md-6 mb-3">
                                <a href="<?php echo SITE_URL; ?>/pages/mis-cursos.php" class="quick-access-card">
                                    <i class="fa fa-chalkboard-teacher fa-2x mb-2"></i>
                                    <h6>Mis Cursos</h6>
                                    <small>Administra tus materias</small>
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="<?php echo SITE_URL; ?>/pages/calificar.php" class="quick-access-card">
                                    <i class="fa fa-edit fa-2x mb-2"></i>
                                    <h6>Calificar</h6>
                                    <small>Registra notas de estudiantes</small>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fa fa-bullhorn"></i>
                            Últimos Anuncios
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <h6 class="mb-1">Inscripciones Abiertas</h6>
                                <p class="mb-1 small">Período de inscripción para el próximo cuatrimestre...</p>
                                <small class="text-muted">Hace 2 días</small>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <h6 class="mb-1">Nuevo Laboratorio</h6>
                                <p class="mb-1 small">Inauguración del laboratorio de Ciencia de Datos...</p>
                                <small class="text-muted">Hace 1 semana</small>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="<?php echo SITE_URL; ?>/pages/anuncios.php" class="btn btn-outline-primary btn-sm">
                                Ver todos los anuncios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>
