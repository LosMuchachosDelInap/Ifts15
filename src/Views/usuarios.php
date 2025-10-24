<?php
// Vista: usuarios.php
// Variables esperadas: $usuarios, $page, $limit, $total
// Asegurar sesión y variables esperadas por las plantillas (navBar, sidebar)
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

// Intentar obtener info rica del usuario desde helpers si están disponibles
if (!function_exists('getCurrentUser')) {
	require_once __DIR__ . '/../config.php';
}
$currentUser = getCurrentUser();
$isLoggedIn = $currentUser !== null;
$userEmail = $currentUser['email'] ?? $_SESSION['email'] ?? $_SESSION['usuario'] ?? '';
$userRole = $currentUser['role'] ?? ($_SESSION['role_name'] ?? $_SESSION['user_role'] ?? ($_SESSION['id_rol'] ?? 'Usuario'));

require_once __DIR__ . '/../Template/head.php';
require_once __DIR__ . '/../Template/navBar.php';

// Sidebar si está logueado
if ($isLoggedIn) {
	include __DIR__ . '/../Template/sidebar.php';
}
?>

<!-- CSS específico para la vista de usuarios -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/Css/usuariosCss.css">

<main class="flex-fill">
	<div class="container py-4">
		<?php include __DIR__ . '/../Components/tablaUsuarios.php'; ?>
	</div>
</main>

<?php include __DIR__ . '/../Template/footer.php'; ?>

