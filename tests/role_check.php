<?php
// tests/role_check.php
// Página de prueba para validar getUserRoleId() e isAdminRole()

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/config.php';

// Procesar cambios de sesión vía GET
if (isset($_GET['set'])) {
    $rid = intval($_GET['set']);
    $_SESSION['id_rol'] = $rid;
    // También mantener role_id por compatibilidad
    $_SESSION['role_id'] = $rid;
    header('Location: role_check.php');
    exit;
}

if (isset($_GET['clear'])) {
    unset($_SESSION['id_rol'], $_SESSION['role_id']);
    header('Location: role_check.php');
    exit;
}

// Valores de roles para probar (según src/ConectionBD/ifts15.sql)
$roles = [
    1 => 'Alumno',
    2 => 'Profesor',
    3 => 'Administrativo',
    4 => 'Directivo',
    5 => 'Administrador'
];

$currentRid = getUserRoleId();
$adminCheck = isAdminRole();

// Intentar usar AuthController::isAdmin() si está disponible
$authIsAdmin = null;
if (class_exists('\\App\\Controllers\\AuthController')) {
    try {
        $authIsAdmin = \App\Controllers\AuthController::isAdmin();
    } catch (Throwable $e) {
        $authIsAdmin = 'error: ' . $e->getMessage();
    }
}

// Datos de getCurrentUser si está disponible
$currentUser = getCurrentUser();

?><!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Test roles - IFTS15</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3>Prueba de roles (getUserRoleId / isAdminRole)</h3>
    <p class="text-muted">Usa los enlaces para setear un role en la sesión. Esto no persiste fuera de la sesión actual del navegador.</p>

    <div class="mb-3">
        <?php foreach ($roles as $id => $label): ?>
            <a class="btn btn-sm btn-outline-primary me-1 mb-1" href="?set=<?php echo $id; ?>">Set role <?php echo $id; ?> (<?php echo htmlspecialchars($label); ?>)</a>
        <?php endforeach; ?>
        <a class="btn btn-sm btn-outline-danger ms-2" href="?clear=1">Limpiar role</a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Estado de sesión</h5>
            <pre><?php echo htmlspecialchars(print_r($_SESSION, true)); ?></pre>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h6>getUserRoleId()</h6>
                    <p><strong><?php echo var_export($currentRid, true); ?></strong> (<?php echo htmlspecialchars($roles[$currentRid] ?? 'No establecido'); ?>)</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h6>isAdminRole()</h6>
                    <p><strong><?php echo $adminCheck ? 'true' : 'false'; ?></strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6>AuthController::isAdmin() (si está disponible)</h6>
            <p><?php echo is_null($authIsAdmin) ? '<em>No disponible</em>' : htmlspecialchars(var_export($authIsAdmin, true)); ?></p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h6>getCurrentUser()</h6>
            <pre><?php echo htmlspecialchars(print_r($currentUser, true)); ?></pre>
        </div>
    </div>

</div>
</body>
</html>
