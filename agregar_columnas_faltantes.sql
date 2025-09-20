-- Agregar SOLO la columna 'direccion' que falta en la tabla 'persona'
-- Ejecutar en InfinityFree (MySQL/MariaDB)

-- Agregar columna 'direccion'
ALTER TABLE persona ADD direccion TEXT;

-- Verificar la estructura actualizada
DESCRIBE persona;