<?php
// Index simplificado para debug
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IFTS15 - Debug</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/src/Css/styles.css">
</head>
<body>
    <!-- Navbar simple -->
    <nav class="navbar navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">IFTS N° 15 - Debug</span>
            <button class="navbar-toggler" 
                    type="button" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#sidebarOffcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Sidebar Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarOffcanvas">
        <div class="offcanvas-header bg-dark text-white">
            <h5 class="offcanvas-title">Menú Principal</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="bi bi-house-door me-2"></i>Inicio
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="bi bi-person me-2"></i>Login
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="bi bi-person-plus me-2"></i>Registro
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <main class="container-fluid" style="margin-top: 80px;">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success">
                    <h4>✅ Sistema funcionando correctamente</h4>
                    <p>Bootstrap, navbar y sidebar operativos</p>
                </div>
                
                <!-- Carrusel simple -->
                <div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="bg-primary text-white p-5 text-center">
                                <h2>IFTS N° 15</h2>
                                <p>Instituto de Formación Técnica Superior</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="bg-secondary text-white p-5 text-center">
                                <h2>Sistema MVC</h2>
                                <p>Basado en Bootstrap 5.3.2</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>