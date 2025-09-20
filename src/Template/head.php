<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Meta tags adicionales -->
    <meta name="description" content="IFTS15 - Instituto de Formación Técnica Superior N° 15. Sistema de gestión educativa.">
    <meta name="keywords" content="IFTS15, instituto, educación, técnica, superior, Buenos Aires">
    <meta name="author" content="IFTS15 Team">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAABILAAASCwAAAAAAAAAAAAD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A">
    
    <!-- Bootstrap 5.3.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
          crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Font Awesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
          crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/Css/styles.css">
    
    <!-- CSS modulares -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/Css/navbarCss.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/Css/sidebarCss.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/Css/footerCss.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/Css/consultasCss.css">
    
    <!-- Estilo personalizado para navbar -->
    <style>
        .navbar-custom {
            background: linear-gradient(90deg, #000000 0%, #333333 50%, #ffd700 100%) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
            border-bottom: 2px solid #ffd700 !important;
        }
        
        /* Sidebar Offcanvas personalizado */
        .offcanvas-custom-header {
            background: linear-gradient(135deg, #000000 0%, #333333 30%, #6c757d 60%, #ffd700 100%) !important;
            color: white !important;
            border-bottom: 3px solid #ffd700 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2) !important;
        }
        
        .offcanvas-custom-body {
            background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 50%, #fff3cd 100%) !important;
            min-height: 100% !important;
        }
        
        /* Items del menu sidebar */
        .list-group-item-custom {
            background: rgba(255,255,255,0.9) !important;
            border: 1px solid rgba(255,215,0,0.3) !important;
            margin-bottom: 2px !important;
            transition: all 0.3s ease !important;
        }
        
        .list-group-item-custom:hover {
            background: linear-gradient(90deg, #ffd700 0%, #fff3cd 100%) !important;
            border-color: #ffd700 !important;
            transform: translateX(5px) !important;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1) !important;
        }
        
        .btn-close-custom {
            background: rgba(255,255,255,0.8) !important;
            opacity: 1 !important;
        }
        
        /* Estilos para sidebar avanzado */
        .text-bg-dark {
            background: linear-gradient(180deg, #212529 0%, #343a40 100%) !important;
        }
        
        .nav-link.text-light:hover {
            background: rgba(255, 215, 0, 0.1) !important;
            border-radius: 0.375rem !important;
        }
        
        .nav-link.text-danger:hover {
            background: rgba(220, 53, 69, 0.1) !important;
            border-radius: 0.375rem !important;
        }
        
        .sidebar-heading {
            font-size: 0.75rem !important;
            font-weight: bold !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
        }
        
        /* Carrusel personalizado */
        .carousel-hero {
            height: 500px;
            overflow: hidden;
            position: relative;
            width: 100%;
            margin-top: 70px; /* Espacio para navbar fixed */
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        
        .carousel-item {
            height: 500px;
            position: relative;
        }
        
        .carousel-item img {
            height: 500px;
            object-fit: cover;
            width: 100%;
            display: block;
        }
        
        .carousel-caption-custom {
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(51,51,51,0.6) 50%, rgba(255,215,0,0.3) 100%);
            border-radius: 10px;
            padding: 20px;
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255,215,0,0.5);
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 60px;
            height: 60px;
            background: rgba(0,0,0,0.7);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            border: 2px solid #ffd700;
        }
        
        .carousel-control-prev {
            left: 20px;
        }
        
        .carousel-control-next {
            right: 20px;
        }
        
        .carousel-indicators button {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            border: 2px solid #ffd700;
            background-color: rgba(255,215,0,0.5);
        }
        
        .carousel-indicators button.active {
            background-color: #ffd700;
            transform: scale(1.2);
        }
        
        /* Responsive del carrusel */
        @media (max-width: 768px) {
            .carousel-hero {
                height: 300px;
            }
            
            .carousel-item {
                height: 300px;
            }
            
            .carousel-item img {
                height: 300px;
            }
            
            .carousel-caption-custom {
                padding: 10px 15px;
            }
        }
        
        /* Footer personalizado */
        footer {
            margin-top: auto;
        }
        
        footer h5, footer h6 {
            color: #ffd700 !important;
            font-weight: 600;
        }
        
        footer .list-unstyled li {
            margin-bottom: 8px;
        }
        
        footer .list-unstyled a:hover {
            color: #ffd700 !important;
            transform: translateX(5px);
            transition: all 0.3s ease;
        }
        
        footer hr {
            border-color: #495057;
        }
        
        footer .bi {
            color: #ffd700;
        }
        
        footer p.small {
            line-height: 1.6;
        }
    </style>
    
    <title>IFTS15 - Instituto de Formación Técnica Superior</title>
</head>

<body class="d-flex flex-column min-vh-100">