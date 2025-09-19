<?php
/**
 * Modal de Consultas - IFTS15
 * Archivo: src/Components/modalConsultas.php
 */

// Procesar formulario si viene por AJAX
if (isset($_POST['action']) && $_POST['action'] === 'enviar_consulta_modal') {
    header('Content-Type: application/json');
    
    $response = ['success' => false, 'message' => ''];
    
    $nombre = sanitize($_POST['nombre'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $telefono = sanitize($_POST['telefono'] ?? '');
    $carrera = sanitize($_POST['carrera'] ?? '');
    $consulta = sanitize($_POST['consulta'] ?? '');
    
    if (empty($nombre) || empty($email) || empty($consulta)) {
        $response['message'] = 'Por favor completa todos los campos obligatorios';
    } else {
        // Aquí se podría enviar un email o guardar en BD
        $response['success'] = true;
        $response['message'] = 'Tu consulta ha sido enviada correctamente. Te responderemos a la brevedad.';
    }
    
    echo json_encode($response);
    exit;
}
?>

<!-- Modal de Consultas -->
<div class="modal fade" id="consultasModal" tabindex="-1" aria-labelledby="consultasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="consultasModalLabel">
                    <i class="fa fa-question-circle"></i> 
                    Consultas y Contacto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Formulario de consultas -->
                    <div class="col-lg-8">
                        <div class="consultas-form-container">
                            <h6 class="mb-3 text-primary">
                                <i class="fa fa-envelope"></i>
                                Envíanos tu consulta
                            </h6>
                            
                            <!-- Área de alertas -->
                            <div id="consultasAlert" class="alert d-none" role="alert"></div>
                            
                            <form id="consultasModalForm">
                                <input type="hidden" name="action" value="enviar_consulta_modal">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="modalNombre" class="form-label">
                                            <i class="fa fa-user"></i> Nombre completo *
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="modalNombre" 
                                               name="nombre" 
                                               required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="modalEmail" class="form-label">
                                            <i class="fa fa-envelope"></i> Email *
                                        </label>
                                        <input type="email" 
                                               class="form-control" 
                                               id="modalEmail" 
                                               name="email" 
                                               required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="modalTelefono" class="form-label">
                                            <i class="fa fa-phone"></i> Teléfono
                                        </label>
                                        <input type="tel" 
                                               class="form-control" 
                                               id="modalTelefono" 
                                               name="telefono">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="modalCarrera" class="form-label">
                                            <i class="fa fa-graduation-cap"></i> Carrera de interés
                                        </label>
                                        <select class="form-control" id="modalCarrera" name="carrera">
                                            <option value="">Seleccionar carrera...</option>
                                            <option value="realizador-tv">Realizador y Productor Televisivo</option>
                                            <option value="analisis-sistemas">Análisis de Sistemas</option>
                                            <option value="ciencia-datos">Ciencia de Datos e IA</option>
                                            <option value="admin-publica">Administración Pública</option>
                                            <option value="otro">Otro / Información general</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="modalConsulta" class="form-label">
                                        <i class="fa fa-comment"></i> Tu consulta *
                                    </label>
                                    <textarea class="form-control" 
                                              id="modalConsulta" 
                                              name="consulta" 
                                              rows="4" 
                                              placeholder="Escribe aquí tu consulta..." 
                                              required></textarea>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg" id="btnEnviarConsulta">
                                        <i class="fa fa-paper-plane"></i>
                                        Enviar Consulta
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Información de contacto -->
                    <div class="col-lg-4">
                        <div class="consultas-info-container">
                            <div class="info-section mb-4">
                                <h6 class="text-primary">
                                    <i class="fa fa-info-circle"></i>
                                    Información de Contacto
                                </h6>
                                
                                <div class="contact-item mb-3">
                                    <div class="contact-icon">
                                        <i class="fa fa-map-marker-alt text-danger"></i>
                                    </div>
                                    <div class="contact-content">
                                        <strong>Dirección</strong>
                                        <p class="small text-muted">
                                            Av. Corrientes 1234<br>
                                            Ciudad Autónoma de Buenos Aires<br>
                                            CP: C1043AAZ
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="contact-item mb-3">
                                    <div class="contact-icon">
                                        <i class="fa fa-phone text-success"></i>
                                    </div>
                                    <div class="contact-content">
                                        <strong>Teléfonos</strong>
                                        <p class="small text-muted">
                                            <strong>Secretaría:</strong> (011) 4123-4567<br>
                                            <strong>Admisiones:</strong> (011) 4123-4568<br>
                                            <strong>WhatsApp:</strong> (011) 15-1234-5678
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="contact-item mb-3">
                                    <div class="contact-icon">
                                        <i class="fa fa-envelope text-info"></i>
                                    </div>
                                    <div class="contact-content">
                                        <strong>Emails</strong>
                                        <p class="small text-muted">
                                            <strong>General:</strong> info@ifts15.edu.ar<br>
                                            <strong>Admisiones:</strong> admisiones@ifts15.edu.ar<br>
                                            <strong>Académico:</strong> academico@ifts15.edu.ar
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="contact-item mb-4">
                                    <div class="contact-icon">
                                        <i class="fa fa-clock text-warning"></i>
                                    </div>
                                    <div class="contact-content">
                                        <strong>Horarios de Atención</strong>
                                        <p class="small text-muted">
                                            <strong>Lunes a Viernes:</strong> 9:00 a 18:00 hs<br>
                                            <strong>Sábados:</strong> 9:00 a 13:00 hs<br>
                                            <strong>Domingos:</strong> Cerrado
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Redes sociales -->
                            <div class="info-section mb-4">
                                <h6 class="text-primary">
                                    <i class="fa fa-share-alt"></i>
                                    Síguenos
                                </h6>
                                <div class="social-buttons">
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-facebook"></i> Facebook
                                    </a>
                                    <a href="#" class="btn btn-outline-info btn-sm">
                                        <i class="fa fa-twitter"></i> Twitter
                                    </a>
                                    <a href="#" class="btn btn-outline-danger btn-sm">
                                        <i class="fa fa-instagram"></i> Instagram
                                    </a>
                                    <a href="#" class="btn btn-outline-dark btn-sm">
                                        <i class="fa fa-youtube"></i> YouTube
                                    </a>
                                </div>
                            </div>
                            
                            <!-- FAQ -->
                            <div class="info-section">
                                <h6 class="text-primary">
                                    <i class="fa fa-question"></i>
                                    Preguntas Frecuentes
                                </h6>
                                <p class="small text-muted">
                                    ¿Tienes preguntas frecuentes? Consulta nuestra sección de 
                                    preguntas frecuentes donde respondemos las dudas más comunes.
                                </p>
                                <a href="<?php echo BASE_URL; ?>/pages/faq.php" class="btn btn-outline-success btn-sm">
                                    <i class="fa fa-book"></i> Ver FAQ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i> Cerrar
                </button>
                <a href="<?php echo BASE_URL; ?>/pages/consultas.php" class="btn btn-outline-primary">
                    <i class="fa fa-external-link-alt"></i> Ver página completa
                </a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript del Modal de Consultas -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const consultasForm = document.getElementById('consultasModalForm');
    const consultasAlert = document.getElementById('consultasAlert');
    const btnEnviar = document.getElementById('btnEnviarConsulta');
    
    if (consultasForm) {
        consultasForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validación básica
            const nombre = document.getElementById('modalNombre').value.trim();
            const email = document.getElementById('modalEmail').value.trim();
            const consulta = document.getElementById('modalConsulta').value.trim();
            
            if (!nombre || !email || !consulta) {
                showAlert('Por favor completa todos los campos obligatorios (*)', 'danger');
                return;
            }
            
            if (!email.includes('@')) {
                showAlert('Por favor ingresa un email válido', 'danger');
                return;
            }
            
            // Deshabilitar botón y mostrar loading
            btnEnviar.disabled = true;
            btnEnviar.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Enviando...';
            
            // Enviar por fetch (simulado)
            setTimeout(() => {
                showAlert('Tu consulta ha sido enviada correctamente. Te responderemos a la brevedad.', 'success');
                consultasForm.reset();
                btnEnviar.disabled = false;
                btnEnviar.innerHTML = '<i class="fa fa-paper-plane"></i> Enviar Consulta';
                
                // Cerrar modal después de 2 segundos
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('consultasModal'));
                    if (modal) {
                        modal.hide();
                    }
                }, 2000);
            }, 1500);
        });
    }
    
    function showAlert(message, type) {
        consultasAlert.className = `alert alert-${type}`;
        consultasAlert.innerHTML = `<i class="fa fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i> ${message}`;
        consultasAlert.classList.remove('d-none');
        
        // Auto-hide después de 5 segundos
        setTimeout(() => {
            consultasAlert.classList.add('d-none');
        }, 5000);
    }
    
    // Limpiar alertas cuando se cierre el modal
    document.getElementById('consultasModal').addEventListener('hidden.bs.modal', function() {
        consultasAlert.classList.add('d-none');
        consultasForm.reset();
        btnEnviar.disabled = false;
        btnEnviar.innerHTML = '<i class="fa fa-paper-plane"></i> Enviar Consulta';
    });
});
</script>