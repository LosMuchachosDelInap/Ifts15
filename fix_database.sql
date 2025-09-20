-- Correcciones para la base de datos IFTS15 (MySQL/MariaDB)
-- Agregar columnas faltantes a las tablas existentes

-- =============================================
-- OPCIÓN 1: Si tu tabla se llama "persona" (sin 's')
-- =============================================

-- Agregar columnas faltantes a la tabla 'persona'
ALTER TABLE persona ADD fecha_nacimiento DATE AFTER apellido;
ALTER TABLE persona ADD telefono VARCHAR(20) AFTER dni;
ALTER TABLE persona ADD direccion TEXT AFTER telefono;

-- =============================================
-- OPCIÓN 2: Si tu tabla se llama "personas" (con 's')
-- =============================================

-- Agregar columnas faltantes a la tabla 'personas'
ALTER TABLE personas ADD fecha_nacimiento DATE AFTER apellido;
ALTER TABLE personas ADD telefono VARCHAR(20) AFTER dni;
ALTER TABLE personas ADD direccion TEXT AFTER telefono;

-- =============================================
-- OPCIÓN 3: Verificar cuál tabla existe y mostrar estructura
-- =============================================

-- Ejecuta estas consultas para ver qué tienes:
SHOW TABLES LIKE '%persona%';
DESCRIBE persona;
DESCRIBE personas;

-- =============================================
-- Si necesitas cambiar el nombre de la tabla
-- =============================================

-- Si tienes 'persona' y quieres cambiarla a 'personas':
-- RENAME TABLE persona TO personas;

-- =============================================
-- Estructura completa recomendada para 'personas'
-- =============================================

/*
CREATE TABLE IF NOT EXISTS personas (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  apellido varchar(50) NOT NULL,
  fecha_nacimiento date DEFAULT NULL,
  dni varchar(20) NOT NULL,
  telefono varchar(20) DEFAULT NULL,
  direccion text DEFAULT NULL,
  email varchar(100) NOT NULL,
  fecha_creacion datetime DEFAULT CURRENT_TIMESTAMP,
  fecha_actualizacion datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY dni (dni),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
*/