<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Model/Consulta.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

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

    $mail = new PHPMailer(true);
    try {
        logMail("Intentando enviar email...");

        // Configuración básica de PHPMailer - IGUAL A LA CONFIGURACIÓN EXITOSA
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = $_ENV['MAIL_SMTPAuth'] === 'true';
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['MAIL_PORT'];

        // 🔧 Configuración simplificada - sin SMTPOptions complejas que pueden dar problemas
        $mail->setFrom($consulta->getEmail(), $consulta->getNombre());
        $mail->addAddress($_ENV['MAIL_USERNAME']); // Destinatario: losmuchachosdelinapifts@gmail.com

        $mail->isHTML(true);
        $mail->Subject = 'Nueva consulta desde IFTS15 - ' . ($consulta->getCarrera() ? $consulta->getCarrera() : 'Información general');
        
        // Construir el cuerpo del mensaje - Simplificado
        $cuerpoMensaje = "
            <h3>Nueva consulta desde IFTS15</h3>
            <p><b>Nombre:</b> " . htmlspecialchars($consulta->getNombre()) . "</p>
            <p><b>Email:</b> " . htmlspecialchars($consulta->getEmail()) . "</p>";
        
        if (!empty($consulta->getTelefono())) {
            $cuerpoMensaje .= "<p><b>Teléfono:</b> " . htmlspecialchars($consulta->getTelefono()) . "</p>";
        }
        
        if (!empty($consulta->getCarrera())) {
            $cuerpoMensaje .= "<p><b>Carrera de interés:</b> " . htmlspecialchars($consulta->getCarrera()) . "</p>";
        }
        
        $cuerpoMensaje .= "
            <p><b>Mensaje:</b></p>
            <p>" . nl2br(htmlspecialchars($consulta->getMensaje())) . "</p>";

        $mail->Body = $cuerpoMensaje;

        $mail->send();
        
        logMail("Email enviado exitosamente a " . $_ENV['MAIL_USERNAME']);
            
    $_SESSION['consultas_message'] = '¡Consulta enviada correctamente! Te responderemos a la brevedad a tu email: ' . htmlspecialchars($consulta->getEmail());
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
    } catch (Exception $e) {
        logMail("Error enviando email: " . $e->getMessage());
            
    $_SESSION['consultas_message'] = 'No se pudo enviar el mensaje. Por favor intenta nuevamente más tarde.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
    }
    exit;
}