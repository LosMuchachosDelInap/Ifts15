# Preferencias de Desarrollo - IFTS15
# Sistema Web Educativo

## 🎯 Metodología de Desarrollo

### Enfoque Principal
- **Desarrollo incremental**: Funcionalidades paso a paso
- **Testing continuo**: Verificación en cada cambio
- **Documentación clara**: Código autodocumentado y comentarios útiles
- **Estándares PHP**: PSR-4, PSR-12 para código limpio

### Prioridades del Proyecto
1. **Funcionalidad**: Sistema debe ser completamente operativo
2. **Seguridad**: Autenticación robusta y validación de datos
3. **Usabilidad**: Interfaz intuitiva para entorno educativo
4. **Escalabilidad**: Código preparado para crecimiento

## 🔧 Estándares de Código

### PHP
```php
// Preferencias establecidas
- PSR-4 autoloading
- Uso de PDO para base de datos
- Validación de datos en backend
- Sesiones seguras con regeneración de ID
- Escape de output para XSS prevention
```

### Frontend
```css
/* Estilos preferidos */
- Bootstrap 5 como base
- CSS Variables para personalización
- Mobile-first responsive design
- Animaciones CSS sutiles
- Iconografía Font Awesome 6
```

### JavaScript
```javascript
// Estándares aplicados
- ES6+ syntax
- Event listeners modernos
- Fetch API para AJAX
- Modularización de funciones
- Manejo de errores consistente
```

## 📁 Organización de Archivos

### Estructura Preferida
```
config/         # Configuración centralizada
includes/       # Funciones globales y helpers
layouts/        # Componentes de UI reutilizables
assets/         # Recursos estáticos organizados
pages/          # Páginas específicas del sistema
admin/          # Panel administrativo separado
database/       # Schemas y migraciones
```

### Convenciones de Nombres
- **Archivos PHP**: snake_case.php
- **Clases**: PascalCase
- **Funciones**: camelCase
- **Variables**: camelCase
- **Constantes**: UPPER_CASE
- **CSS**: kebab-case

## 🎨 Preferencias de UI/UX

### Diseño Visual
- **Colores**: Esquema educativo profesional (azules y grises)
- **Tipografía**: Inter/Roboto para legibilidad
- **Espaciado**: Consistente usando variables CSS
- **Cards**: Diseño moderno con sombras sutiles

### Navegación
- **Navbar horizontal**: Para navegación principal
- **Sidebar vertical**: Para usuarios autenticados
- **Breadcrumbs**: En páginas internas
- **Mobile menu**: Hamburger colapsible

### Componentes Preferidos
```html
<!-- Botones estándar -->
<button class="btn btn-primary">
<button class="btn btn-outline-secondary">

<!-- Cards consistentes -->
<div class="card shadow-sm">
<div class="card-header bg-light">

<!-- Formularios -->
<div class="form-floating mb-3">
<input type="text" class="form-control">
```

## 🔐 Seguridad y Validación

### Medidas Implementadas
- **Password hashing**: password_hash() con BCRYPT
- **Session security**: Regeneración de ID, httponly cookies
- **Input validation**: Sanitización y validación en backend
- **CSRF protection**: Tokens en formularios críticos
- **SQL injection**: Prepared statements exclusivamente

### Validaciones Estándar
```php
// Email
filter_var($email, FILTER_VALIDATE_EMAIL)

// Passwords
strlen($password) >= 8 && preg_match('/[A-Z]/', $password)

// Roles
in_array($role, ['admin', 'profesor', 'estudiante', 'personal'])
```

## 📊 Base de Datos

### Convenciones
- **Nombres**: snake_case para tablas y campos
- **Primary keys**: id (auto increment)
- **Foreign keys**: tabla_id
- **Timestamps**: created_at, updated_at
- **Soft deletes**: deleted_at (cuando aplicable)

### Relaciones Preferidas
```sql
-- Uno a muchos
carreras -> materias
usuarios -> inscripciones

-- Muchos a muchos
estudiantes <-> materias (via inscripciones)

-- Uno a uno
usuarios <-> perfiles
```

## 🧪 Testing y Debug

### Herramientas Utilizadas
- **Debug mode**: Variable en config.php
- **Error reporting**: E_ALL en desarrollo
- **Logging**: Error log personalizado
- **Test files**: test-db.php, test-auth.php

### Debugging Preferido
```php
// Debug simple
var_dump($variable);
die();

// Debug avanzado
error_log("Debug: " . print_r($data, true));

// Test de conexiones
try {
    $db = Database::getInstance();
    echo "OK";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## 🚀 Workflow de Desarrollo

### Proceso Estándar
1. **Análisis**: Entender requerimiento
2. **Diseño**: Planificar implementación
3. **Código**: Escribir funcionalidad
4. **Test**: Verificar funcionamiento
5. **Integración**: Merge con sistema existente
6. **Documentación**: Actualizar docs

### Git Workflow
```bash
# Desarrollo en ramas feature
git checkout -b feature/nueva-funcionalidad
git add .
git commit -m "feat: descripción clara del cambio"
git checkout main
git merge feature/nueva-funcionalidad
```

## 📝 Documentación

### Estilo de Comentarios
```php
/**
 * Autentica usuario en el sistema
 * 
 * @param string $email Email del usuario
 * @param string $password Password en texto plano
 * @return array|false Datos del usuario o false si falla
 */
function authenticateUser($email, $password) {
    // Implementación...
}
```

### README Updates
- Mantener README.md actualizado
- Incluir instrucciones de setup
- Documentar cambios importantes
- Ejemplos de uso

---

**Última actualización**: 6 de septiembre de 2025
**Próxima revisión**: Después de implementar páginas adicionales
