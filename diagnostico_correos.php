<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico Sistema de Correos - IFTS15</title>
    <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    .info { color: blue; }
    .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    pre { background: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>

<h1>🔍 Diagnóstico Sistema de Correos - IFTS15</h1>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "<div class='section'>";
echo "<h2>1. ✅ Verificación de Variables de Entorno</h2>";

$envVars = ['MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 'MAIL_PASSWORD', 'MAIL_SMTPAuth'];
$allEnvOk = true;

foreach ($envVars as $var) {
    $value = $_ENV[$var] ?? null;
    if ($value) {
        if ($var === 'MAIL_PASSWORD') {
            echo "<span class='success'>✓ $var: CONFIGURADO</span><br>";
        } else {
            echo "<span class='success'>✓ $var: $value</span><br>";
        }
    } else {
        echo "<span class='error'>✗ $var: NO DEFINIDO</span><br>";
        $allEnvOk = false;
    }
}
echo "</div>";

// Prueba de configuración PHPMailer
echo "<div class='section'>";
echo "<h2>2. 📧 Prueba de Configuración PHPMailer</h2>";

if ($allEnvOk) {
    $mail = new PHPMailer(true);
    
    try {
        // Configuración básica
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = $_ENV['MAIL_SMTPAuth'] === 'true';
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = intval($_ENV['MAIL_PORT']);
        
        // Configuración adicional para Gmail en entornos corporativos
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        echo "<span class='success'>✓ Configuración PHPMailer completada</span><br>";
        
        // Intentar conectar sin enviar
        try {
            echo "<span class='info'>Intentando conectar al servidor SMTP...</span><br>";
            $mail->smtpConnect();
            echo "<span class='success'>✓ Conexión SMTP exitosa - ¡Los puertos NO están bloqueados!</span><br>";
            $mail->smtpClose();
        } catch (Exception $e) {
            echo "<span class='error'>✗ Error de conexión SMTP: " . $e->getMessage() . "</span><br>";
            if (strpos($e->getMessage(), 'Could not connect') !== false) {
                echo "<span class='warning'>⚠️ DIAGNÓSTICO: Probablemente los puertos SMTP estén bloqueados por el firewall corporativo</span><br>";
                echo "<span class='info'>🔧 SOLUCIÓN: Usar servidor SMTP alternativo o configurar proxy corporativo</span><br>";
            }
        }
        
    } catch (Exception $e) {
        echo "<span class='error'>✗ Error configuración PHPMailer: " . $e->getMessage() . "</span><br>";
    }
} else {
    echo "<span class='warning'>⚠️ No se puede probar PHPMailer - Variables de entorno faltantes</span><br>";
}
echo "</div>";

// Prueba de envío real (opcional)
if (isset($_GET['test_send']) && $_GET['test_send'] === 'yes' && $allEnvOk) {
    echo "<div class='section'>";
    echo "<h2>3. 📬 Prueba de Envío Real</h2>";
    
    $mail = new PHPMailer(true);
    
    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = $_ENV['MAIL_SMTPAuth'] === 'true';
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = intval($_ENV['MAIL_PORT']);
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        // Debug habilitado
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        
        $mail->setFrom($_ENV['MAIL_USERNAME'], 'IFTS15 - TEST');
        $mail->addAddress($_ENV['MAIL_USERNAME']); // Enviar a nosotros mismos
        
        $mail->isHTML(true);
        $mail->Subject = 'Prueba Sistema Correos IFTS15 - ' . date('Y-m-d H:i:s');
        $mail->Body = '<h3>¡Prueba exitosa!</h3><p>El sistema de correos de IFTS15 está funcionando correctamente.</p>';
        
        echo "<pre>";
        $mail->send();
        echo "</pre>";
        echo "<span class='success'>✓ ¡Correo de prueba enviado exitosamente!</span><br>";
        
    } catch (Exception $e) {
        echo "<span class='error'>✗ Error al enviar correo de prueba:</span><br>";
        echo "<div class='error'>Mensaje: " . $e->getMessage() . "</div>";
        echo "<div class='error'>ErrorInfo: " . $mail->ErrorInfo . "</div>";
    }
    echo "</div>";
}

?>

<div class="section">
    <h2>4. 🔧 Acciones de Diagnóstico</h2>
    
    <?php if (!isset($_GET['test_send'])): ?>
    <p><strong>Para hacer una prueba completa de envío:</strong></p>
    <a href="?test_send=yes" style="background: #007cba; color: white; padding: 10px 15px; text-decoration: none; border-radius: 3px;">
        🚀 Ejecutar Prueba de Envío
    </a>
    <?php endif; ?>
    
    <h3>🧪 Tests Adicionales:</h3>
    <div style="margin: 15px 0;">
        <a href="test_mail.php" target="_blank" style="background: #28a745; color: white; padding: 8px 12px; text-decoration: none; border-radius: 3px; margin-right: 10px;">
            📧 Test Básico de Correo
        </a>
        <a href="test_mail_ssl.php" target="_blank" style="background: #17a2b8; color: white; padding: 8px 12px; text-decoration: none; border-radius: 3px;">
            🔒 Test con SSL
        </a>
    </div>
    
    <h3>📋 Pasos Recomendados:</h3>
    <ol>
        <li><strong>Verificar configuración Gmail:</strong> 
            <ul>
                <li>Asegúrate de que la verificación en 2 pasos esté habilitada</li>
                <li>Usa una contraseña de aplicación específica (no tu contraseña de Gmail)</li>
                <li>Verifica que el email <code><?php echo $_ENV['MAIL_USERNAME'] ?? 'NO_CONFIGURADO'; ?></code> sea correcto</li>
            </ul>
        </li>
        <li><strong>Si estás en el trabajo:</strong> Los puertos 587/465 pueden estar bloqueados por el firewall corporativo</li>
        <li><strong>Alternativas para trabajo:</strong> 
            <ul>
                <li>Usar un servicio de correo específico para desarrollo como Mailtrap</li>
                <li>Configurar un proxy corporativo</li>
                <li>Probar desde casa o red personal</li>
            </ul>
        </li>
    </ol>
</div>

</body>
</html>