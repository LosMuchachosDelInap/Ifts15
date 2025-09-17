# Historial de Conversaciones - IFTS15

## 📅 Sesión: 16 de Septiembre 2025

### Problema Inicial: Navbar y Datos Académicos
**Usuario:** "cuando hago click en inicio en el navbar no se ve el carrusel"
**Usuario:** "los datos academicos no se muestran en el formulario"

### Evolución del Problema
1. **CSS y Navbar:** Se identificaron problemas de alineación en navbar
2. **Formulario de Registro:** Los campos académicos (carrera, comisión, año) no aparecían
3. **Database Issues:** Problemas con extensión PDO no disponible
4. **Modal vs Página:** Se descubrió que el problema estaba en el modal, no en register.php

### Soluciones Implementadas

#### 🔧 Problemas Técnicos Resueltos
1. **Extensión PDO Missing:**
   - Error: `Undefined constant PDO::MYSQL_ATTR_INIT_COMMAND`
   - Solución: Crear `database_mysqli.php` como alternativa MySQLi
   - Resultado: Sistema de BD completamente funcional

2. **Modal de Registro Incompleto:**
   - Problema: Modal en navbar.php solo tenía campos básicos
   - Solución: Agregado formulario completo con datos académicos
   - Campos agregados: teléfono, edad, dropdowns de carrera/comisión/año

3. **Inconsistencia de Nombres:**
   - Problema: Form usaba `name="password"`, PHP buscaba `$_POST['clave']`
   - Solución: Unificación de nombres de campos en HTML y PHP
   - Campos corregidos: id_carrera, id_comision, id_añoCursada

4. **Funciones Indefinidas:**
   - Error: `setError()` y `setSuccess()` no existían
   - Solución: Cambiar a `showError()` y `showSuccess()`
   - Total: 10 errores corregidos en register.php

#### 🎨 Mejoras de UX/UI
1. **Modal Expandido:**
   - Cambio de `modal-lg` a `modal-xl` para más espacio
   - Formulario organizado en secciones: Personales, Acceso, Académicos
   - Rol "Alumno" automático (campo hidden)

2. **JavaScript para Modales:**
   - Funciones `switchToLogin()` y `switchToRegister()`
   - Auto-apertura de modales con anclas (#login, #register)
   - Limpieza de URLs después de mostrar modal

3. **Flujo de Registro Optimizado:**
   - register.php convertido en procesador puro (sin HTML)
   - Redirecciones automáticas con modales
   - Manejo de errores y éxitos mejorado

### Arquitectura y Código

#### Estructura MySQLi Implementada
```php
class Database {
    public function fetchAll($sql, $params = [])
    public function fetchOne($sql, $params = [])
    public function query($sql, $params = [])
    public function lastInsertId()
    public function beginTransaction()
    public function commit()
    public function rollback()
}
```

#### Flujo de Registro Actual
1. Usuario → Modal Registro (navbar.php)
2. Envío → register.php (procesamiento)
3. Éxito → Redirect `/#login` (modal login abierto)
4. Error → Redirect `/#register` (modal registro abierto)

#### Datos Académicos Implementados
- **Carrera:** SELECT poblado desde tabla `carrera`
- **Comisión:** SELECT poblado desde tabla `comision`
- **Año:** SELECT poblado desde tabla `añocursada`
- **Opcionales:** Pueden dejarse en blanco
- **Almacenamiento:** Campos nullable en tabla `usuario`

### Decisiones de Diseño

#### ✅ Decisiones Correctas
1. **MySQLi sobre PDO:** Solución pragmática ante limitación técnica
2. **Modal único:** Eliminar página register.php dedicada, solo modal
3. **Rol automático:** Simplificar UX con rol "Alumno" por defecto
4. **Debug mode:** Mensajes informativos para desarrollo

#### ⚠️ Áreas de Mejora Identificadas
1. **Código duplicado:** Dropdowns en navbar.php y register.php
2. **Lógica mezclada:** Validación, BD y presentación juntos
3. **Sin abstracción:** Queries SQL directas en múltiples lugares
4. **Acoplamiento alto:** Dependencias hardcodeadas

### Estado Final de la Sesión
**Funcionalidades Completadas:**
✅ Modal de registro con todos los campos académicos
✅ Procesamiento correcto de datos en register.php  
✅ Base de datos MySQLi completamente funcional
✅ JavaScript para navegación entre modales
✅ Sistema de mensajes de error/éxito
✅ Todos los errores PHP corregidos

**Usuario Final:** "perfecto, ahora si"

### Próxima Fase: Refactorización MVC
**Usuario:** "vamos de a poco. Primero actualiza las conversaciones para poder sincronizarlas"

**Plan Acordado:**
1. Documentar todo en `.copilot/`
2. Refactorización progresiva a MVC
3. Mantener funcionalidad actual mientras se refactoriza
4. Críticas constructivas y mejores prácticas

### Lecciones Aprendidas
1. **Debugging incremental** es más efectivo que reescribir todo
2. **Alternativas técnicas** (MySQLi vs PDO) pueden ser necesarias
3. **UX simple** (modal único) puede ser mejor que múltiples páginas
4. **Documentación continua** es crucial para proyectos complejos
5. **Feedback directo** del usuario es invaluable para identificar problemas reales
