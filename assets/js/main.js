/**
 * JavaScript personalizado para IFTS15 Sistema Web
 * Archivo: assets/js/main.js
 */

// Variables globales
let sidebarState = localStorage.getItem('sidebarCollapsed') === 'true';

// Inicializar cuando el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

/**
 * Inicializar aplicación
 */
function initializeApp() {
    initializeSidebar();
    initializeAlerts();
    initializeTooltips();
    initializeDropdowns();
    initializeNavbarEvents();
    initializeForms();
    initializeCarousel();
    initializeTheme();
    
    console.log('🚀 IFTS15 Sistema Web inicializado correctamente');
}

/**
 * Inicializar carrusel
 */
function initializeCarousel() {
    const carousel = document.getElementById('heroCarousel');
    if (carousel) {
        // Configurar carrusel automático
        const carouselInstance = new bootstrap.Carousel(carousel, {
            interval: 5000, // 5 segundos
            ride: 'carousel',
            pause: 'hover'
        });
        
        console.log('✅ Carrusel inicializado');
    }
}

/**
 * Inicializar dropdowns de Bootstrap
 */
function initializeDropdowns() {
    // Inicializar todos los dropdowns manualmente
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    const dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl, {
            boundary: 'viewport',
            autoClose: true
        });
    });
    
    console.log('✅ Dropdowns inicializados:', dropdownList.length);
}

/**
 * Inicializar sidebar
 */
function initializeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.main-content');
    
    if (!sidebar || !content) return;
    
    // Aplicar estado guardado
    if (sidebarState) {
        sidebar.classList.add('collapsed');
        content.classList.add('expanded');
    }
    
    // Toggle button functionality
    const toggleButton = document.getElementById('sidebarToggle');
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }
    
    // Auto-collapse en móviles
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
        content.classList.add('expanded');
    }
}

/**
 * Toggle sidebar
 */
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.main-content');
    
    if (!sidebar || !content) return;
    
    sidebar.classList.toggle('collapsed');
    content.classList.toggle('expanded');
    
    // Guardar estado
    sidebarState = sidebar.classList.contains('collapsed');
    localStorage.setItem('sidebarCollapsed', sidebarState);
    
    // Trigger resize event para componentes que lo necesiten
    window.dispatchEvent(new Event('resize'));
}

/**
 * Inicializar alertas auto-hide
 */
function initializeAlerts() {
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    
    alerts.forEach(alert => {
        // Auto-hide después de 5 segundos
        setTimeout(() => {
            hideAlert(alert);
        }, 5000);
        
        // Close button functionality
        const closeButton = alert.querySelector('.btn-close');
        if (closeButton) {
            closeButton.addEventListener('click', () => hideAlert(alert));
        }
    });
}

/**
 * Ocultar alerta con animación
 */
function hideAlert(alert) {
    if (!alert) return;
    
    alert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-20px)';
    
    setTimeout(() => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    }, 300);
}

/**
 * Mostrar alerta programáticamente
 */
function showAlert(message, type = 'info', permanent = false) {
    const alertContainer = document.getElementById('alertContainer') || document.body;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show ${permanent ? 'alert-permanent' : ''}`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" aria-label="Close"></button>
    `;
    
    alertContainer.insertBefore(alertDiv, alertContainer.firstChild);
    
    // Inicializar para esta alerta específica
    if (!permanent) {
        setTimeout(() => hideAlert(alertDiv), 5000);
    }
    
    const closeButton = alertDiv.querySelector('.btn-close');
    if (closeButton) {
        closeButton.addEventListener('click', () => hideAlert(alertDiv));
    }
}

/**
 * Inicializar tooltips de Bootstrap
 */
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

/**
 * Inicializar funcionalidad de formularios
 */
function initializeForms() {
    // Validación en tiempo real
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', validateForm);
        
        // Validación en tiempo real para campos
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => validateField(input));
            input.addEventListener('input', () => clearFieldError(input));
        });
    });
    
    // Auto-focus en primer campo
    const firstInput = document.querySelector('form input:not([type="hidden"]):first-of-type');
    if (firstInput) {
        firstInput.focus();
    }
}

/**
 * Validar formulario
 */
function validateForm(event) {
    const form = event.target;
    let isValid = true;
    
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        event.preventDefault();
        showAlert('Por favor corrige los errores en el formulario', 'danger');
    }
    
    return isValid;
}

/**
 * Validar campo individual
 */
