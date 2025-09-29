<?php
namespace App\Controllers;

// Iniciar sesión antes de cualquier output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\ConectionBD\ConectionDB;
use App\Model\Person;
use App\Model\User;
use Exception;
use mysqli_sql_exception;
use Throwable;

/**
 * AuthController - IFTS15
 * Controlador de autenticación con phpdotenv
 * 
 * @package App\Controllers
 */
class AuthController
{
    private $conn;
    private $dbConnection; // Mantener la instancia viva
    
    public function __construct()
    {
        // Cargar configuración primero
        if (!function_exists('env')) {
            require_once __DIR__ . '/../config.php';
        }
        // Definir BASE_URL solo si no está definida
        if (!defined('BASE_URL')) {
            $baseUrl = $_ENV['BASE_URL'] ?? 'http://localhost:8000';
            define('BASE_URL', $baseUrl);
        }
        
        try {
            $this->dbConnection = new ConectionDB();
            $this->conn = $this->dbConnection->getConnection();
            
            if (!$this->conn) {
                throw new Exception('No se pudo establecer conexión con la base de datos');
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
                'controller' => 'AuthController'
            ]);
            exit;
        }
    }

    /**
     * Procesar login de usuario
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/?error=metodo_invalido');
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validaciones básicas
        if (empty($email) || empty($password)) {
            $_SESSION['login_message'] = 'Debes completar todos los campos.';
            $this->redirect('/index.php');
            return;
        }

        try {
            // Verificar conexión
            if (!$this->conn || $this->conn->connect_error) {
                error_log("Error de conexión BD en login: " . ($this->conn ? $this->conn->connect_error : 'Conexión nula'));
                $this->redirect('/?error=conexion_bd');
                return;
            }

            // Intentar autenticar
            $user = User::autenticar($this->conn, $email, $password);
            
            if ($user) {
                // Login exitoso
                $datosCompletos = $user->getDatosSesion($this->conn);
                if (!$datosCompletos) {
                    error_log("Error obteniendo datos de sesión para usuario: {$email}");
                    $_SESSION['login_message'] = 'Error obteniendo datos de sesión.';
                    $this->redirect('/index.php');
                    return;
                }
                foreach ($datosCompletos as $key => $value) {
                    $_SESSION[$key] = $value;
                }
                $_SESSION['usuario'] = $datosCompletos['email'];
                $_SESSION['user_id'] = $datosCompletos['id_usuario'];
                $_SESSION['logged_in'] = true;
                error_log("Login exitoso: {$email}");
                $this->redirect('/index.php');
            } else {
                error_log("Intento de login fallido: {$email}");
                $_SESSION['login_message'] = 'Usuario o contraseña incorrectos.';
                $this->redirect('/index.php');
            }
            
        } catch (mysqli_sql_exception $e) {
            error_log("Error MySQL en login: " . $e->getMessage() . " - Código: " . $e->getCode());
            $this->redirect('/?error=bd_mysql');
        } catch (Exception $e) {
            error_log("Error general en login: " . $e->getMessage() . " - Archivo: " . $e->getFile() . " - Línea: " . $e->getLine());
            $this->redirect('/?error=error_interno&debug=1');
        }
    }

    /**
     * Procesar registro de usuario
     */
    public function register()
    {
        error_log("INICIO registro - REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/?error=metodo_invalido');
            return;
        }

        // Obtener datos del formulario
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm_password = trim($_POST['confirm_password'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $dni = trim($_POST['dni'] ?? '');
        $fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $edad = intval($_POST['edad'] ?? 0);
        
        // Obtener datos académicos
        $id_carrera = intval($_POST['id_carrera'] ?? 0);
        $id_comision = intval($_POST['id_comision'] ?? 0);
        $id_añoCursada = intval($_POST['id_añoCursada'] ?? 0);
        
        error_log("DATOS recibidos - email: {$email}, nombre: {$nombre}, apellido: {$apellido}, dni: {$dni}, edad: {$edad}");
        error_log("DATOS ACADEMICOS - carrera: {$id_carrera}, comision: {$id_comision}, año: {$id_añoCursada}");
        
        // Convertir fecha vacía a NULL para la base de datos
        $fecha_nacimiento = empty($fecha_nacimiento) ? null : $fecha_nacimiento;

        // Validaciones
        $errores = $this->validarDatosRegistro($email, $password, $confirm_password, $nombre, $apellido, $dni, $id_carrera, $id_comision, $id_añoCursada);
        
        if (!empty($errores)) {
            $_SESSION['register_message'] = implode(', ', $errores);
            $this->redirect('/index.php');
            return;
        }

        try {
            error_log("INICIANDO transacción");
            // Iniciar transacción
            $this->conn->begin_transaction();

            error_log("CREANDO objeto Person");
            // 1. Crear persona
            $persona = new Person($nombre, $apellido, $fecha_nacimiento, $dni, $telefono, null, null, null, $edad);
            
            error_log("VALIDANDO persona");
            // Validar persona
            $erroresPersona = $persona->validar();
            if (!empty($erroresPersona)) {
                throw new Exception("Errores persona: " . implode(', ', $erroresPersona));
            }

            error_log("VERIFICANDO DNI existente");
            // Verificar si DNI ya existe
            if ($persona->dniExiste($this->conn)) {
                throw new Exception("El DNI ya está registrado");
            }

            error_log("GUARDANDO persona");
            if (!$persona->guardar($this->conn)) {
                throw new Exception("Error al guardar datos personales");
            }
            error_log("PERSONA guardada con ID: " . $persona->getId());

            error_log("CREANDO usuario");
            // 2. Crear usuario con datos académicos
            $user = new User($email, $password, $persona->getId(), 1, $id_carrera, $id_comision, $id_añoCursada); // 1 = Alumno por defecto
            
            error_log("VALIDANDO usuario");
            // Validar usuario
            $erroresUsuario = $user->validar($this->conn);
            if (!empty($erroresUsuario)) {
                throw new Exception("Errores usuario: " . implode(', ', $erroresUsuario));
            }

            error_log("GUARDANDO usuario");
            if (!$user->guardar($this->conn)) {
                throw new Exception("Error al crear usuario");
            }

            error_log("CONFIRMANDO transacción");
            // Confirmar transacción
            $this->conn->commit();

            // Log de actividad
            error_log("REGISTRO EXITOSO: {$email}");

            $_SESSION['register_message'] = '¡Registro exitoso! Ya puedes ingresar.';
            $this->redirect('/index.php');

        } catch (Exception $e) {
            // Rollback en caso de error
            $this->conn->rollback();
            $error_msg = $e->getMessage();
            $debug_info = "Error: {$error_msg} | Datos: nombre={$nombre}, apellido={$apellido}, dni={$dni}, email={$email}, fecha=" . ($fecha_nacimiento ?: 'NULL') . ", telefono={$telefono}, edad={$edad}";
            error_log("ERROR en registro: " . $debug_info);
            $_SESSION['register_message'] = $error_msg;
            $this->redirect('/index.php');
        } catch (Throwable $e) {
            // Capturar errores fatales también
            $this->conn->rollback();
            $error_msg = "Error fatal: " . $e->getMessage() . " en " . $e->getFile() . ":" . $e->getLine();
            error_log("ERROR FATAL en registro: " . $error_msg);
            $_SESSION['register_message'] = 'Error fatal en el registro.';
            $this->redirect('/index.php');
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        // Limpiar todas las variables de sesión
        $_SESSION = array();

        // Si se desea destruir la sesión completamente, borrar también la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destruir la sesión
        session_destroy();

        $this->redirect('/?logout=success');
    }

    /**
     * Verificar si el usuario está logueado
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Obtener datos del usuario actual
     */
    public static function getCurrentUser()
    {
        if (!self::isLoggedIn()) {
            return null;
        }

        return [
            'id_usuario' => $_SESSION['id_usuario'] ?? null,
            'email' => $_SESSION['email'] ?? null,
            'nombre' => $_SESSION['nombre'] ?? null,
            'apellido' => $_SESSION['apellido'] ?? null,
            'nombre_completo' => $_SESSION['nombre_completo'] ?? null,
            'role_id' => $_SESSION['role_id'] ?? null,
            'role' => $_SESSION['role'] ?? null,
            'last_login' => $_SESSION['last_login'] ?? null
        ];
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public static function hasRole($role)
    {
        if (!self::isLoggedIn()) {
            return false;
        }
        
        return $_SESSION['role'] === $role || $_SESSION['role_id'] === $role;
    }

    /**
     * Verificar si el usuario es admin
     */
    public static function isAdmin()
    {
        return self::hasRole('admin') || self::hasRole(1);
    }

    /**
     * Requerir login (middleware)
     */
    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/?error=login_requerido');
            exit;
        }
    }

    /**
     * Requerir rol específico (middleware)
     */
    public static function requireRole($role)
    {
        self::requireLogin();
        
        if (!self::hasRole($role)) {
            header('Location: ' . BASE_URL . '/?error=acceso_denegado');
            exit;
        }
    }

    // ========================================
    // MÉTODOS PRIVADOS
    // ========================================
    
    /**
     * Validar datos de registro
     */
    private function validarDatosRegistro($email, $password, $confirm_password, $nombre, $apellido, $dni, $id_carrera, $id_comision, $id_añoCursada)
    {
        $errores = [];

        // Validar email
        if (empty($email)) {
            $errores[] = "El email es obligatorio";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Formato de email inválido";
        }

        // Validar contraseña
        if (empty($password)) {
            $errores[] = "La contraseña es obligatoria";
        } elseif (strlen($password) < 6) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres";
        }

        // Confirmar contraseña
        if ($password !== $confirm_password) {
            $errores[] = "Las contraseñas no coinciden";
        }

        // Validar nombre
        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio";
        }

        // Validar apellido
        if (empty($apellido)) {
            $errores[] = "El apellido es obligatorio";
        }

        // Validar DNI
        if (empty($dni)) {
            $errores[] = "El DNI es obligatorio";
        } elseif (!preg_match('/^\d{7,8}$/', $dni)) {
            $errores[] = "El DNI debe tener 7 u 8 dígitos";
        }

        // Validar datos académicos
        if (empty($id_carrera) || $id_carrera <= 0) {
            $errores[] = "Debe seleccionar una carrera";
        }

        if (empty($id_comision) || $id_comision <= 0) {
            $errores[] = "Debe seleccionar una comisión";
        }

        if (empty($id_añoCursada) || $id_añoCursada <= 0) {
            $errores[] = "Debe seleccionar el año a cursar";
        }

        return $errores;
    }

    /**
     * Redireccionar
     */
    private function redirect($url)
    {
        // Si el redirect es solo "/", cambiar a "/index.php"
        if ($url === '/' || $url === '') {
            $url = '/index.php';
        } elseif (strpos($url, '/?') === 0) {
            // Si es algo como "/?login=success", cambiar a "/index.php?login=success"
            $url = str_replace('/?', '/index.php?', $url);
        }
        
        $full_url = BASE_URL . $url;
        error_log("Redirigiendo a: " . $full_url); // Para debug
        header("Location: $full_url");
        exit;
    }
}

