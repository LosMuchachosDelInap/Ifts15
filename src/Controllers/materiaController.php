<?php
namespace App\Controllers;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\ConectionBD\ConectionDB;
use App\Model\Materia;
use Exception;

require_once __DIR__ . '/../config.php';

class MateriaController
{
    private $conn;
    private $db;

    public function __construct()
    {
        $this->db = new ConectionDB();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Listar materias (para la vista ABM)
     */
    public function listar()
    {
        // Verificar permisos admin
        if (!isLoggedIn() || !isAdminRole()) {
            header('Location: ' . BASE_URL . '/index.php?error=acceso_denegado');
            exit;
        }

        $soloLibres = isset($_GET['libres']) && $_GET['libres'] === '1';

        try {
            $materias = Materia::obtenerTodas($this->conn, true, $soloLibres);
            
            // Si es petición AJAX, devolver JSON
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'materias' => $materias]);
                exit;
            }
            
            // Si no, devolver array para incluir en vista
            return $materias;
        } catch (Exception $e) {
            error_log('Error al listar materias: ' . $e->getMessage());
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'Error interno']);
                exit;
            }
            return [];
        }
    }

    /**
     * Crear materia (AJAX)
     */
    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }

        if (!isLoggedIn() || !isAdminRole()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Acceso denegado']);
            exit;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        
        if (empty($nombre)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'El nombre es obligatorio']);
            exit;
        }

        try {
            $id = Materia::crear($this->conn, $nombre);
            if ($id) {
                echo json_encode(['success' => true, 'id' => $id, 'message' => 'Materia creada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'No se pudo crear la materia']);
            }
        } catch (Exception $e) {
            error_log('Error al crear materia: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno']);
        }
        exit;
    }

    /**
     * Actualizar materia (AJAX)
     */
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }

        if (!isLoggedIn() || !isAdminRole()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Acceso denegado']);
            exit;
        }

        $id = intval($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        
        if ($id <= 0 || empty($nombre)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
            exit;
        }

        try {
            $ok = Materia::actualizar($this->conn, $id, $nombre);
            if ($ok) {
                echo json_encode(['success' => true, 'message' => 'Materia actualizada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar']);
            }
        } catch (Exception $e) {
            error_log('Error al actualizar materia: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno']);
        }
        exit;
    }

    /**
     * Eliminar materia (AJAX)
     */
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }

        if (!isLoggedIn() || !isAdminRole()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Acceso denegado']);
            exit;
        }

        $id = intval($_POST['id'] ?? 0);
        
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'ID inválido']);
            exit;
        }

        try {
            $ok = Materia::eliminar($this->conn, $id);
            if ($ok) {
                echo json_encode(['success' => true, 'message' => 'Materia eliminada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'No se pudo eliminar']);
            }
        } catch (Exception $e) {
            error_log('Error al eliminar materia: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno']);
        }
        exit;
    }
}

// Procesamiento de requests
if (basename($_SERVER['PHP_SELF']) === 'materiaController.php') {
    $action = $_GET['action'] ?? $_POST['action'] ?? '';
    $controller = new MateriaController();

    switch ($action) {
        case 'listar':
            $controller->listar();
            break;
        case 'crear':
            $controller->crear();
            break;
        case 'actualizar':
            $controller->actualizar();
            break;
        case 'eliminar':
            $controller->eliminar();
            break;
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Acción no válida']);
            break;
    }
}
