<?php
// Controlador de novedades (MVC)
require_once __DIR__ . '/../Model/Novedades.php';
require_once __DIR__ . '/../ConectionBD/ConectionDB.php';

use App\ConectionBD\ConectionDB;
use App\Model\Novedades;

$db = new ConectionDB();
$conn = $db->getConnection();

// Alta de novedad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['novedad'])) {
    $novedad = trim($_POST['novedad']);
    // Detectar petición AJAX/fetch: se envía X-Requested-With por el cliente
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    $success = false;
    $message = '';

    if ($novedad !== '') {
        try {
            Novedades::insertar($conn, $novedad);
            $success = true;
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
    } else {
        $message = 'Novedad vacía';
    }

    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }

    // Redirigir para evitar reenvío del formulario y cerrar el modal con JS
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL));
    exit;
}

// Listado de novedades
$novedades = Novedades::listar($conn);
