<?php
/**
 * Utility para envío de correos con PHPMailer.
 * Funciona leyendo configuración desde .env (MAIL_*) y devuelve array con success y message.
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../../vendor/autoload.php';

// Cargar dotenv si es necesario
if (file_exists(__DIR__ . '/../../../../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../../');
    if (method_exists($dotenv, 'safeLoad')) {
        $dotenv->safeLoad();
    } else {
        try { $dotenv->load(); } catch (Throwable $e) { /* ignore */ }
    }
}

function envio_mail($to, $subject, $body, $fromEmail = null, $fromName = null, $isHtml = true, $replyTo = null)
{
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'] ?? $_ENV['MAIL_HOSTNAME'] ?? 'localhost';
        $mail->SMTPAuth   = (isset($_ENV['MAIL_SMTPAuth']) && $_ENV['MAIL_SMTPAuth'] === 'true');
        $mail->Username   = $_ENV['MAIL_USERNAME'] ?? '';
        $mail->Password   = $_ENV['MAIL_PASSWORD'] ?? '';
        $mail->SMTPSecure = defined('PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS') ? PHPMailer::ENCRYPTION_STARTTLS : 'tls';
        $mail->Port       = intval($_ENV['MAIL_PORT'] ?? 587);

        // From
        $fromEmail = $fromEmail ?? ($_ENV['MAIL_FROM'] ?? $_ENV['MAIL_USERNAME'] ?? 'no-reply@localhost');
        $fromName = $fromName ?? ($_ENV['MAIL_FROM_NAME'] ?? 'IFTS15');
        $mail->setFrom($fromEmail, $fromName);

        // Destinatario(s)
        if (is_array($to)) {
            foreach ($to as $addr) $mail->addAddress($addr);
        } else {
            $mail->addAddress($to);
        }

        if ($replyTo) {
            $mail->addReplyTo($replyTo);
        }

        $mail->isHTML($isHtml);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return ['success' => true, 'message' => 'Enviado correctamente'];
    } catch (Exception $e) {
        // log minimal
        if (!file_exists(__DIR__ . '/../../../logs')) mkdir(__DIR__ . '/../../../logs', 0755, true);
        file_put_contents(__DIR__ . '/../../../logs/email_errors.log', date('c') . " - Error envio_mail: " . $e->getMessage() . PHP_EOL, FILE_APPEND | LOCK_EX);
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
