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
    // Prevenir errores de focus trap
    document.addEventListener('DOMContentLoaded', function() {
        // Deshabilitar temporalmente los focus traps problemáticos
        const originalFocusTrap = window.bootstrap?.Modal?.prototype?._initializeFocusTrap;
        if (originalFocusTrap) {
            window.bootstrap.Modal.prototype._initializeFocusTrap = function() {
                // No hacer nada para evitar el bucle infinito
            };
        }

        // Auto-ocultar alertas después de 5 segundos
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                try {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                } catch (e) {
                    console.log('Error cerrando alerta:', e);
                }
            }, 5000);
        });
        
        // Inicializar tooltips de forma segura
        try {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        } catch (e) {
            console.log('Error inicializando tooltips:', e);
        }
        
        // Funcionalidad del footer
        const currentYear = new Date().getFullYear();
        const footerText = document.querySelector('footer p');
        if (footerText) {
            footerText.innerHTML = '© ' + currentYear + ' IFTS N° 15. Todos los derechos reservados.';
        }
        
        // Smooth scroll para enlaces internos (mejorado)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                // Solo si el href no es solo "#" y no es un modal
                if (href && href !== '#' && !href.includes('modal')) {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
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