// ========================================
// PROCESAMIENTO DE REQUESTS
// ========================================

// Solo procesar si se llama directamente este archivo
if (basename($_SERVER['PHP_SELF']) === 'AuthController.php') {
    try {
        // Determinar qué acción realizar
        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        

        if (empty($action)) {
            http_response_code(400);
            echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Acceso inválido</title></head><body style="font-family:sans-serif;text-align:center;margin-top:10%"><h2>Acceso inválido</h2><p>No se especificó ninguna acción para este controlador.</p><a href="/index.php">Volver al inicio</a></body></html>';
            exit;
        }

        // Verificar método de solicitud según la acción
        if ($action === 'logout') {
            // Logout permite GET y POST
            if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Método no permitido</title></head><body style="font-family:sans-serif;text-align:center;margin-top:10%"><h2>Método no permitido</h2><p>El método de solicitud no es válido para logout.</p><a href="/index.php">Volver al inicio</a></body></html>';
                exit;
            }
        } else {
            // Login y Register solo permiten POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Método no permitido</title></head><body style="font-family:sans-serif;text-align:center;margin-top:10%"><h2>Método no permitido</h2><p>El método de solicitud no es válido para esta acción.</p><a href="/index.php">Volver al inicio</a></body></html>';
                exit;
            }
        }

        $authController = new AuthController();

        switch ($action) {
            case 'login':
                $authController->login();
                break;
            
            case 'register':
                $authController->register();
                break;
            
            case 'logout':
                $authController->logout();
                break;
                
            default:
                throw new Exception('Acción no válida: ' . $action);
        }
        
    } catch (Exception $e) {
        // Manejo de errores general
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => DEBUG_MODE ? $e->getTraceAsString() : 'Error interno del servidor'
        ]);
        exit;
    }
}
?>