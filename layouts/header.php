<?php
/**
 * Header del sitio - HTML base y metadatos
 * Archivo: layouts/header.php
 */
$currentUser = getCurrentUser();
$isLoggedIn = isLoggedIn();
?>

<!DOCTYPE html>
<html dir="ltr" lang="es" xml:lang="es">
<head>
    <title><?php echo $pageTitle ?? 'Home'; ?> | IFTS15</title>
    <link rel="shortcut icon" href="<?php echo SITE_URL; ?>/assets/images/favicon.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="IFTS15, Instituto, Formación Técnica Superior" />
    <meta name="description" content="<?php echo SITE_DESCRIPTION; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo SITE_URL; ?>/assets/css/custom.css" rel="stylesheet">
    
    <!-- Variables JavaScript -->
    <script>
        window.SITE_URL = "<?php echo SITE_URL; ?>";
        window.DEBUG_MODE = <?php echo DEBUG_MODE ? 'true' : 'false'; ?>;
        window.USER_LOGGED_IN = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
        <?php if ($isLoggedIn): ?>
        window.CURRENT_USER = <?php echo json_encode($currentUser); ?>;
        <?php endif; ?>
    </script>
</head>

<body class="<?php echo $isLoggedIn ? 'logged-in' : 'not-logged-in'; ?>">
    
    <!-- Incluir barra de navegación -->
    <?php include __DIR__ . '/navbar.php'; ?>
    
    <!-- Contenedor principal -->
    <div class="main-wrapper">
        <?php if ($isLoggedIn): ?>
            <!-- Incluir sidebar para usuarios logueados -->
            <?php include __DIR__ . '/sidebar.php'; ?>
            <!-- Inicio del contenido principal con sidebar -->
            <div class="main-content">
        <?php else: ?>
            <!-- Inicio del contenido principal sin sidebar -->
            <div class="container-fluid">
        <?php endif; ?>
