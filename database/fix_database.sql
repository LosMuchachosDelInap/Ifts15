-- Correcciones para la base de datos IFTS15
-- Ejecutar DESPUÉS de importar ifts15.sql

USE `ifts15`;

-- 1. Ampliar el campo clave para soportar password_hash()
ALTER TABLE `usuario` 
MODIFY COLUMN `clave` VARCHAR(255) NOT NULL;

-- 2. Agregar la declaración USE al inicio del archivo principal
-- (Ya corregido en ifts15.sql)

-- 3. Verificar datos de prueba
SELECT 'Verificando datos...' as status;

SELECT 'Carreras disponibles:' as info;
SELECT id_carrera, carrera FROM carrera WHERE habilitado = 1;

SELECT 'Comisiones disponibles:' as info;
SELECT id_comision, comision FROM comision WHERE habilitado = 1;

SELECT 'Años de cursada disponibles:' as info;
SELECT id_añoCursada, año FROM añocursada WHERE habilitado = 1;

SELECT 'Roles disponibles:' as info;
SELECT id_rol, rol FROM roles WHERE habilitado = 1;