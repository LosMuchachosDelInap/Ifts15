<!-- Footer Simplificado -->
<footer class="bg-dark text-white mt-5" style="background: #343a40 !important; padding: 30px 0 20px 0 !important; display: block !important; visibility: visible !important;">
    <div class="container py-4" style="background: #343a40 !important;">
        <div class="row" style="background: #343a40 !important; display: flex; align-items: stretch;">
            <div class="col-md-4 mb-3" style="background: #343a40 !important; padding: 15px !important; display: flex; flex-direction: column;">
                <h5 style="color: #FFD700 !important;">
                    <img src="/src/Public/images/logo_solo_circulo.png" alt="Logo IFTS15" style="height:32px;vertical-align:middle;margin-right:8px;"> IFTS15
                </h5>
                <p class="small" style="color: white !important;">
                    Instituto de Formación Técnica Superior N° 15<br>
                    Educación técnica de calidad para el futuro.
                </p>
            </div>
            <div class="col-md-4 mb-3" style="background: #343a40 !important; padding: 15px !important; display: flex; flex-direction: column;">
                <h6 style="color: #FFD700 !important;">Enlaces Útiles</h6>
                <ul class="list-unstyled" style="flex-grow: 1;">
                    <li><a href="#" class="text-light text-decoration-none">
                        <i class="bi bi-chevron-right"></i> Sobre Nosotros
                    </a></li>
                    <li><a  href="<?php echo BASE_URL; ?>/src/Views/realizador-productor-tv.php" class="text-light text-decoration-none">
                        <i class="bi bi-chevron-right"></i> Realizador y Productor Televisivo
                    </a></li>
                    <li><a href="#" class="text-light text-decoration-none">
                        <i class="bi bi-chevron-right"></i> Biblioteca
                    </a></li>
                    <li><a href="#" class="text-light text-decoration-none" data-bs-toggle="modal" data-bs-target="#consultasModal" style="color: #FFD700 !important;">
                        <i class="bi bi-chevron-right"></i> Contacto
                    </a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-3" style="background: #343a40 !important; padding: 15px !important; display: flex; flex-direction: column;">
                <h6 style="color: #FFD700 !important;">Contacto</h6>
                <p class="small" style="color: white !important; flex-grow: 1;">
                    <i class="bi bi-geo-alt" style="color: #FFD700;"></i> 
                    Av. Ejemplo 1234, Ciudad Autónoma de Buenos Aires<br>
                    <i class="bi bi-telephone" style="color: #FFD700;"></i> 
                    (011) 4555-1234<br>
                    <i class="bi bi-envelope" style="color: #FFD700;"></i> 
                    info@ifts15.edu.ar
                </p>
            </div>
        </div>
        
        <!-- Separador amarillo degradado -->
        <div class="footer-separator" style="
            width: 100%; 
            height: 2px; 
            background: linear-gradient(90deg, transparent 0%, #FFD700 20%, #FFD700 50%, #FFD700 80%, transparent 100%); 
            margin: 15px 0; 
            border-radius: 1px;
            box-shadow: 0 1px 4px rgba(255, 215, 0, 0.4);
        "></div>
        
        <hr class="my-3" style="border-color: #495057; background: #343a40 !important; display: none;">
        <div class="row" style="background: #343a40 !important;">
            <div class="col-md-6">
                <small style="color: white !important;">
                    © <?php echo date('Y'); ?> IFTS15. Todos los derechos reservados.
                </small>
            </div>
            <div class="col-md-6 text-md-end">
                <small style="color: white !important;">
                    Desarrollado por Les muchaches del Inap
                </small>
            </div>
        </div>
    </div>
</footer>

<!-- Modal de Consultas -->
<?php include_once __DIR__ . '/../Components/modalConsultas.php'; ?>

<!-- JavaScript Centralizado del Sistema -->
<?php include_once __DIR__ . '/../Public/Utilities/JS.php'; ?>