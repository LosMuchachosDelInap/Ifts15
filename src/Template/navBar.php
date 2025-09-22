<!-- Navbar -->
<nav class="navbar navbar-gradient fixed-top">
    <div class="container-fluid">
        <div class="row w-100 align-items-center">
            
            <!-- Columna izquierda: menú lateral (solo si está logueado) -->
            <div class="col-3 col-sm-4 d-flex justify-content-start">
                <?php if ($isLoggedIn): ?>
                <button class="navbar-toggler" 
                        type="button" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#sidebarOffcanvas" 
                        aria-controls="sidebarOffcanvas" 
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php endif; ?>
            </div>
            
            <!-- Columna central: logo -->
            <div class="col-6 col-sm-4 d-flex justify-content-center">
                <a class="navbar-brand mx-auto d-flex align-items-center" href="<?php echo BASE_URL; ?>/index.php">
                    <img src="<?php echo BASE_URL; ?>/src/Public/images/logo.png" 
                         alt="IFTS N° 15" 
                         height="40" 
                         class="me-2">
                    <!--<span class="fw-bold text-white d-none d-sm-inline" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">
                        IFTS N° 15
                    </span>-->
                </a>
            </div>
            
            <!-- Columna derecha: usuario (solo si está logueado) o botón menú (si no está logueado) -->
            <div class="col-3 col-sm-4 d-flex justify-content-end">
                <?php if ($isLoggedIn): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" 
                                type="button" 
                                data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            <span class="d-none d-sm-inline"><?php echo htmlspecialchars($userEmail); ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text text-muted"><?php echo ucfirst($userRole); ?></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/src/Controllers/cerrarSesion.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <button class="navbar-toggler" 
                            type="button" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#sidebarOffcanvas" 
                            aria-controls="sidebarOffcanvas" 
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>