function validateField(field) {
    clearFieldError(field);
    
    let isValid = true;
    let errorMessage = '';
    
    // Validación de campo requerido
    if (field.hasAttribute('required') && !field.value.trim()) {
        isValid = false;
        errorMessage = 'Este campo es requerido';
    }
    
    // Validación de email
    if (field.type === 'email' && field.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(field.value)) {
            isValid = false;
            errorMessage = 'Ingresa un email válido';
        }
    }
    
    // Validación de longitud mínima
    if (field.hasAttribute('minlength')) {
        const minLength = parseInt(field.getAttribute('minlength'));
        if (field.value.length < minLength) {
            isValid = false;
            errorMessage = `Mínimo ${minLength} caracteres`;
        }
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    }
    
    return isValid;
}

/**
 * Mostrar error en campo
 */
function showFieldError(field, message) {
    field.classList.add('is-invalid');
    
    let errorDiv = field.parentNode.querySelector('.invalid-feedback');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        field.parentNode.appendChild(errorDiv);
    }
    
    errorDiv.textContent = message;
}

/**
 * Limpiar error de campo
 */
function clearFieldError(field) {
    field.classList.remove('is-invalid');
    const errorDiv = field.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

/**
 * Inicializar tema
 */
function initializeTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);
}

/**
 * Aplicar tema
 */
function applyTheme(theme) {
    document.body.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
}

/**
 * Toggle tema
 */
function toggleTheme() {
    const currentTheme = document.body.getAttribute('data-theme') || 'light';
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    applyTheme(newTheme);
}

/**
 * Utilidades
 */
const Utils = {
    /**
     * Formatear fecha
     */
    formatDate: function(date, format = 'dd/mm/yyyy') {
        if (!(date instanceof Date)) {
            date = new Date(date);
        }
        
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        
        return format
            .replace('dd', day)
            .replace('mm', month)
            .replace('yyyy', year);
    },
    
    /**
     * Copiar al portapapeles
     */
    copyToClipboard: function(text) {
        navigator.clipboard.writeText(text).then(() => {
            showAlert('Copiado al portapapeles', 'success');
        }).catch(() => {
            showAlert('Error al copiar', 'danger');
        });
    },
    
    /**
     * Scroll suave a elemento
     */
    scrollTo: function(element, offset = 0) {
        const targetElement = typeof element === 'string' ? 
            document.querySelector(element) : element;
        
        if (targetElement) {
            const targetPosition = targetElement.offsetTop - offset;
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    },
    
    /**
     * Debounce función
     */
    debounce: function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
};

/**
 * Manejar redimensionado de ventana
 */
window.addEventListener('resize', Utils.debounce(function() {
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.main-content');
    
    if (window.innerWidth <= 768) {
        if (sidebar && !sidebar.classList.contains('collapsed')) {
            sidebar.classList.add('collapsed');
            content?.classList.add('expanded');
        }
    }
}, 250));

/**
 * Manejar errores globales
 */
window.addEventListener('error', function(e) {
    console.error('Error capturado:', e.error);
    if (window.DEBUG_MODE) {
        showAlert(`Error: ${e.error.message}`, 'danger', true);
    }
});

// Exportar para uso global
window.IFTS15 = {
    toggleSidebar,
    showAlert,
    hideAlert,
    toggleTheme,
    Utils
};

/**
 * Funciones para modales de login/registro
 */
function switchToRegister() {
    // Cerrar modal de login
    const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
    if (loginModal) {
        loginModal.hide();
    }
    
    // Abrir modal de registro
    setTimeout(() => {
        const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
        registerModal.show();
    }, 300);
}

function switchToLogin() {
    // Cerrar modal de registro
    const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
    if (registerModal) {
        registerModal.hide();
    }
    
    // Abrir modal de login
    setTimeout(() => {
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }, 300);
}

/**
 * Inicializar eventos específicos del navbar
 */
function initializeNavbarEvents() {
    // Debug: Verificar que los botones de modal se inicialicen
    const loginBtn = document.querySelector('[data-bs-target="#loginModal"]');
    const registerBtn = document.querySelector('[data-bs-target="#registerModal"]');
    
    if (loginBtn) {
        console.log('✅ Botón de login modal encontrado');
        loginBtn.addEventListener('click', function() {
            console.log('🖱️ Botón de login modal clickeado');
        });
    }
    
    if (registerBtn) {
        console.log('✅ Botón de registro modal encontrado');
        registerBtn.addEventListener('click', function() {
            console.log('🖱️ Botón de registro modal clickeado');
        });
    }
    
    // Auto-focus en el primer campo cuando se abre un modal
    document.getElementById('loginModal')?.addEventListener('shown.bs.modal', function () {
        document.getElementById('modalLoginEmail')?.focus();
    });
    
    document.getElementById('registerModal')?.addEventListener('shown.bs.modal', function () {
        document.getElementById('modalRegisterNombre')?.focus();
    });
}

// Hacer funciones globales
window.switchToRegister = switchToRegister;
window.switchToLogin = switchToLogin;
