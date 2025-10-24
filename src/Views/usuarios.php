<?php
// Vista: usuarios.php
// Variables esperadas: $usuarios, $page, $limit, $total
require_once __DIR__ . '/../Template/head.php';
require_once __DIR__ . '/../Template/navBar.php';

// Sidebar si está logueado
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
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

