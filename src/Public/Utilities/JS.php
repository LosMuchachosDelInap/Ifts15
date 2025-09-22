<?php
/**
 * JavaScript Centralizado - IFTS15
 * Archivo: src/Public/Utilities/JS.php
 * Incluye todos los scripts JavaScript necesarios para el sistema
 */
?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous"></script>

<!-- JavaScript personalizado del sistema -->
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
        const footerText = document.querySelector('footer p');
        if (footerText) {
            footerText.innerHTML = '© ' + currentYear + ' IFTS N° 15. Todos los derechos reservados.';
        }
        
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

        // Manejar offcanvas - Asegurar que funcione correctamente
        const offcanvasElements = document.querySelectorAll('.offcanvas');
        offcanvasElements.forEach(function(offcanvasEl) {
            const offcanvas = new bootstrap.Offcanvas(offcanvasEl);
        });
    });
</script>