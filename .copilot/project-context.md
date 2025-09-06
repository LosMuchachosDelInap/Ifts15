# Contexto del Proyecto IFTS15
# Sistema Web Educativo

## 🎯 Objetivo Principal
Desarrollo de un sistema web educativo funcional basado en template Moodle convertido a PHP nativo con arquitectura MVC.

## 📋 Información del Proyecto

### Datos Básicos
- **Nombre**: IFTS15 - Sistema Educativo Web
- **Tipo**: Aplicación web educativa PHP
- **Origen**: Template estático Moodle convertido
- **Framework**: PHP nativo + Bootstrap 5
- **Base de Datos**: MySQL
- **Servidor**: XAMPP (Apache + PHP + MySQL)

### Tecnologías Utilizadas
- **Backend**: PHP 8.x con PDO
- **Frontend**: Bootstrap 5, Font Awesome 6, JavaScript ES6+
- **Base de Datos**: MySQL 8.x
- **Servidor Local**: XAMPP
- **Control de Versiones**: Git (configurado)

## 🏗️ Arquitectura del Sistema

### Estructura MVC Implementada
```
ifts15/
├── config/                     # Configuración del sistema
│   ├── config.php              # Configuración general
│   └── database.php            # Conexión PDO
├── includes/                   # Archivos de inicialización
│   └── init.php                # Funciones globales y auth
├── layouts/                    # Componentes de UI modulares
│   ├── header.php              # HTML base y metadata
│   ├── navbar.php              # Navegación horizontal
│   ├── sidebar.php             # Navegación vertical
│   └── footer.php              # Scripts y footer
├── assets/                     # Recursos estáticos
│   ├── css/custom.css          # Estilos personalizados
│   └── js/main.js              # JavaScript principal
├── database/                   # Esquemas y datos
│   └── ifts15_schema.sql       # Schema completo
├── pages/                      # Páginas del sistema (pendiente)
├── admin/                      # Panel administrativo (pendiente)
├── controllers/                # Controladores (pendiente)
├── models/                     # Modelos de datos (pendiente)
└── views/                      # Vistas específicas (pendiente)
```

### Componentes Principales

#### 1. Sistema de Configuración
- **config.php**: Constantes de DB, URLs, configuración de entorno
- **database.php**: Clase singleton para conexión PDO

#### 2. Sistema de Autenticación
- **init.php**: Funciones de login, logout, verificación de roles
- Roles: admin, profesor, estudiante, personal
- Sesiones PHP seguras

#### 3. Sistema de Navegación
- **navbar.php**: Navegación horizontal responsive
- **sidebar.php**: Navegación vertical para usuarios autenticados
- Menús dinámicos basados en roles

#### 4. Base de Datos
- 8 tablas principales: usuarios, perfiles, carreras, materias, inscripciones, noticias, eventos, configuración
- Relaciones definidas entre entidades
- Datos de ejemplo incluidos

## 🎨 Diseño y UX

### Características de Diseño
- **Responsive Design**: Compatible móvil/tablet/desktop
- **Bootstrap 5**: Framework CSS moderno
- **Font Awesome 6**: Iconografía consistente
- **CSS Variables**: Personalización de colores y espaciado
- **Animaciones CSS**: Transiciones suaves en sidebar y cards

### Colores del Sistema
```css
:root {
    --primary-color: #007bff;
    --secondary-color: #6c757d;
    --success-color: #28a745;
    --info-color: #17a2b8;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --dark-color: #343a40;
    --light-color: #f8f9fa;
}
```

## 🔐 Sistema de Autenticación

### Roles y Permisos
- **Admin**: Acceso completo al sistema y panel administrativo
- **Profesor**: Gestión de materias y estudiantes
- **Estudiante**: Acceso a contenido educativo y inscripciones
- **Personal**: Funciones administrativas limitadas

### Usuarios de Ejemplo
```
admin@ifts15.edu.ar / admin123 (Administrador)
profesor@ifts15.edu.ar / prof123 (Profesor)
estudiante@ifts15.edu.ar / est123 (Estudiante)
personal@ifts15.edu.ar / per123 (Personal)
```

## 🗄️ Esquema de Base de Datos

### Tablas Principales
1. **usuarios**: Información básica de usuarios
2. **perfiles**: Datos extendidos por rol
3. **carreras**: Programas educativos
4. **materias**: Asignaturas por carrera
5. **inscripciones**: Relación estudiante-materia
6. **noticias**: Contenido informativo
7. **eventos**: Calendario académico
8. **configuracion**: Parámetros del sistema

## 🚀 Estado Actual

### Funcionalidades Implementadas ✅
- Sistema de autenticación completo
- Navegación responsive modular
- Base de datos con esquema completo
- Configuración de entorno
- Estilos y scripts personalizados
- Estructura MVC base

### En Desarrollo 🔄
- Páginas específicas del sistema
- Panel administrativo
- Dashboard de usuario
- Controladores y modelos

### Pendiente 📋
- Configuración de MySQL en XAMPP
- Creación de páginas de contenido
- Sistema de gestión de materias
- Reportes y estadísticas

## 🔧 Configuración de Desarrollo

### Servidor Local
```bash
# Ejecutar servidor PHP integrado
php -S localhost:8000
```

### Variables de Entorno
- **DB_HOST**: localhost
- **DB_NAME**: ifts15_db
- **DB_USER**: root
- **DB_PASS**: (vacío en XAMPP)
- **DEBUG_MODE**: true (desarrollo)

---

**Última actualización**: 6 de septiembre de 2025
**Próxima sesión**: Configuración de base de datos MySQL
