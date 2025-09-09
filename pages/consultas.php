<?php
/**
 * Página de Consultas - IFTS15
 */

require_once '../includes/init.php';

$pageTitle = 'Consultas';
$success = '';
$error = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = sanitize($_POST['nombre'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $telefono = sanitize($_POST['telefono'] ?? '');
    $carrera = sanitize($_POST['carrera'] ?? '');
    $consulta = sanitize($_POST['consulta'] ?? '');
    
    if (empty($nombre) || empty($email) || empty($consulta)) {
        $error = 'Por favor completa todos los campos obligatorios';
    } else {
        // Aquí se podría enviar un email o guardar en BD
        $success = 'Tu consulta ha sido enviada correctamente. Te responderemos a la brevedad.';
        
        // Limpiar formulario
        $nombre = $email = $telefono = $carrera = $consulta = '';
    }
}

?>

<?php include '../layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="hero-section">
                <h1>
                    <i class="fa fa-question-circle"></i>
                    Consultas y Contacto
                </h1>
                <p class="lead">
                    ¿Tienes dudas sobre nuestras carreras? ¡Estamos aquí para ayudarte!
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Formulario de consultas -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fa fa-envelope"></i>
                        Envíanos tu consulta
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i>
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">
                                    <i class="fa fa-user"></i> Nombre completo *
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="<?php echo htmlspecialchars($nombre ?? ''); ?>"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fa fa-envelope"></i> Email *
                                </label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo htmlspecialchars($email ?? ''); ?>"
                                       required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">
                                    <i class="fa fa-phone"></i> Teléfono
                                </label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="<?php echo htmlspecialchars($telefono ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="carrera" class="form-label">
                                    <i class="fa fa-graduation-cap"></i> Carrera de interés
                                </label>
                                <select class="form-control" id="carrera" name="carrera">
                                    <option value="">Seleccionar carrera...</option>
                                    <option value="realizador-tv" <?php echo ($carrera ?? '') === 'realizador-tv' ? 'selected' : ''; ?>>
                                        Realizador y Productor Televisivo
                                    </option>
                                    <option value="analisis-sistemas" <?php echo ($carrera ?? '') === 'analisis-sistemas' ? 'selected' : ''; ?>>
                                        Análisis de Sistemas
                                    </option>
                                    <option value="ciencia-datos" <?php echo ($carrera ?? '') === 'ciencia-datos' ? 'selected' : ''; ?>>
                                        Ciencia de Datos e IA
                                    </option>
                                    <option value="admin-publica" <?php echo ($carrera ?? '') === 'admin-publica' ? 'selected' : ''; ?>>
                                        Administración Pública
                                    </option>
                                    <option value="otro">Otro / Información general</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="consulta" class="form-label">
                                <i class="fa fa-comment"></i> Tu consulta *
                            </label>
                            <textarea class="form-control" 
                                      id="consulta" 
                                      name="consulta" 
                                      rows="5" 
                                      placeholder="Escribe aquí tu consulta..." 
                                      required><?php echo htmlspecialchars($consulta ?? ''); ?></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-paper-plane"></i>
                                Enviar Consulta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Información de contacto -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-info-circle"></i>
                        Información de Contacto
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="fa fa-map-marker-alt text-danger"></i> Dirección</h6>
                        <p class="text-muted small">
                            Av. Corrientes 1234<br>
                            Ciudad Autónoma de Buenos Aires<br>
                            CP: C1043AAZ
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fa fa-phone text-success"></i> Teléfonos</h6>
                        <p class="text-muted small">
                            <strong>Secretaría:</strong> (011) 4123-4567<br>
                            <strong>Admisiones:</strong> (011) 4123-4568<br>
                            <strong>WhatsApp:</strong> (011) 15-1234-5678
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fa fa-envelope text-info"></i> Emails</h6>
                        <p class="text-muted small">
                            <strong>General:</strong> info@ifts15.edu.ar<br>
                            <strong>Admisiones:</strong> admisiones@ifts15.edu.ar<br>
                            <strong>Académico:</strong> academico@ifts15.edu.ar
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="fa fa-clock text-warning"></i> Horarios de Atención</h6>
                        <p class="text-muted small">
                            <strong>Lunes a Viernes:</strong> 9:00 a 18:00 hs<br>
                            <strong>Sábados:</strong> 9:00 a 13:00 hs<br>
                            <strong>Domingos:</strong> Cerrado
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Redes sociales -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-share-alt"></i>
                        Síguenos
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="btn-group-vertical d-grid gap-2" role="group">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fa fa-facebook"></i> Facebook
                        </a>
                        <a href="#" class="btn btn-outline-info">
                            <i class="fa fa-twitter"></i> Twitter
                        </a>
                        <a href="#" class="btn btn-outline-danger">
                            <i class="fa fa-instagram"></i> Instagram
                        </a>
                        <a href="#" class="btn btn-outline-dark">
                            <i class="fa fa-youtube"></i> YouTube
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Preguntas frecuentes -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-question"></i>
                        FAQ
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small">
                        ¿Tienes preguntas frecuentes? Consulta nuestra sección de 
                        preguntas frecuentes donde respondemos las dudas más comunes.
                    </p>
                    <a href="<?php echo SITE_URL; ?>/pages/faq.php" class="btn btn-outline-success btn-sm">
                        <i class="fa fa-book"></i> Ver FAQ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre').value.trim();
        const email = document.getElementById('email').value.trim();
        const consulta = document.getElementById('consulta').value.trim();
        
        if (!nombre || !email || !consulta) {
            e.preventDefault();
            alert('Por favor completa todos los campos obligatorios (*)');
            return false;
        }
        
        if (!email.includes('@')) {
            e.preventDefault();
            alert('Por favor ingresa un email válido');
            return false;
        }
    });
});
</script>

<?php include '../layouts/footer.php'; ?>
