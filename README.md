# IFTS15 - Sistema Web Educativo

> Sistema web moderno desarrollado para el Instituto de Formación Técnica Superior N° 15.  
> Código limpio, documentado y optimizado para producción.

## ✨ Características Principales

- **🎨 Diseño Responsivo**: Interfaz adaptable a todos los dispositivos
- **🔐 Sistema de Autenticación**: Registro, login y gestión de sesiones seguras
- **👥 Gestión de Usuarios**: ABM completo con roles y permisos
- **📚 Gestión Académica**: Administración de carreras y materias con drag & drop
- **📧 Sistema de Correos**: Notificaciones automáticas por email
- **🗄️ Base de Datos MySQL**: Operaciones seguras con prepared statements
- **🏗️ Arquitectura MVC**: Código estructurado y mantenible
- **📱 Bootstrap 5**: Framework CSS moderno y componentes pre-diseñados
- **⚡ SortableJS**: Drag & drop fluido para gestión de materias

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Frameworks**: Bootstrap 5.3.2
- **Librerías**: 
  - PHPMailer (envío de correos)
  - phpdotenv (gestión de variables de entorno)
  - SortableJS (drag & drop)
- **Iconos**: Bootstrap Icons, Font Awesome

## 🚀 Instalación

### Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache recomendado)
- Extensiones PHP: mysqli, mbstring

### Configuración

1. **Importar base de datos**:
   ```sql
   mysql -u usuario -p nombre_bd < src/ConectionBD/ifts15.sql
   ```

2. **Configurar conexión**:
   - Editar `src/config.php` 
   - Actualizar datos de BD y variables de entorno

3. **Servidor local**:
   ```
   http://localhost/Mis_Proyectos/Ifts15/
   ```

## 📁 Estructura del Proyecto

```
Ifts15/
├── index.php                  # Página principal
├── login.php                  # Login de usuarios
├── logout.php                 # Logout
├── register.php               # Registro de usuarios
├── src/
│   ├── Components/            # Modales y componentes reutilizables
│   ├── ConectionBD/           # Conexión y SQL de la base de datos
│   ├── Controllers/           # Controladores (MVC)
│   ├── Css/                   # Hojas de estilo CSS
│   ├── Model/                 # Modelos de datos
│   ├── Public/
│   │   ├── images/            # Imágenes del sistema
│   │   └── Utilities/         # JS y utilidades
│   ├── Template/              # Templates: navbar, footer, sidebar, head
│   └── Views/                 # Vistas principales
├── README.md                  # Este archivo
└── ...                        # Otros archivos de configuración
```

## 🎯 Uso Básico

1. **Registrar usuario**: Completa el formulario de registro
2. **Iniciar sesión**: Ingresa con email y contraseña
3. **Navega**: Accede a las secciones según tu rol

## 🔧 Características Técnicas

- **Roles**: Estudiante (por defecto), Profesor, Admin
- **Validaciones**: Lado cliente y servidor
- **Seguridad**: Contraseñas hasheadas, protección SQL injection
- **MVC**: Separación clara de lógica, datos y vistas

## 📞 Contacto

Instituto de Formación Técnica Superior N° 15

---

**Desarrollado para:** Instituto de Formación Técnica Superior N° 15  
**Versión:** 1.0.0  
**Fecha:** 2025
```

### Paso 2: Configurar la Base de Datos

1. **Crear la base de datos:**
   ```sql
   CREATE DATABASE ifts15_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Importar el esquema:**
   ```bash
   mysql -u tu_usuario -p ifts15_db < database/ifts15_schema.sql
   ```

### Paso 3: Configurar la aplicación

1. **Editar archivo de configuración:**
   ```php
   // config/config.php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'ifts15_db');
   define('DB_USER', 'tu_usuario');
   define('DB_PASS', 'tu_contraseña');
   ```

2. **Configurar URL del sitio:**
   ```php
   define('SITE_URL', 'http://localhost/ifts15');
   ```

### Paso 4: Configurar permisos (Linux/Mac)

```bash
chmod 755 -R ./
chmod 644 config/config.php
```

### Paso 5: Probar la instalación

1. Visita: `http://localhost/ifts15/test-db.php`
2. Verifica que la conexión a la base de datos sea exitosa
3. Ve a: `http://localhost/ifts15/`

## 👥 Usuarios por Defecto

