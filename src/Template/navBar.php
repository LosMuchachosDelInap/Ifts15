<!-- Navbar Bootstrap 5 minimalista y robusta -->
<nav class="navbar navbar-gradient fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center position-relative">
        <!-- Botón hamburguesa (izquierda) -->
        <div class="d-flex align-items-center flex-shrink-0">
            <?php if ($isLoggedIn): ?>
                <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas" aria-label="Menú lateral">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <?php else: ?>
                <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvasGuest" aria-controls="sidebarOffcanvasGuest" aria-label="Menú lateral">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <?php endif; ?>
        </div>

        <!-- Logo centrado absoluto -->
        <div class="position-absolute top-50 start-50 translate-middle" style="z-index:2;">
            <a class="navbar-brand d-flex align-items-center justify-content-center" href="<?php echo BASE_URL; ?>/index.php">
                <img src="<?php echo BASE_URL; ?>/src/Public/images/logo.png" alt="IFTS N° 15" class="me-2">
            </a>
        </div>

            <!-- Menú derecho: usuario o botones de acceso -->
            <div class="d-flex align-items-center flex-shrink-0 ms-auto" style="z-index:3; gap: 0.5rem;">
                <?php if ($isLoggedIn): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>
                            <span class="d-none d-sm-inline"><?php echo htmlspecialchars($userEmail); ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><span class="dropdown-item-text text-muted"><?php echo ucfirst($userRole); ?></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/src/Controllers/cerrarSesion.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalLogin">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
                        <i class="bi bi-person-plus me-1"></i> Registrarse
                    </button>
                <?php endif; ?>
            </div>
    </div>
</nav>