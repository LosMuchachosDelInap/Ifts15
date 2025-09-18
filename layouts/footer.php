        </div><!-- /.container-fluid -->
    </div><!-- /.main-wrapper -->

<!-- Footer -->
<footer class="bg-dark text-white mt-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4">
                <h5><i class="fa fa-graduation-cap"></i> IFTS15</h5>
                <p class="small">
                    Instituto de Formación Técnica Superior N° 15<br>
                    Educación técnica de calidad para el futuro.
                </p>
            </div>
            <div class="col-md-4">
                <h6>Enlaces Útiles</h6>
                <ul class="list-unstyled">
                    <li><a href="<?php echo SITE_URL; ?>/pages/nosotros.php" class="text-light text-decoration-none">
                        <i class="fa fa-chevron-right"></i> Sobre Nosotros
                    </a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/realizador-productor-tv.php" class="text-light text-decoration-none">
                        <i class="fa fa-chevron-right"></i> Nuestra Carrera
                    </a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/biblioteca.php" class="text-light text-decoration-none">
                        <i class="fa fa-chevron-right"></i> Biblioteca
                    </a></li>
                    <li><a href="<?php echo SITE_URL; ?>/pages/consultas.php" class="text-light text-decoration-none">
                        <i class="fa fa-chevron-right"></i> Contacto
                    </a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Contacto</h6>
                <p class="small">
                    <i class="fa fa-map-marker-alt"></i> 
                    Av. Ejemplo 1234, Ciudad Autónoma de Buenos Aires<br>
                    <i class="fa fa-phone"></i> 
                    (011) 4555-1234<br>
                    <i class="fa fa-envelope"></i> 
                    info@ifts15.edu.ar
                </p>
            </div>
        </div>
        <hr class="my-3">
        <div class="row">
            <div class="col-md-6">
                <small>
                    © <?php echo date('Y'); ?> IFTS15. Todos los derechos reservados.
                </small>
            </div>
            <div class="col-md-6 text-md-end">
                <small>
                    Desarrollado para el Instituto de Formación Técnica Superior N° 15
                </small>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>

<!-- Auto-hide alerts script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
    
    // Activar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php if (DEBUG_MODE): ?>
<!-- Debug Info -->
<div class="debug-info bg-warning text-dark p-2 mt-3" style="font-size: 12px;">
    <strong>DEBUG MODE:</strong> 
    Tiempo de carga: <?php echo number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 4); ?>s |
    Usuario: <?php echo isLoggedIn() ? getCurrentUser()['email'] : 'No logueado'; ?> |
    Memoria: <?php echo formatBytes(memory_get_peak_usage(true)); ?>
</div>
<?php endif; ?>

</body>
</html>
