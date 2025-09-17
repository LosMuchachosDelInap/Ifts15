<?php
/**
 * Procesamiento de Registro - IFTS15
 * Archivo: register.php (solo procesamiento, sin vista)
 */

require_once 'includes/init.php';

// Si el usuario ya está logueado, redirigir
if (isLoggedIn()) {
    header('Location: ' . SITE_URL);
    exit;
}

// Si alguien accede directamente sin POST, redirigir al inicio
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . SITE_URL);
    exit;
}

// Procesar formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: mostrar datos recibidos
    if (DEBUG_MODE) {
        error_log("DEBUG POST Data: " . json_encode($_POST));
    }
    
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $edad = (int)($_POST['edad'] ?? 0);
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['clave'] ?? '';
    $carrera_id = (int)($_POST['id_carrera'] ?? 0);
    $comision_id = (int)($_POST['id_comision'] ?? 0);
    $anio_cursada_id = (int)($_POST['id_añoCursada'] ?? 0);
    
    if (DEBUG_MODE) {
        error_log("DEBUG Datos procesados - Carrera: $carrera_id, Comisión: $comision_id, Año: $anio_cursada_id");
    }
    
    // Validaciones básicas
    if (empty($nombre) || empty($apellido) || empty($dni) || empty($telefono) || empty($email) || empty($password)) {
        showError('Todos los campos básicos son obligatorios');
        header('Location: ' . SITE_URL . '/#register');
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        showError('El email no es válido');
        header('Location: ' . SITE_URL . '/#register');
        exit;
    } elseif (strlen($password) < 6) {
        showError('La contraseña debe tener al menos 6 caracteres');
        header('Location: ' . SITE_URL . '/#register');
        exit;
    } elseif ($edad < 16 || $edad > 100) {
        showError('La edad debe estar entre 16 y 100 años');
        header('Location: ' . SITE_URL . '/#register');
        exit;
    } else {
        // NOTA: Los datos académicos son opcionales por ahora
        try {
            $db = Database::getInstance();
            
            // Verificar si el email ya existe
            $existing_user = $db->fetchOne("SELECT id FROM usuario WHERE email = ?", [$email]);
            
            if ($existing_user) {
                showError('Ya existe un usuario con ese email');
                header('Location: ' . SITE_URL . '/#register');
                exit;
            } else {
                // Verificar si el DNI ya existe
                $existing_person = $db->fetchOne("SELECT id FROM persona WHERE dni = ?", [$dni]);
                
                if ($existing_person) {
                    showError('Ya existe una persona con ese DNI');
                    header('Location: ' . SITE_URL . '/#register');
                    exit;
                } else {
                    // Obtener el ID del rol "Alumno" (por defecto)
                    $rol_alumno = $db->fetchOne("SELECT id_rol FROM roles WHERE rol = 'Alumno' AND habilitado = 1");
                    
                    if (!$rol_alumno) {
                        showError('Error: No se encontró el rol de Alumno en el sistema');
                        header('Location: ' . SITE_URL . '/#register');
                        exit;
                    } else {
                        // Iniciar transacción
                        $db->beginTransaction();
                        
                        try {
                            // 1. Insertar en tabla persona
                            $db->query("
                                INSERT INTO persona (apellido, nombre, dni, telefono, edad) 
                                VALUES (?, ?, ?, ?, ?)
                            ", [$apellido, $nombre, $dni, $telefono, $edad]);
                            $persona_id = $db->lastInsertId();
                            
                            // 2. Insertar en tabla usuario (rol Alumno por defecto)
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            
                            // Preparar campos opcionales de datos académicos
                            $carrera_value = $carrera_id > 0 ? $carrera_id : null;
                            $comision_value = $comision_id > 0 ? $comision_id : null;
                            $anio_value = $anio_cursada_id > 0 ? $anio_cursada_id : null;
                            
                            $db->query("
                                INSERT INTO usuario (email, clave, id_persona, id_rol, id_carrera, id_comision, id_añoCursada, habilitado) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, 1)
                            ", [$email, $hashedPassword, $persona_id, $rol_alumno['id_rol'], $carrera_value, $comision_value, $anio_value]);
                            $user_id = $db->lastInsertId();
                            
                            // Confirmar transacción
                            $db->commit();
                            
                            showSuccess('Usuario registrado exitosamente. Ya puedes iniciar sesión.');
                            header('Location: ' . SITE_URL . '/#login');
                            exit;
                            
                        } catch (Exception $e) {
                            // Revertir transacción en caso de error
                            $db->rollback();
                            throw $e;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                showError("Error: " . $e->getMessage());
            } else {
                showError('Error interno del sistema');
            }
            header('Location: ' . SITE_URL . '/#register');
            exit;
        }
    }
}
?>