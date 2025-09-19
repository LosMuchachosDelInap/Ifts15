<?php
/**
 * AuthController - IFTS15
 * Controlador de autenticación con phpdotenv
 * 
 * @package IFTS15\Controllers
 */

// Cargar configuración central
require_once __DIR__ . '/../config.php';

// Incluir modelos necesarios
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Person.php';
require_once __DIR__ . '/../ConectionBD/CConnection.php';

class AuthController
{
    private $conn;
    private $dbConnection; // Mantener la instancia viva
    
    public function __construct()
    {
        $this->dbConnection = new ConectionDB();
        $this->conn = $this->dbConnection->getConnection();
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
            $this->redirect('/?error=campos_vacios');
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
                
                // Validar que obtuvimos los datos
                if (!$datosCompletos) {
                    error_log("Error obteniendo datos de sesión para usuario: {$email}");
                    $this->redirect('/?error=datos_sesion');
                    return;
                }
                
                // Guardar en sesión
                foreach ($datosCompletos as $key => $value) {
                    $_SESSION[$key] = $value;
                }
                
                // Variables adicionales para compatibilidad
                $_SESSION['usuario'] = $datosCompletos['email']; // Para mantener compatibilidad
                $_SESSION['user_id'] = $datosCompletos['id_usuario']; // Para getCurrentUser()

                // Log de actividad (opcional)
                error_log("Login exitoso: {$email}");
                
                $this->redirect('/?login=success');
            } else {
                // Credenciales incorrectas
                error_log("Intento de login fallido: {$email}");
                $this->redirect('/?error=credenciales_incorrectas');
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
        $direccion = trim($_POST['direccion'] ?? '');

        // Validaciones
        $errores = $this->validarDatosRegistro($email, $password, $confirm_password, $nombre, $apellido, $dni);
        
        if (!empty($errores)) {
            $this->redirect('/?error=' . urlencode(implode(', ', $errores)));
            return;
        }

        try {
            // Iniciar transacción
            $this->conn->begin_transaction();

            // 1. Crear persona
            $persona = new Person($nombre, $apellido, $fecha_nacimiento, $dni, $telefono, $direccion, $email);
            
            // Validar persona
            $erroresPersona = $persona->validar();
            if (!empty($erroresPersona)) {
                throw new Exception(implode(', ', $erroresPersona));
            }

            // Verificar si DNI ya existe
            if ($persona->dniExiste($this->conn)) {
                throw new Exception("El DNI ya está registrado");
            }

            if (!$persona->guardar($this->conn)) {
                throw new Exception("Error al guardar datos personales");
            }

            // 2. Crear usuario
            $user = new User($email, $password, $persona->getId(), 2); // 2 = estudiante por defecto
            
            // Validar usuario
            $erroresUsuario = $user->validar($this->conn);
            if (!empty($erroresUsuario)) {
                throw new Exception(implode(', ', $erroresUsuario));
            }

            if (!$user->guardar($this->conn)) {
                throw new Exception("Error al crear usuario");
            }

            // Confirmar transacción
            $this->conn->commit();

            // Log de actividad
            error_log("Registro exitoso: {$email}");

            $this->redirect('/?registro=exitoso');

        } catch (Exception $e) {
            // Rollback en caso de error
            $this->conn->rollback();
            error_log("Error en registro: " . $e->getMessage());
            $this->redirect('/?error=' . urlencode($e->getMessage()));
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
    private function validarDatosRegistro($email, $password, $confirm_password, $nombre, $apellido, $dni)
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
    // Determinar qué acción realizar
    $action = $_GET['action'] ?? $_POST['action'] ?? 'login';

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
            header('Location: ' . BASE_URL . '/?error=accion_invalida');
            exit;
    }
}
?>