<?php
/**
 * Modal Registrar - IFTS15
 * Componente de modal de registro
 */

// Obtener datos académicos desde la base de datos
use App\ConectionBD\ConectionDB;

$conectarDB = new ConectionDB();
$carreras = $conectarDB->getCarreras();
$comisiones = $conectarDB->getComisiones();
$añosCursada = $conectarDB->getAñosCursada();
?>

<!-- Modal Registrar -->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalRegistrarLabel">
                    <i class="bi bi-person-plus me-2"></i>
                    Crear Cuenta Nueva
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>/src/Controllers/AuthController.php" method="POST" id="formRegistrar">
                <input type="hidden" name="action" value="register">
                <div class="modal-body">
                    <div class="row">
                        <!-- Datos personales -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-person me-1"></i>Datos Personales
                            </h6>
                            
                            <div class="mb-3">
                                <label for="registerNombre" class="form-label">Nombre *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="registerNombre" 
                                       name="nombre" 
                                       required 
                                       placeholder="Tu nombre">
                            </div>
                            
                            <div class="mb-3">
                                <label for="registerApellido" class="form-label">Apellido *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="registerApellido" 
                                       name="apellido" 
                                       required 
                                       placeholder="Tu apellido">
                            </div>
                            
                            <div class="mb-3">
                                <label for="registerDni" class="form-label">DNI *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="registerDni" 
                                       name="dni" 
                                       required 
                                       pattern="\d{7,8}"
                                       placeholder="12345678">
                            </div>
                            
                            <div class="mb-3">
                                <label for="registerFechaNacimiento" class="form-label">Fecha de Nacimiento *</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="registerFechaNacimiento" 
                                       name="fecha_nacimiento"
                                       required
                                       onchange="calcularEdad()">
                                <small class="form-text text-muted">La edad se calculará automáticamente</small>
                            </div>
                        </div>
                        
                        <!-- Datos de contacto y cuenta -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-envelope me-1"></i>Datos de Cuenta
                            </h6>
                            
                            <div class="mb-3">
                                <label for="registerEmail" class="form-label">Email *</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="registerEmail" 
                                       name="email" 
                                       required 
                                       placeholder="tu.email@ejemplo.com">
                            </div>
                            
                            <div class="mb-3">
                                <label for="registerPassword" class="form-label">Contraseña *</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="registerPassword" 
                                       name="password" 
                                       required 
                                       minlength="6"
                                       placeholder="Mínimo 6 caracteres">
                            </div>
                            
                            <div class="mb-3">
                                <label for="registerConfirmPassword" class="form-label">Confirmar Contraseña *</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="registerConfirmPassword" 
                                       name="confirm_password" 
                                       required 
                                       placeholder="Repetir contraseña">
                            </div>
                            
                            <div class="mb-3">
                                <label for="registerTelefono" class="form-label">Teléfono</label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="registerTelefono" 
                                       name="telefono" 
                                       placeholder="11-1234-5678">
                            </div>
                            
                            <div class="mb-3">
                                <label for="registerEdad" class="form-label">Edad (calculada automáticamente)</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="registerEdad" 
                                       name="edad" 
                                       required
                                       min="16" 
                                       max="99" 
                                       readonly
                                       style="background-color: #f8f9fa;"
                                       placeholder="Se calculará desde la fecha de nacimiento">
                                <small class="form-text text-success" id="edadInfo" style="display: none;">
                                    <i class="bi bi-check-circle me-1"></i>Edad calculada correctamente
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Datos Académicos -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted mb-3 mt-3">
                                <i class="bi bi-mortarboard me-1"></i>Datos Académicos
                            </h6>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="registerCarrera" class="form-label">Carrera *</label>
                                <select class="form-select" id="registerCarrera" name="id_carrera" required>
                                    <option value="">Seleccionar carrera...</option>
                                    <?php foreach ($carreras as $carrera): ?>
                                        <option value="<?= $carrera['id_carrera'] ?>"><?= htmlspecialchars($carrera['carrera']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="registerComision" class="form-label">Comisión *</label>
                                <select class="form-select" id="registerComision" name="id_comision" required>
                                    <option value="">Seleccionar comisión...</option>
                                    <?php foreach ($comisiones as $comision): ?>
                                        <option value="<?= $comision['id_comision'] ?>">Comisión <?= htmlspecialchars($comision['comision']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="registerAñoCursada" class="form-label">Año a Cursar *</label>
                                <select class="form-select" id="registerAñoCursada" name="id_añoCursada" required>
                                    <option value="">Seleccionar año...</option>
                                    <?php foreach ($añosCursada as $año): ?>
                                        <option value="<?= $año['id_añoCursada'] ?>"><?= $año['año'] ?>° Año</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Términos y condiciones -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="aceptarTerminos" 
                                       required>
                                <label class="form-check-label small" for="aceptarTerminos">
                                    Acepto los 
                                    <a href="javascript:void(0)" class="text-decoration-none">términos y condiciones</a> 
                                    y la 
                                    <a href="javascript:void(0)" class="text-decoration-none">política de privacidad</a> 
                                    del IFTS15.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-person-plus me-1"></i>Crear Cuenta
                    </button>
                </div>
            </form>
            <div class="modal-footer border-top-0 pt-0">
                <small class="text-muted w-100 text-center">
                    ¿Ya tienes cuenta? 
                    <a href="#modalLogin" 
                       data-bs-dismiss="modal" 
                       data-bs-toggle="modal" 
                       data-bs-target="#modalLogin"
                       class="text-decoration-none">Inicia sesión aquí</a>
                </small>
            </div>
        </div>
    </div>
</div>

<script>
// Función para calcular la edad automáticamente
function calcularEdad() {
    const fechaNacimiento = document.getElementById('registerFechaNacimiento').value;
    const edadInput = document.getElementById('registerEdad');
    const edadInfo = document.getElementById('edadInfo');
    
    if (fechaNacimiento) {
        const fechaNac = new Date(fechaNacimiento);
        const hoy = new Date();
        
        // Validar que la fecha no sea futura
        if (fechaNac > hoy) {
            edadInput.value = '';
            edadInput.setCustomValidity('La fecha de nacimiento no puede ser futura');
            edadInfo.style.display = 'none';
            return;
        }
        
        // Calcular edad
        let edad = hoy.getFullYear() - fechaNac.getFullYear();
        const mesActual = hoy.getMonth();
        const mesNacimiento = fechaNac.getMonth();
        
        // Ajustar si aún no ha cumplido años este año
        if (mesActual < mesNacimiento || (mesActual === mesNacimiento && hoy.getDate() < fechaNac.getDate())) {
            edad--;
        }
        
        // Validar edad mínima y máxima
        if (edad < 16) {
            edadInput.value = edad;
            edadInput.setCustomValidity('Debes tener al menos 16 años para registrarte');
            edadInfo.style.display = 'none';
        } else if (edad > 99) {
            edadInput.value = edad;
            edadInput.setCustomValidity('Edad máxima permitida: 99 años');
            edadInfo.style.display = 'none';
        } else {
            edadInput.value = edad;
            edadInput.setCustomValidity('');
            edadInfo.style.display = 'block';
        }
    } else {
        edadInput.value = '';
        edadInput.setCustomValidity('La fecha de nacimiento es requerida');
        edadInfo.style.display = 'none';
    }
}

// Validar que las contraseñas coincidan
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('registerPassword');
    const confirmPassword = document.getElementById('registerConfirmPassword');
    
    function validarPasswords() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Las contraseñas no coinciden');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validarPasswords);
    confirmPassword.addEventListener('input', validarPasswords);
});
</script>