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
    if ($novedad !== '') {
        Novedades::insertar($conn, $novedad);
    }
    // Redirigir para evitar reenvío del formulario y cerrar el modal con JS
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Listado de novedades
$novedades = Novedades::listar($conn);
