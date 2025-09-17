# IFTS15 - Contexto del Proyecto

## 📋 Estado Actual del Proyecto
**Fecha de última actualización:** 16 de septiembre de 2025

### Información General
- **Nombre:** IFTS15 - Sistema Educativo
- **Tecnologías:** PHP 8.4.6, MySQL, Bootstrap 5.3.2, Font Awesome
- **Servidor:** XAMPP con PHP Development Server (localhost:8000)
- **Base de datos:** MySQLi (alternativa a PDO por problemas de extensión)

### Estructura Actual del Proyecto
```
Ifts15/
├── .copilot/                   # Documentación y sincronización
├── config/
│   ├── config.php             # Configuraciones generales
│   ├── database.php           # Conexión PDO (no funcional)
│   └── database_mysqli.php    # Conexión MySQLi (funcional)
├── includes/
│   └── init.php              # Bootstrap y funciones globales
├── layouts/
│   ├── header.php            # <head> y CSS
│   ├── navbar.php            # Navegación + modales login/register
│   ├── sidebar.php           # Menú lateral para usuarios logueados
│   └── footer.php            # Scripts y cierre HTML
├── pages/
│   ├── consultas.php         # Formulario de contacto
│   ├── dashboard.php         # Panel para usuarios logueados
│   └── realizador-productor-tv.php # Información de carrera
├── assets/
│   ├── css/                  # Estilos personalizados
│   ├── js/                   # JavaScript personalizado
│   └── images/              # Imágenes del sitio
├── database/                 # Scripts SQL y migraciones
├── index.php                # Página principal
├── login.php                # Procesamiento de login (solo POST)
├── register.php             # Procesamiento de registro (solo POST)
├── logout.php               # Cerrar sesión
└── error404.php, error500.php # Páginas de error
```

### Sistema de Base de Datos
**Tablas principales:**
- `persona` - Datos personales (nombre, apellido, dni, telefono, edad)
- `usuario` - Credenciales y roles (email, clave hash, id_rol)
- `roles` - Tipos de usuario (Alumno, Profesor, Admin)
- `carrera` - Carreras disponibles
- `comision` - Comisiones por carrera
- `añocursada` - Años de cursada

**Relaciones:**
- usuario.id_persona → persona.id
- usuario.id_rol → roles.id_rol
- usuario.id_carrera → carrera.id_carrera (opcional)
- usuario.id_comision → comision.id_comision (opcional)
- usuario.id_añoCursada → añocursada.id_añoCursada (opcional)

### Funcionalidades Implementadas
✅ **Sistema de Autenticación:**
- Registro de usuarios con datos académicos opcionales
- Login con email/contraseña
- Roles automáticos (Alumno por defecto)
- Sesiones PHP seguras

✅ **Interfaz de Usuario:**
- Navbar responsive con modales de login/registro
- Página principal con carrusel
- Dashboard básico para usuarios logueados
- Sidebar para navegación interna

✅ **Gestión de Datos:**
- Formularios de registro completos
- Dropdowns poblados desde base de datos
- Validaciones server-side
- Manejo de errores y mensajes de éxito

### Problemas Técnicos Resueltos
- **Extensión PDO no disponible** → Implementación MySQLi
- **Campos académicos no aparecían** → Corrección de nombres de campos
- **Modal de registro incompleto** → Agregados todos los campos necesarios
- **Funciones indefinidas** → Corregidos setError/showError
- **Navbar no funcional** → JavaScript para modales implementado

### Próximos Pasos
🔄 **Refactorización MVC:**
- Separar lógica de negocio, datos y presentación
- Crear Models para entidades (User, Person, Career, etc.)
- Implementar Controllers para manejar flujo
- Mantener Views existentes funcionando

## 🔧 Configuración de Desarrollo

### Variables de Entorno
- `DEBUG_MODE = true` (mostrar errores de desarrollo)
- `DB_HOST = localhost`
- `DB_USER = root` 
- `DB_PASS = ''`
- `DB_NAME = ifts15`
- `SITE_URL = http://localhost:8000`

### Comandos de Servidor
```bash
cd "c:\xampp\htdocs\Mis_Proyectos\Ifts15"
php -S localhost:8000
```

### Testing
- **Formulario de registro:** Modal funcional con todos los campos
- **Login:** Procesamiento correcto de credenciales
- **Navegación:** Todas las páginas accesibles
- **Base de datos:** Queries MySQLi funcionando
