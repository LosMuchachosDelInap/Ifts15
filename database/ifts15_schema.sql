/*
 * Base de datos para IFTS15 Sistema Web
 * Creado: 2024
 * Descripción: Esquema básico para sistema educativo
 */

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS ifts15_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ifts15_db;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    role ENUM('admin', 'profesor', 'estudiante', 'personal') DEFAULT 'estudiante',
    activo TINYINT(1) DEFAULT 1,
    email_verificado TINYINT(1) DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultima_conexion TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_activo (activo)
);

-- Tabla de perfiles de usuario (información adicional)
CREATE TABLE IF NOT EXISTS perfiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    dni VARCHAR(20),
    fecha_nacimiento DATE,
    direccion TEXT,
    ciudad VARCHAR(100),
    provincia VARCHAR(100),
    codigo_postal VARCHAR(10),
    biografia TEXT,
    foto_perfil VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de carreras
CREATE TABLE IF NOT EXISTS carreras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    duracion_anos INT DEFAULT 3,
    modalidad ENUM('presencial', 'virtual', 'hibrida') DEFAULT 'presencial',
    activa TINYINT(1) DEFAULT 1,
    imagen VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de materias
CREATE TABLE IF NOT EXISTS materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrera_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    codigo VARCHAR(20),
    descripcion TEXT,
    creditos INT DEFAULT 1,
    ano_cursada INT DEFAULT 1,
    cuatrimestre INT DEFAULT 1,
    activa TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (carrera_id) REFERENCES carreras(id) ON DELETE CASCADE,
    INDEX idx_carrera (carrera_id),
    INDEX idx_ano_cuatrimestre (ano_cursada, cuatrimestre)
);

-- Tabla de inscripciones a carreras
CREATE TABLE IF NOT EXISTS inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    carrera_id INT NOT NULL,
    ano_ingreso YEAR NOT NULL,
    estado ENUM('activo', 'graduado', 'abandonado', 'suspendido') DEFAULT 'activo',
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_graduacion DATE NULL,
    promedio DECIMAL(4,2) NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (carrera_id) REFERENCES carreras(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_carrera (usuario_id, carrera_id),
    INDEX idx_estado (estado),
    INDEX idx_ano_ingreso (ano_ingreso)
);

-- Tabla de noticias y anuncios
CREATE TABLE IF NOT EXISTS noticias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT NOT NULL,
    resumen TEXT,
    autor_id INT NOT NULL,
    categoria ENUM('general', 'academica', 'administrativa', 'evento') DEFAULT 'general',
    destacada TINYINT(1) DEFAULT 0,
    imagen VARCHAR(255),
    activa TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (autor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_categoria (categoria),
    INDEX idx_destacada (destacada),
    INDEX idx_activa (activa),
    INDEX idx_created_at (created_at)
);

-- Tabla de páginas estáticas
CREATE TABLE IF NOT EXISTS paginas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    contenido TEXT NOT NULL,
    meta_descripcion TEXT,
    activa TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_activa (activa)
);

-- Tabla de eventos
CREATE TABLE IF NOT EXISTS eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME,
    ubicacion VARCHAR(255),
    tipo ENUM('academico', 'cultural', 'deportivo', 'institucional') DEFAULT 'academico',
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_fecha_inicio (fecha_inicio),
    INDEX idx_tipo (tipo),
    INDEX idx_activo (activo)
);

