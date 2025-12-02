<?php

require_once __DIR__ . '/../../vendor/autoload.php';

// Cargar variables de entorno desde .env
if (file_exists(__DIR__ . '/../../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    if (method_exists($dotenv, 'safeLoad')) {
        $dotenv->safeLoad();
    } else {
        try { $dotenv->load(); } catch (Throwable $e) { /* ignore */ }
    }
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Model/Consulta.php';
use App\Model\Consulta;
use App\ConectionBD\ConectionDB;
// Utilidad de correo
require_once __DIR__ . '/../Public/Utilities/envioMail.php';

// Crear directorio de logs si no existe
if (!file_exists(__DIR__ . '/../../logs')) {
    mkdir(__DIR__ . '/../../logs', 0755, true);
}

// DEBUG: Verificar que podemos escribir logs
file_put_contents(__DIR__ . '/../../logs/debug_test.log', 
    "[" . date('Y-m-d H:i:s') . "] Controller cargado\n", 
    FILE_APPEND | LOCK_EX);

// Función helper para logging
function logMail($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message" . PHP_EOL;
    file_put_contents(__DIR__ . '/../../logs/consultas_debug.log', $logMessage, FILE_APPEND | LOCK_EX);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logMail("POST recibido: " . print_r($_POST, true));

    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $carrera = trim($_POST['carrera'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    // Validar campos obligatorios
    if (empty($nombre) || empty($email) || empty($mensaje)) {
        $_SESSION['consultas_message'] = 'Debe completar todos los campos obligatorios (Nombre, Email y Consulta).';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Validar email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['consultas_message'] = 'Por favor ingrese un email válido.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Crear objeto consulta
    $consulta = new Consulta($nombre, $email, $mensaje, $telefono, $carrera);

    try {
        logMail("Intentando enviar email via envio_mail...");
        // Obtener nombre de la carrera si se seleccionó una
        $nombreCarrera = 'Información general';
        if (!empty($consulta->getCarrera())) {
            $conectarDB = new ConectionDB();
            $conectarDB = new ConectionDB();
            $conn = $conectarDB->getConnection();
            $stmt = $conn->prepare("SELECT nombreCarrera FROM carrera WHERE id_carrera = ?");
            $stmt->bind_param("i", $carrera);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $nombreCarrera = $row['nombreCarrera'];
            }
            $stmt->close();
        }

        $subject = 'Nueva consulta desde IFTS15 - ' . $nombreCarrera;
        $cuerpoMensaje = "<h3>Nueva consulta desde IFTS15</h3>";
        $cuerpoMensaje .= "<p><b>Nombre:</b> " . htmlspecialchars($consulta->getNombre()) . "</p>";
        $cuerpoMensaje .= "<p><b>Email:</b> " . htmlspecialchars($consulta->getEmail()) . "</p>";
        if (!empty($consulta->getTelefono())) {
            $cuerpoMensaje .= "<p><b>Teléfono:</b> " . htmlspecialchars($consulta->getTelefono()) . "</p>";
        }
        if (!empty($consulta->getCarrera())) {
            $cuerpoMensaje .= "<p><b>Carrera de interés:</b> " . htmlspecialchars($nombreCarrera) . "</p>";
        }
        $cuerpoMensaje .= "<p><b>Mensaje:</b></p><p>" . nl2br(htmlspecialchars($consulta->getMensaje())) . "</p>";

        // Destinatario: admin o email configurado
        $destinatario = $_ENV['ADMIN_EMAILS'] ?? $_ENV['MAIL_USERNAME'] ?? '';
        if (empty($destinatario)) {
            throw new Exception('No hay destinatario configurado (ADMIN_EMAILS o MAIL_USERNAME)');
        }
        
        $result = envio_mail($destinatario, $subject, $cuerpoMensaje, $consulta->getEmail(), $consulta->getNombre(), true, $consulta->getEmail());
        if ($result['success']) {
            logMail("Email enviado exitosamente a " . $destinatario);
            $_SESSION['consultas_message'] = '¡Consulta enviada correctamente! Te responderemos a la brevedad a tu email: ' . htmlspecialchars($consulta->getEmail());
        } else {
            logMail("Error envio_mail: " . $result['message']);
            $_SESSION['consultas_message'] = 'No se pudo enviar el mensaje. Por favor intenta nuevamente más tarde.';
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } catch (Exception $e) {
        logMail("Excepción envio_mail: " . $e->getMessage());
        $_SESSION['consultas_message'] = 'No se pudo enviar el mensaje. Por favor intenta nuevamente más tarde.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    exit;
}