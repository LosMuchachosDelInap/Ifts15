# INSTRUCCIONES PARA SUBIR A INFINITYFREE
# Archivo: INFINITY_FREE_SETUP.md

## 📋 PASOS PARA SUBIR EL PROYECTO A INFINITYFREE

### 1. CREAR CUENTA Y DOMINIO
- Registrate en InfinityFree.net
- Crea un subdominio gratuito (ej: tuproyecto.infinityfreeapp.com)
- Espera a que se active (puede tomar hasta 72 horas)

### 2. OBTENER DATOS DE BASE DE DATOS
Una vez creada tu cuenta, ve al Panel de Control y busca:
- **MySQL Databases** - Crear una nueva base de datos
- Anota estos datos:
  - `DB_HOST`: sqlXXX.infinityfree.com
  - `DB_NAME`: epizXXX_ifts15 (o el nombre que elijas)
  - `DB_USER`: epizXXX_usuario
  - `DB_PASS`: la contraseña que configures

### 3. ACTUALIZAR CONFIGURACIÓN
Edita el archivo `config/config.php` líneas 17-21:
```php
// Configuración para PRODUCCIÓN (InfinityFree)
define('DB_HOST', 'sqlXXX.infinityfree.com'); // ← TU HOST AQUÍ
define('DB_NAME', 'epizXXX_ifts15'); // ← TU BASE DE DATOS AQUÍ
define('DB_USER', 'epizXXX_usuario'); // ← TU USUARIO AQUÍ
define('DB_PASS', 'tu_password_aqui'); // ← TU PASSWORD AQUÍ
```

### 4. SUBIR ARCHIVOS
Usando el File Manager de InfinityFree o un cliente FTP:
- Sube TODOS los archivos del proyecto a la carpeta `htdocs/`
- Estructura debe quedar así:
```
htdocs/
├── index.php
├── login.php
├── register.php
├── .htaccess
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── config/
├── includes/
├── layouts/
├── pages/
└── database/
```

### 5. IMPORTAR BASE DE DATOS
En el Panel de InfinityFree:
- Ve a **phpMyAdmin**
- Selecciona tu base de datos
- Ve a **Importar**
- Sube el archivo `database/ifts15_schema.sql`
- Ejecuta la importación

### 6. VERIFICAR FUNCIONAMIENTO
- Visita tu dominio (ej: tuproyecto.infinityfreeapp.com)
- Verifica que se vea la página principal
- Prueba el carrusel de imágenes
- Intenta hacer login con los usuarios de prueba:
  - admin@ifts15.edu.ar / admin123
  - estudiante@ifts15.edu.ar / est123

### 7. POSIBLES PROBLEMAS Y SOLUCIONES

#### Problema: "No se conecta a la base de datos"
**Solución**: Verifica que los datos en config.php sean exactos

#### Problema: "Imágenes no se ven"
**Solución**: 
- Asegúrate de subir la carpeta `assets/images/` completa
- Verifica permisos de archivos (644 para archivos, 755 para carpetas)

#### Problema: "Carrusel no funciona"
**Solución**:
- Verifica que Bootstrap esté cargando (ve el código fuente)
- Revisa la consola del navegador (F12) por errores de JavaScript

#### Problema: "Error 500"
**Solución**:
- Cambia `DEBUG_MODE` a `true` temporalmente en config.php
- Revisa los error logs en el panel de InfinityFree

### 8. OPTIMIZACIONES ADICIONALES
- Activa compresión GZIP (ya está en .htaccess)
- Optimiza imágenes antes de subir
- Considera usar CDN para Bootstrap y FontAwesome

### 9. ARCHIVOS IMPORTANTES
```
📁 Archivos que DEBES subir:
✅ Todos los archivos .php (index.php, login.php, etc.)
✅ Carpeta assets/ completa (CSS, JS, imágenes)
✅ Carpeta config/ completa
✅ Carpeta includes/ completa
✅ Carpeta layouts/ completa
✅ Carpeta database/ (para importar SQL)
✅ .htaccess

❌ NO subir:
❌ Archivos de configuración local
❌ Carpetas de desarrollo (.git, node_modules, etc.)
```

### 10. CONTACTO DE SOPORTE
- Si tienes problemas, revisa la documentación de InfinityFree
- También puedes consultar foros de ayuda de PHP

---
**Fecha de creación**: 10 de septiembre de 2025
**Versión del proyecto**: IFTS15 v1.0