Después de importar el esquema, tendrás estos usuarios disponibles:

| Email | Contraseña | Rol |
|-------|------------|-----|
| admin@ifts15.edu.ar | password | admin |
| profesor@ifts15.edu.ar | password | profesor |
| estudiante@ifts15.edu.ar | password | estudiante |

## 📁 Estructura del Proyecto

```
ifts15/
├── config/
│   ├── config.php          # Configuración general
│   └── database.php        # Clase de conexión a BD
├── includes/
│   └── init.php            # Inicialización y funciones
├── layouts/
│   ├── header.php          # Header común
│   ├── sidebar.php         # Barra lateral navegación
│   └── footer.php          # Footer común
├── database/
│   └── ifts15_schema.sql   # Esquema de base de datos
├── pages/                  # Páginas adicionales
├── assets/                 # CSS, JS, imágenes
├── index.php               # Página principal
├── login.php               # Sistema de login
├── logout.php              # Cerrar sesión
└── test-db.php            # Test de conexión
```

## 🔧 Configuración Avanzada

### Debug Mode

Para activar el modo debug durante desarrollo:

```php
// config/config.php
define('DEBUG_MODE', true);
```

### Configuración de Email (Futuro)

```php
// config/config.php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu_email@gmail.com');
define('SMTP_PASS', 'tu_contraseña');
```

## 🎯 Uso del Sistema

### Para Administradores

1. **Login**: `admin@ifts15.edu.ar` / `password`
2. **Gestión de usuarios**: Panel de administración
3. **Configuración del sistema**: Personalización
4. **Gestión de contenido**: Noticias, páginas, eventos

### Para Profesores

1. **Acceso a materias**: Gestión de contenido académico
2. **Calificaciones**: Sistema de notas
3. **Comunicación**: Mensajería con estudiantes

### Para Estudiantes

1. **Consulta de materias**: Información académica
2. **Calificaciones**: Visualización de notas
3. **Recursos**: Acceso a material de estudio

## 🛠️ Desarrollo

### Agregar nuevas páginas

1. Crear archivo en directorio `pages/`
2. Incluir header y footer:
   ```php
   <?php 
   require_once '../includes/init.php';
   $pageTitle = 'Mi Nueva Página';
   include '../layouts/header.php'; 
   ?>
   
   <!-- Tu contenido aquí -->
   
   <?php include '../layouts/footer.php'; ?>
   ```

### Agregar nuevos roles

1. Modificar enum en tabla `usuarios`
2. Actualizar funciones en `includes/init.php`
3. Agregar permisos en `layouts/sidebar.php`

## 🔒 Seguridad

- **Passwords**: Hasheados con `password_hash()`
- **SQL Injection**: Prevenido con PDO prepared statements
- **XSS**: Datos sanitizados con `htmlspecialchars()`
- **CSRF**: Validación de sesiones
- **Roles**: Control de acceso basado en roles

## 📚 Base de Datos

### Tablas Principales

- **usuarios**: Información de usuarios y autenticación
- **perfiles**: Datos adicionales de usuarios
- **carreras**: Carreras disponibles
- **materias**: Materias por carrera
- **inscripciones**: Relación estudiante-carrera
- **noticias**: Sistema de noticias
- **eventos**: Gestión de eventos
- **paginas**: Contenido estático

## 🚨 Troubleshooting

### Error de conexión a BD

1. Verifica que MySQL esté ejecutándose
2. Confirma credenciales en `config/config.php`
3. Verifica que la base de datos existe
4. Comprueba permisos del usuario MySQL

### Página en blanco

1. Activa `DEBUG_MODE = true`
2. Revisa logs de PHP
3. Verifica permisos de archivos
4. Comprueba sintaxis PHP

### Problemas de CSS/JS

1. Verifica que `SITE_URL` esté configurada correctamente
2. Comprueba que los archivos de Bootstrap se carguen
3. Revisa la consola del navegador

## 📞 Soporte

Para problemas técnicos o consultas sobre el desarrollo:

- **Email**: soporte@ifts15.edu.ar
- **Documentación**: Ver archivos en `/docs` (si están disponibles)

## 📄 Licencia

Este proyecto fue desarrollado específicamente para el IFTS15 como parte de un proyecto educativo.

---

**Desarrollado para:** Instituto de Formación Técnica Superior N° 15  
**Versión:** 1.0.0  
**Fecha:** 2024
