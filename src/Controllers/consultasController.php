<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Model/Consulta.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log para debugging
file_put_contents(__DIR__ . '/../../logs/consultas_debug.log', 
    "[" . date('Y-m-d H:i:s') . "] Iniciando controlador de consultas\n", 
    FILE_APPEND | LOCK_EX);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents(__DIR__ . '/../../logs/consultas_debug.log', 
        "[" . date('Y-m-d H:i:s') . "] POST recibido: " . print_r($_POST, true) . "\n", 
        FILE_APPEND | LOCK_EX);

    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $carrera = trim($_POST['carrera'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    // Validar campos obligatorios
    if (empty($nombre) || empty($email) || empty($mensaje)) {
        echo "<div class='alert alert-danger'>Debe completar todos los campos obligatorios (Nombre, Email y Consulta).</div>";
        exit;
    }

    // Validar email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Por favor ingrese un email válido.</div>";
        exit;
    }

    // Crear objeto consulta
    $consulta = new Consulta($nombre, $email, $mensaje, $telefono, $carrera);

    $mail = new PHPMailer(true);
    try {
        // Log antes de enviar
        file_put_contents(__DIR__ . '/../../logs/consultas_debug.log', 
            "[" . date('Y-m-d H:i:s') . "] Intentando enviar email...\n", 
            FILE_APPEND | LOCK_EX);

        // Configuración SMTP - Optimizada para entornos corporativos
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = $_ENV['MAIL_SMTPAuth'] === 'true';
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['MAIL_PORT'];
        
        // 🔧 CONFIGURACIÓN ESPECIAL PARA TRABAJO 🔧
        // Esta configuración funciona en entornos corporativos con firewalls restrictivos
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
                'cafile' => false,
                'capath' => false,
                'SNI_enabled' => true,
                'disable_compression' => true,
            )
        );

        // Debug SMTP
        $mail->SMTPDebug = 0; // 0 = off, 1 = client, 2 = client and server
        $mail->Debugoutput = function($str, $level) {
            file_put_contents(__DIR__ . '/../../logs/consultas_debug.log', 
                "[" . date('Y-m-d H:i:s') . "] SMTP Debug: $str\n", 
                FILE_APPEND | LOCK_EX);
        };

        $mail->setFrom($consulta->getEmail(), $consulta->getNombre());
        $mail->addAddress($_ENV['MAIL_USERNAME']); // Destinatario

        $mail->isHTML(true);
        $mail->Subject = 'Nueva consulta desde IFTS15 - ' . ($consulta->getCarrera() ? $consulta->getCarrera() : 'Información general');
        
        // Construir el cuerpo del mensaje
        $cuerpoMensaje = "
            <h3>Nueva consulta desde el sitio web IFTS15</h3>
            <hr>
            <p><b>Nombre:</b> " . htmlspecialchars($consulta->getNombre()) . "</p>
            <p><b>Email:</b> " . htmlspecialchars($consulta->getEmail()) . "</p>";
        
        if (!empty($consulta->getTelefono())) {
            $cuerpoMensaje .= "<p><b>Teléfono:</b> " . htmlspecialchars($consulta->getTelefono()) . "</p>";
        }
        
        if (!empty($consulta->getCarrera())) {
            $cuerpoMensaje .= "<p><b>Carrera de interés:</b> " . htmlspecialchars($consulta->getCarrera()) . "</p>";
        }
        
        $cuerpoMensaje .= "
            <hr>
            <p><b>Consulta:</b></p>
            <div style='background-color: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; margin: 10px 0;'>
                " . nl2br(htmlspecialchars($consulta->getMensaje())) . "
            </div>
            <hr>
            <p style='font-size: 12px; color: #666;'>
                Este mensaje fue enviado desde el formulario de consultas del sitio web IFTS15.<br>
                Fecha y hora: " . date('d/m/Y H:i:s') . "
            </p>";

        $mail->Body = $cuerpoMensaje;

        $mail->send();
        
        file_put_contents(__DIR__ . '/../../logs/consultas_debug.log', 
            "[" . date('Y-m-d H:i:s') . "] Email enviado exitosamente\n", 
            FILE_APPEND | LOCK_EX);
            
        echo "<div class='alert alert-success'>¡Consulta enviada correctamente! Te responderemos a la brevedad a tu email: " . htmlspecialchars($consulta->getEmail()) . "</div>";
    } catch (Exception $e) {
        file_put_contents(__DIR__ . '/../../logs/consultas_debug.log', 
            "[" . date('Y-m-d H:i:s') . "] Error enviando email: " . $e->getMessage() . "\n", 
            FILE_APPEND | LOCK_EX);
            
        echo "<div class='alert alert-danger'>No se pudo enviar el mensaje. Por favor intenta nuevamente más tarde.<br>Error técnico: {$mail->ErrorInfo}</div>";
    }
    exit;
}