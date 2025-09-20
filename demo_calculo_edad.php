<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo: Cálculo Automático de Edad - IFTS15</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .demo-container { background: rgba(255,255,255,0.95); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .feature { background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 10px 0; }
        .success { color: #28a745; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="demo-container">
            <div class="text-center mb-4">
                <h1 class="display-5"><i class="bi bi-calculator me-2"></i>Cálculo Automático de Edad</h1>
                <p class="lead">Demostración del nuevo sistema implementado</p>
            </div>

            <!-- Demo del formulario -->
            <div class="row">
                <div class="col-lg-6">
                    <h4><i class="bi bi-calendar-date me-2"></i>Prueba el Sistema</h4>
                    <div class="p-4 border rounded">
                        <div class="mb-3">
                            <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento *</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="fechaNacimiento" 
                                   onchange="calcularEdadDemo()">
                            <small class="form-text text-muted">Selecciona una fecha para ver la edad calculada</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edadCalculada" class="form-label">Edad (calculada automáticamente)</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="edadCalculada" 
                                   readonly
                                   style="background-color: #f8f9fa;"
                                   placeholder="Se calculará desde la fecha de nacimiento">
                            <small class="form-text text-success" id="edadInfo" style="display: none;">
                                <i class="bi bi-check-circle me-1"></i>Edad calculada correctamente
                            </small>
                            <small class="form-text text-danger" id="edadError" style="display: none;">
                                <i class="bi bi-exclamation-circle me-1"></i><span id="errorMsg"></span>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h4><i class="bi bi-gear me-2"></i>Funcionalidades Implementadas</h4>
                    
                    <div class="feature">
                        <h6 class="success"><i class="bi bi-check-circle-fill me-1"></i>Cálculo Automático</h6>
                        <small>La edad se calcula automáticamente cuando seleccionas la fecha de nacimiento</small>
                    </div>
                    
                    <div class="feature">
                        <h6 class="success"><i class="bi bi-shield-check me-1"></i>Validación de Edad</h6>
                        <small>Verifica que tengas al menos 16 años y máximo 99 años</small>
                    </div>
                    
                    <div class="feature">
                        <h6 class="success"><i class="bi bi-calendar-x me-1"></i>Fechas Futuras</h6>
                        <small>Previene que ingreses fechas de nacimiento futuras</small>
                    </div>
                    
                    <div class="feature">
                        <h6 class="success"><i class="bi bi-database-check me-1"></i>Base de Datos</h6>
                        <small>Guarda tanto la fecha como la edad calculada en la BD</small>
                    </div>
                </div>
            </div>

            <!-- Ejemplos -->
            <div class="row mt-4">
                <div class="col-12">
                    <h4><i class="bi bi-lightbulb me-2"></i>Ejemplos de Prueba</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Edad Calculada (aprox.)</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>15-08-2006</td>
                                    <td>18 años</td>
                                    <td><span class="badge bg-success">✅ Válido</span></td>
                                </tr>
                                <tr>
                                    <td>22-03-1995</td>
                                    <td>29 años</td>
                                    <td><span class="badge bg-success">✅ Válido</span></td>
                                </tr>
                                <tr>
                                    <td>10-12-2010</td>
                                    <td>14 años</td>
                                    <td><span class="badge bg-danger">❌ Menor de 16</span></td>
                                </tr>
                                <tr>
                                    <td>25-12-2026</td>
                                    <td>-1 años</td>
                                    <td><span class="badge bg-warning">⚠️ Fecha futura</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Enlaces -->
            <div class="text-center mt-4">
                <a href="<?php echo $_ENV['BASE_URL'] ?? 'http://localhost:8000'; ?>" class="btn btn-primary me-2">
                    <i class="bi bi-house me-1"></i>Ir al Sistema
                </a>
                <a href="<?php echo $_ENV['BASE_URL'] ?? 'http://localhost:8000'; ?>/sistema_completado_final.php" class="btn btn-success">
                    <i class="bi bi-trophy me-1"></i>Ver Sistema Completo
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function calcularEdadDemo() {
            const fechaNacimiento = document.getElementById('fechaNacimiento').value;
            const edadInput = document.getElementById('edadCalculada');
            const edadInfo = document.getElementById('edadInfo');
            const edadError = document.getElementById('edadError');
            const errorMsg = document.getElementById('errorMsg');
            
            // Ocultar mensajes
            edadInfo.style.display = 'none';
            edadError.style.display = 'none';
            
            if (fechaNacimiento) {
                const fechaNac = new Date(fechaNacimiento);
                const hoy = new Date();
                
                // Validar que la fecha no sea futura
                if (fechaNac > hoy) {
                    edadInput.value = '';
                    errorMsg.textContent = 'La fecha de nacimiento no puede ser futura';
                    edadError.style.display = 'block';
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
                
                edadInput.value = edad;
                
                // Validaciones
                if (edad < 16) {
                    errorMsg.textContent = `Edad calculada: ${edad} años. Debes tener al menos 16 años para registrarte`;
                    edadError.style.display = 'block';
                } else if (edad > 99) {
                    errorMsg.textContent = `Edad calculada: ${edad} años. Edad máxima permitida: 99 años`;
                    edadError.style.display = 'block';
                } else {
                    edadInfo.style.display = 'block';
                }
            } else {
                edadInput.value = '';
            }
        }
    </script>
</body>
</html>