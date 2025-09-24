<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo Final - Modal de Consultas IFTS15</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="src/Css/consultasCss.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card shadow-lg">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #343a40 0%, #6c757d 65%, #ffd700 100%);">
                        <h2 class="mb-0">
                            <i class="fa fa-envelope"></i> 
                            Demo Final - Modal de Consultas IFTS15
                        </h2>
                    </div>
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="text-primary mb-4">✨ Funcionalidades Implementadas</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">✅ Modal responsivo y elegante</li>
                                            <li class="list-group-item">✅ Formulario con validación</li>
                                            <li class="list-group-item">✅ Envío AJAX sin recargar</li>
                                            <li class="list-group-item">✅ Loading button con spinner</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">✅ Mensaje de éxito animado</li>
                                            <li class="list-group-item">✅ Cierre automático del modal</li>
                                            <li class="list-group-item">✅ Toast de confirmación</li>
                                            <li class="list-group-item">✅ Limpieza automática del form</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="p-4 border rounded bg-white shadow-sm">
                                    <h5 class="text-success mb-3">🎯 Demo en Vivo</h5>
                                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#consultasModal">
                                        <i class="fa fa-paper-plane"></i>
                                        <br>
                                        Probar Modal
                                    </button>
                                    <p class="small text-muted mt-2">
                                        Haz clic para probar el flujo completo
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-info mb-3">🔄 Flujo de Trabajo</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center p-3 border rounded bg-light">
                                            <div class="h2 text-primary">1️⃣</div>
                                            <h6>Abrir Modal</h6>
                                            <p class="small">El usuario hace clic en cualquier botón de "Contacto"</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 border rounded bg-light">
                                            <div class="h2 text-warning">2️⃣</div>
                                            <h6>Completar Form</h6>
                                            <p class="small">Llenar datos personales y escribir consulta</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 border rounded bg-light">
                                            <div class="h2 text-info">3️⃣</div>
                                            <h6>Envío AJAX</h6>
                                            <p class="small">El correo se envía sin recargar la página</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center p-3 border rounded bg-light">
                                            <div class="h2 text-success">4️⃣</div>
                                            <h6>Confirmación</h6>
                                            <p class="small">Modal se cierra y aparece toast de éxito</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Consultas -->
    <?php 
    define('BASE_URL', 'http://localhost:8000');
    include_once __DIR__ . '/src/Components/modalConsultas.php'; 
    ?>

    <!-- Scripts -->
    <?php include_once __DIR__ . '/src/Public/Utilities/JS.php'; ?>
    
    <script>
        // Demo de tracking
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('consultasModal');
            
            modal.addEventListener('shown.bs.modal', function () {
                console.log('📤 Modal abierto - Usuario iniciando consulta');
            });
            
            modal.addEventListener('hidden.bs.modal', function () {
                console.log('✅ Modal cerrado - Proceso completado');
            });
        });
    </script>
</body>
</html>