<?php
namespace App\Controllers;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\ConectionBD\ConectionDB;
use App\Model\Carrera;
use Exception;

require_once __DIR__ . '/../config.php';

class CarreraController
{
    private $conn;
    private $db;

    public function __construct()
    {
        $this->db = new ConectionDB();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Listar carreras (para la vista ABM)
     */
    public function listar()
    {
        // Verificar permisos admin
        if (!isLoggedIn() || !isAdminRole()) {
            header('Location: ' . BASE_URL . '/index.php?error=acceso_denegado');
            exit;
        }

        try {
            $carreras = Carrera::obtenerTodas($this->conn);
            
            // Si es petición AJAX, devolver JSON
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'carreras' => $carreras]);
                exit;
            }
            
            // Si no, devolver array para incluir en vista
            return $carreras;
        } catch (Exception $e) {
            error_log('Error al listar carreras: ' . $e->getMessage());
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'Error interno']);
                exit;
            }
            return [];
        }
    }

    /**
     * Crear carrera (AJAX)
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
            $id = Carrera::crear($this->conn, $nombre);
            if ($id) {
                echo json_encode(['success' => true, 'id' => $id, 'message' => 'Carrera creada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'No se pudo crear la carrera']);
            }
        } catch (Exception $e) {
            error_log('Error al crear carrera: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno']);
        }
        exit;
    }

    /**
     * Actualizar carrera (AJAX)
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
            $ok = Carrera::actualizar($this->conn, $id, $nombre);
            if ($ok) {
                echo json_encode(['success' => true, 'message' => 'Carrera actualizada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar']);
            }
        } catch (Exception $e) {
            error_log('Error al actualizar carrera: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno']);
        }
        exit;
    }

    /**
     * Eliminar carrera (AJAX)
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
            $ok = Carrera::eliminar($this->conn, $id);
            if ($ok) {
                echo json_encode(['success' => true, 'message' => 'Carrera eliminada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'No se pudo eliminar']);
            }
        } catch (Exception $e) {
            error_log('Error al eliminar carrera: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno']);
        }
        exit;
    }

    /**
     * Asociar materia a carrera (drag & drop)
     */
    public function asociarMateria()
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

        $idCarrera = intval($_POST['id_carrera'] ?? 0);
        $idMateria = intval($_POST['id_materia'] ?? 0);
        
        if ($idCarrera <= 0 || $idMateria <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
            exit;
        }

        try {
            $result = Carrera::asociarMateria($this->conn, $idCarrera, $idMateria);
            header('Content-Type: application/json');
            echo json_encode($result);
        } catch (Exception $e) {
            error_log('Error al asociar materia: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno']);
        }
        exit;
    }

    /**
     * Desasociar materia de carrera
     */
    public function desasociarMateria()
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

        $idCarrera = intval($_POST['id_carrera'] ?? 0);
        $idMateria = intval($_POST['id_materia'] ?? 0);
        
        if ($idCarrera <= 0 || $idMateria <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
            exit;
        }

        try {
            $ok = Carrera::desasociarMateria($this->conn, $idCarrera, $idMateria);
            if ($ok) {
                echo json_encode(['success' => true, 'message' => 'Materia desasociada']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'No se pudo desasociar']);
            }
        } catch (Exception $e) {
            error_log('Error al desasociar materia: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno']);
        }
        exit;
    }
}

// Procesamiento de requests
if (basename($_SERVER['PHP_SELF']) === 'carreraController.php') {
    $action = $_GET['action'] ?? $_POST['action'] ?? '';
    $controller = new CarreraController();

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
        case 'asociar':
            $controller->asociarMateria();
            break;
        case 'desasociar':
            $controller->desasociarMateria();
            break;
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Acción no válida']);
            break;
    }
}
