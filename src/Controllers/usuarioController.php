<?php
namespace App\Controllers;

// Iniciar sesión antes de cualquier output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\ConectionBD\ConectionDB;
use App\Model\User;
use Exception;

// Controlador simple para listar usuarios y cambiar habilitado
class UsuarioController
{
    private $conn;
    private $db;

    public function __construct()
    {
        if (!function_exists('env')) {
            require_once __DIR__ . '/../config.php';
        }
        $this->db = new ConectionDB();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Listar usuarios con paginación y mostrar la vista
     */
    public function listar()
    {
        // Solo roles administrativos pueden ver esta pantalla (3,4,5)
        if (!function_exists('isAdminRole')) {
            require_once __DIR__ . '/../config.php';
        }
        if (!isLoggedIn() || !isAdminRole()) {
            header('Location: ' . BASE_URL . '/index.php?error=acceso_denegado');
            exit;
        }

        $page = max(1, intval($_GET['page'] ?? 1));
        $limit = intval($_GET['limit'] ?? 10);
        if ($limit <= 0) $limit = 10;
        $offset = ($page - 1) * $limit;

        try {
            $total = User::contarTodos($this->conn);
            $usuarios = User::obtenerTodos($this->conn, $limit, $offset);
        } catch (Exception $e) {
            error_log('Error al obtener usuarios: ' . $e->getMessage());
            $usuarios = [];
            $total = 0;
        }

        // Incluir la vista (solo vista)
        include __DIR__ . '/../Views/usuarios.php';
    }

    /**
     * Toggle habilitado via AJAX
     */
    public function toggleHabilitado()
    {
        // Permitir solo POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }

        // Verificar permisos (roles administrativos)
        if (!function_exists('isAdminRole')) {
            require_once __DIR__ . '/../config.php';
        }
        if (!isLoggedIn() || !isAdminRole()) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Acceso denegado']);
            exit;
        }

        // Validar token CSRF
        $postedToken = $_POST['csrf_token'] ?? '';
        if (empty($postedToken) || empty($_SESSION['csrf_usuario_toggle']) || !hash_equals($_SESSION['csrf_usuario_toggle'], $postedToken)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }

        $id = intval($_POST['id'] ?? 0);
        $habilitado = intval($_POST['habilitado'] ?? 0);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'ID inválido']);
            exit;
        }

        try {
            $ok = User::actualizarHabilitado($this->conn, $id, $habilitado);
            if ($ok) {
                // Rotar el token CSRF y devolver el nuevo token en la respuesta
                try {
                    $newToken = bin2hex(random_bytes(32));
                } catch (Exception $e) {
                    $newToken = bin2hex(openssl_random_pseudo_bytes(32));
                }
                $_SESSION['csrf_usuario_toggle'] = $newToken;
                echo json_encode(['success' => true, 'new_csrf' => $newToken]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'No se pudo actualizar']);
            }
        } catch (Exception $e) {
            error_log('Error toggleHabilitado: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno']);
        }
        exit;
    }
}

// Procesamiento de requests cuando se accede directamente al archivo
if (basename($_SERVER['PHP_SELF']) === 'usuarioController.php') {
    $action = $_GET['action'] ?? $_POST['action'] ?? '';
    $controller = new UsuarioController();

    switch ($action) {
        case 'listar':
            $controller->listar();
            break;
        case 'toggle':
            $controller->toggleHabilitado();
            break;
        default:
            // Acción por defecto: listar
            $controller->listar();
            break;
    }
}

?>
