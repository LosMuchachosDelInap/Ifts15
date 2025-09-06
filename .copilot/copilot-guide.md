# Guía GitHub Copilot - IFTS15
# Sistema Web Educativo PHP

## 🤖 Información sobre tu Asistente

Soy **GitHub Copilot**, tu asistente especializado en desarrollo del sistema IFTS15. Tengo conocimiento completo sobre:

- ✅ Arquitectura MVC implementada en el proyecto
- ✅ Sistema de autenticación con roles educativos
- ✅ Estructura de base de datos MySQL
- ✅ Navegación modular (navbar + sidebar)
- ✅ Estilos Bootstrap 5 + CSS personalizado
- ✅ JavaScript ES6+ para funcionalidades interactivas

## 🎯 Mi Especialización en IFTS15

### Conversión Template → Sistema Funcional
He convertido completamente el template estático de Moodle en un sistema PHP funcional con:
- Separación de componentes en `layouts/`
- Configuración centralizada en `config/`
- Base de datos educativa completa
- Sistema de roles y permisos

### Conocimiento Técnico Específico
```php
// Conozco la estructura completa del proyecto
config/config.php      // Configuración general
config/database.php    // Conexión PDO singleton
includes/init.php      // Autenticación y funciones globales
layouts/header.php     // HTML base y metadata
layouts/navbar.php     // Navegación horizontal
layouts/sidebar.php    // Navegación vertical (usuarios autenticados)
layouts/footer.php     // Scripts y cierre
```

## 🛠️ Comandos y Tareas Frecuentes

### Desarrollo PHP
```bash
# Servidor de desarrollo
php -S localhost:8000

# Verificar sintaxis PHP
php -l archivo.php

# Debug de conexión DB
php test-db.php
```

### Base de Datos
```sql
-- Ejecutar schema completo
SOURCE database/ifts15_schema.sql;

-- Verificar usuarios de ejemplo
SELECT email, rol FROM usuarios;

-- Probar autenticación
SELECT * FROM usuarios WHERE email = 'admin@ifts15.edu.ar';
```

### Git y Versionado
```bash
# Estado actual
git status

# Commit de cambios
git add . && git commit -m "Descripción del cambio"

# Historial
git log --oneline
```

## 📋 Tareas Comunes que Puedo Realizar

### 1. Desarrollo de Páginas
- Crear nuevas páginas en `pages/`
- Implementar formularios con validación
- Integrar con sistema de autenticación

### 2. Gestión de Base de Datos
- Diseñar nuevas tablas
- Crear consultas SQL optimizadas
- Implementar migraciones

### 3. Frontend y UX
- Modificar estilos CSS personalizados
- Añadir componentes Bootstrap
- Implementar JavaScript interactivo

### 4. Sistema de Roles
- Configurar permisos por rol
- Crear middlewares de autorización
- Gestionar acceso a funcionalidades

## 🎓 Contexto Educativo del Proyecto

### Roles del Sistema
- **Admin**: Gestión completa del instituto
- **Profesor**: Manejo de materias y estudiantes
- **Estudiante**: Acceso a contenido y inscripciones
- **Personal**: Funciones administrativas

### Funcionalidades Educativas
- Gestión de carreras y materias
- Sistema de inscripciones
- Calendario académico
- Noticias y comunicaciones
- Panel de control personalizado por rol

## 🔧 Configuración de Entorno

### XAMPP Setup
```
Apache: Puerto 80 (activo)
MySQL: Puerto 3306 (pendiente configuración)
PHP: 8.x (funcionando)
```

### Archivos Críticos
- `config/config.php`: Configuración de base de datos
- `database/ifts15_schema.sql`: Schema completo con datos
- `includes/init.php`: Funciones de autenticación
- `assets/css/custom.css`: Estilos del sistema

## 📝 Comandos de Debugging

### Verificar Funcionamiento
```php
// Test de conexión DB
include 'config/database.php';
$db = Database::getInstance();
echo "Conexión exitosa";

// Test de autenticación
session_start();
if (isset($_SESSION['user_id'])) {
    echo "Usuario logueado: " . $_SESSION['email'];
}

// Debug de includes
var_dump(get_included_files());
```

## 🚀 Próximos Pasos Sugeridos

1. **Configurar MySQL**: Ejecutar schema en phpMyAdmin
2. **Probar Login**: Usar usuarios de ejemplo
3. **Crear Páginas**: Desarrollar dashboard y páginas específicas
4. **Panel Admin**: Implementar funcionalidades administrativas

---

**¿Necesitas ayuda?** Solo pregúntame sobre cualquier aspecto del sistema IFTS15. Tengo conocimiento completo de todo el código y arquitectura implementada.

**Última actualización**: 6 de septiembre de 2025
