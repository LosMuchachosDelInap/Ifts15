    </div><!-- /.main-content -->
</div><!-- /.row -->
</div><!-- /.container-fluid -->

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

<!-- Debug Script para dropdowns -->
<script>
// Verificar que Bootstrap está cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Debug: Bootstrap cargado?', typeof bootstrap !== 'undefined');
    console.log('🔧 Debug: Dropdowns encontrados:', document.querySelectorAll('.dropdown-toggle').length);
    
    // Debug: Verificar eventos de click en dropdowns
    document.querySelectorAll('.dropdown-toggle').forEach((dropdown, index) => {
        console.log(`🔧 Debug: Dropdown ${index + 1}: ${dropdown.textContent.trim()}`);
        
        dropdown.addEventListener('click', function(e) {
            console.log('🖱️ Dropdown clicked:', this.textContent.trim());
            console.log('🔧 Bootstrap Dropdown instance:', bootstrap.Dropdown.getInstance(this));
        });
        
        // Verificar eventos Bootstrap
        dropdown.addEventListener('show.bs.dropdown', function () {
            console.log('✅ Dropdown showing:', this.textContent.trim());
        });
        
        dropdown.addEventListener('shown.bs.dropdown', function () {
            console.log('✅ Dropdown shown:', this.textContent.trim());
        });
        
        dropdown.addEventListener('hide.bs.dropdown', function () {
            console.log('⏏️ Dropdown hiding:', this.textContent.trim());
        });
    });
});
</script>

<!-- Custom Scripts -->
<script>
// Auto-hide alerts after 5 seconds
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
    
    // Inicializar dropdowns manualmente si es necesario
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    const dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
    
    // Activar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Función para sidebar responsive
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.main-content');
    
    if (sidebar && content) {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('expanded');
    }
}

// Mantener estado del sidebar en localStorage
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const savedState = localStorage.getItem('sidebarCollapsed');
    
    if (savedState === 'true' && sidebar) {
        sidebar.classList.add('collapsed');
        document.querySelector('.main-content')?.classList.add('expanded');
    }
});

// Guardar estado del sidebar
function saveSidebarState() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    }
}
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