-- Tabla de configuración del sistema
CREATE TABLE IF NOT EXISTS configuracion (
    id VARCHAR(100) PRIMARY KEY,
    valor TEXT NOT NULL,
    descripcion TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar datos iniciales

-- Usuario administrador por defecto
INSERT INTO usuarios (email, password, nombre, apellido, role, activo, email_verificado) VALUES
('admin@ifts15.edu.ar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'Sistema', 'admin', 1, 1);
-- Contraseña: password

-- Algunos usuarios de ejemplo
INSERT INTO usuarios (email, password, nombre, apellido, role, activo, email_verificado) VALUES
('profesor@ifts15.edu.ar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Juan', 'Pérez', 'profesor', 1, 1),
('estudiante@ifts15.edu.ar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'María', 'González', 'estudiante', 1, 1);

-- Carreras de ejemplo
INSERT INTO carreras (nombre, descripcion, duracion_anos, modalidad, activa) VALUES
('Técnico Superior en Desarrollo de Software', 'Formación integral en desarrollo de aplicaciones web y móviles', 3, 'presencial', 1),
('Técnico Superior en Redes y Seguridad', 'Especialización en administración de redes y ciberseguridad', 3, 'presencial', 1),
('Técnico Superior en Análisis de Sistemas', 'Análisis y diseño de sistemas informáticos', 3, 'presencial', 1);

-- Materias de ejemplo para Desarrollo de Software
INSERT INTO materias (carrera_id, nombre, codigo, descripcion, creditos, ano_cursada, cuatrimestre) VALUES
(1, 'Introducción a la Programación', 'ITP-101', 'Fundamentos de programación y lógica', 6, 1, 1),
(1, 'Matemática Aplicada', 'MAT-101', 'Matemática para informática', 4, 1, 1),
(1, 'Sistemas y Organizaciones', 'SYO-101', 'Análisis de sistemas organizacionales', 4, 1, 1),
(1, 'Programación Web', 'PWB-201', 'Desarrollo de aplicaciones web', 8, 2, 1),
(1, 'Base de Datos', 'BDD-201', 'Diseño y administración de bases de datos', 6, 2, 1);

-- Páginas estáticas iniciales
INSERT INTO paginas (titulo, slug, contenido, meta_descripcion, activa) VALUES
('Sobre Nosotros', 'nosotros', '<h2>Instituto de Formación Técnica Superior N° 15</h2><p>El IFTS15 es una institución educativa dedicada a la formación técnica superior...</p>', 'Conoce más sobre el IFTS15', 1),
('Biblioteca', 'biblioteca', '<h2>Biblioteca Virtual</h2><p>Accede a nuestros recursos bibliográficos...</p>', 'Recursos de la biblioteca del IFTS15', 1),
('Contacto', 'contacto', '<h2>Contacto</h2><p>Ponte en contacto con nosotros...</p>', 'Información de contacto del IFTS15', 1);

-- Configuración inicial del sistema
INSERT INTO configuracion (id, valor, descripcion) VALUES
('site_name', 'IFTS15 - Instituto de Formación Técnica Superior', 'Nombre del sitio web'),
('site_description', 'Instituto de Formación Técnica Superior N° 15', 'Descripción del sitio'),
('admin_email', 'admin@ifts15.edu.ar', 'Email del administrador'),
('maintenance_mode', '0', 'Modo mantenimiento (0=desactivado, 1=activado)'),
('max_file_upload', '5242880', 'Tamaño máximo de archivo en bytes (5MB)');

-- Noticias de ejemplo
INSERT INTO noticias (titulo, contenido, resumen, autor_id, categoria, destacada, activa) VALUES
('Bienvenidos al nuevo sistema web del IFTS15', 
 '<p>Nos complace anunciar el lanzamiento de nuestro nuevo sistema web, diseñado para mejorar la experiencia educativa de todos nuestros estudiantes y docentes.</p>',
 'Lanzamiento del nuevo sistema web institucional',
 1, 'general', 1, 1),
('Inscripciones abiertas para el ciclo 2024', 
 '<p>Ya están abiertas las inscripciones para todas nuestras carreras técnicas. No pierdas la oportunidad de formar parte de nuestra comunidad educativa.</p>',
 'Período de inscripciones 2024 ya disponible',
 1, 'academica', 1, 1);

-- Eventos de ejemplo
INSERT INTO eventos (titulo, descripcion, fecha_inicio, fecha_fin, ubicacion, tipo, activo) VALUES
('Jornada de Puertas Abiertas', 'Ven a conocer nuestras instalaciones y carreras', '2024-03-15 09:00:00', '2024-03-15 17:00:00', 'Campus IFTS15', 'institucional', 1),
('Seminario de Tecnologías Emergentes', 'Conferencia sobre las últimas tendencias en tecnología', '2024-04-20 14:00:00', '2024-04-20 18:00:00', 'Aula Magna', 'academico', 1);
