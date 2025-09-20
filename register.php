<?php
/**
 * Procesamiento de Registro - IFTS15
 * Archivo: register.php (solo procesamiento, sin vista)
 * Migrado a phpdotenv
 */

// Cargar configuración central con phpdotenv
require_once __DIR__ . '/src/config.php';
require_once __DIR__ . '/src/Database.php';

// Si el usuario ya está logueado, redirigir
if (isLoggedIn()) {
    header('Location: ' . BASE_URL);
    exit;
}

// Si alguien accede directamente sin POST, redirigir al inicio
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL);
    exit;
}

// Procesar formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
    $edad = (int)($_POST['edad'] ?? 0);
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['clave'] ?? '';
    $carrera_id = (int)($_POST['id_carrera'] ?? 0);
    $comision_id = (int)($_POST['id_comision'] ?? 0);
    $anio_cursada_id = (int)($_POST['id_añoCursada'] ?? 0);
    
    // Validaciones básicas
    if (empty($nombre) || empty($apellido) || empty($dni) || empty($fecha_nacimiento) || empty($email) || empty($password)) {
        showError('Todos los campos básicos son obligatorios');
        header('Location: ' . BASE_URL . '/#register');
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        showError('El email no es válido');
        header('Location: ' . BASE_URL . '/#register');
        exit;
    } elseif (strlen($password) < 6) {
        showError('La contraseña debe tener al menos 6 caracteres');
        header('Location: ' . BASE_URL . '/#register');
        exit;
    } elseif ($edad < 16 || $edad > 99) {
        showError('La edad debe estar entre 16 y 100 años');
        header('Location: ' . BASE_URL . '/#register');
        exit;
    } else {
        // NOTA: Los datos académicos son opcionales por ahora
        try {
            $db = Database::getInstance();
            
            // Verificar si el email ya existe
            $existing_user = $db->fetchOne("SELECT id_usuario FROM usuario WHERE email = ?", [$email]);
            
            if ($existing_user) {
                showError('Ya existe un usuario con ese email');
                header('Location: ' . BASE_URL . '/#register');
                exit;
            } else {
                // Verificar si el DNI ya existe
                $existing_person = $db->fetchOne("SELECT id_persona FROM persona WHERE dni = ?", [$dni]);
                
                if ($existing_person) {
                    showError('Ya existe una persona con ese DNI');
                    header('Location: ' . BASE_URL . '/#register');
                    exit;
                } else {
                    // Obtener el ID del rol "Alumno" (por defecto)
                    $rol_alumno = $db->fetchOne("SELECT id_rol FROM roles WHERE rol = 'Alumno' AND habilitado = 1");
                    
                    if (!$rol_alumno) {
                        showError('Error: No se encontró el rol de Alumno en el sistema');
                        header('Location: ' . BASE_URL . '/#register');
                        exit;
                    } else {
                        // Iniciar transacción
                        $db->beginTransaction();
                        
                        try {
                            // 1. Insertar en tabla persona
                            $db->execute("
                                INSERT INTO persona (apellido, nombre, dni, telefono, fecha_nacimiento, edad) 
                                VALUES (?, ?, ?, ?, ?, ?)
                            ", [$apellido, $nombre, $dni, $telefono, $fecha_nacimiento, $edad]);
                            $persona_id = $db->getLastInsertId();
                            
                            // 2. Insertar en tabla usuario (rol Alumno por defecto)
                            // Hash de la contraseña
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            
                            // Preparar campos opcionales de datos académicos con valores por defecto
                            $carrera_value = $carrera_id > 0 ? $carrera_id : null;
                            $comision_value = $comision_id > 0 ? $comision_id : null;
                            $anio_value = $anio_cursada_id > 0 ? $anio_cursada_id : null;
                            
                            // Si faltan valores, usar los primeros disponibles
                            if (!$carrera_value) {
                                $default_carrera = $db->fetchOne("SELECT id_carrera FROM carrera LIMIT 1");
                                $carrera_value = $default_carrera ? $default_carrera['id_carrera'] : 1;
                            }
                            if (!$comision_value) {
                                $default_comision = $db->fetchOne("SELECT id_comision FROM comision LIMIT 1");
                                $comision_value = $default_comision ? $default_comision['id_comision'] : 1;
                            }
                            if (!$anio_value) {
                                $default_anio = $db->fetchOne("SELECT id_añoCursada FROM añocursada LIMIT 1");
                                $anio_value = $default_anio ? $default_anio['id_añoCursada'] : 1;
                            }
                            
                            $db->query("
                                INSERT INTO usuario (email, clave, id_persona, id_rol, id_carrera, id_comision, id_añoCursada, habilitado) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, 1)
                            ", [$email, $hashedPassword, $persona_id, $rol_alumno['id_rol'], $carrera_value, $comision_value, $anio_value]);
                            $user_id = $db->lastInsertId();
                            
                            // Confirmar transacción
                            $db->commit();
                            
                            showSuccess('Usuario registrado exitosamente. Ya puedes iniciar sesión.');
                            header('Location: ' . BASE_URL . '/#login');
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
            header('Location: ' . BASE_URL . '/#register');
            exit;
        }
    }
}
?>
