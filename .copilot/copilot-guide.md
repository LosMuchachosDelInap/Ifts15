# Guía GitHub Copilot - IFTS15

## 🤖 Instrucciones para Asistentes AI

### Contexto del Proyecto
Este proyecto es un **sistema educativo para IFTS15** construido en PHP puro con MySQL. El usuario está en proceso de **refactorización a patrón MVC** manteniendo toda la funcionalidad existente.

### Estado Técnico Actual
- **PHP 8.4.6** con MySQLi (PDO no disponible)
- **Bootstrap 5.3.2** para UI
- **Sistema de autenticación** funcional
- **Registro con datos académicos** implementado
- **Estructura monolítica** en proceso de refactorización

### Perfil del Usuario
- **Pragmático:** Quiere soluciones que funcionen
- **Crítico:** Pide feedback honesto, no solo confirmación
- **Metódico:** Prefiere pasos incrementales
- **Documentador:** Valora sincronización de contexto

### 🎯 Objetivos de la Colaboración

#### Para el Asistente
1. **Ser crítico constructivo:** Si algo no es la mejor práctica, explicarlo
2. **Sugerir mejores alternativas:** No solo hacer lo que se pide
3. **Explicar el "por qué":** Fundamentar las recomendaciones
4. **Mantener funcionalidad:** Nunca romper lo que ya funciona
5. **Documentar decisiones:** Actualizar este contexto regularmente

#### Para el Usuario
1. **Código más limpio y mantenible**
2. **Aprender mejores prácticas** de desarrollo
3. **Arquitectura MVC** bien implementada
4. **Base sólida** para futuras características

### 📋 Protocolo de Trabajo

#### Antes de Cualquier Cambio
1. **Leer todo el contexto** en `.copilot/`
2. **Entender el estado actual** del proyecto
3. **Verificar funcionalidad existente** antes de modificar
4. **Proponer plan paso a paso** si es un cambio grande

#### Durante el Desarrollo
1. **Explicar cada decisión** técnica importante
2. **Sugerir alternativas** cuando sea apropiado
3. **Mantener TODO list actualizado** con progreso real
4. **Testing continuo** de funcionalidades

#### Después de Cambios
1. **Actualizar documentación** en `.copilot/`
2. **Verificar que todo funciona** como antes
3. **Documentar nuevas funcionalidades** o cambios
4. **Preparar siguiente paso** lógico

### 🔧 Aspectos Técnicos Críticos

#### Base de Datos
- **Solo MySQLi:** PDO no está disponible
- **Queries preparadas:** Siempre usar parámetros
- **Transacciones:** Para operaciones complejas
- **Nombres consistentes:** Entre HTML, PHP y tablas

#### Arquitectura Actual
```
Monolítica → MVC (en progreso)
- Models: Lógica de datos
- Controllers: Lógica de negocio  
- Views: Presentación
- Core: Infraestructura común
```

#### Funcionalidades Críticas
- **Autenticación:** Login/logout funcional
- **Registro:** Modal con datos académicos
- **Navegación:** Navbar con modales
- **Roles:** Sistema básico implementado

### ⚠️ Red Flags - Evitar Absolutamente

#### Técnicas
- ❌ Mezclar HTML + PHP + SQL en mismo archivo
- ❌ Queries SQL directas sin preparación
- ❌ Romper funcionalidad existente
- ❌ Cambios masivos sin testing
- ❌ Hardcodear valores sin constantes

#### De Proceso
- ❌ Cambiar cosas sin entender el contexto actual
- ❌ No documentar decisiones importantes
- ❌ Asumir que algo funciona sin probarlo
- ❌ Ignorar feedback del usuario
- ❌ No actualizar la documentación

### 📚 Referencias y Recursos

#### Archivos Clave
- `includes/init.php` - Bootstrap del sistema
- `config/database_mysqli.php` - Clase de BD
- `layouts/navbar.php` - Modal de registro
- `register.php` - Procesamiento de registro

#### Tablas de BD Importantes
```sql
usuario (id, email, clave, id_persona, id_rol, id_carrera, id_comision, id_añoCursada)
persona (id, nombre, apellido, dni, telefono, edad)
roles (id_rol, rol, habilitado)
carrera (id_carrera, carrera, habilitado)
```

#### URLs del Sistema
- `/` - Página principal
- `/login.php` - Procesamiento login (POST only)
- `/register.php` - Procesamiento registro (POST only)  
- `/pages/dashboard.php` - Panel usuario logueado

### 🎯 Próximos Pasos Planificados

#### En Progreso
- **Estructura MVC:** Crear carpetas y organización
- **Models:** Abstraer User, Person, Career, etc.
- **Controllers:** AuthController, HomeController

#### Pendientes
- **Views refactoring:** Adaptar templates existentes
- **Router:** Sistema básico de rutas
- **Testing:** Verificar toda funcionalidad

### 💡 Tips para Nuevos Asistentes

1. **Siempre leer primero** toda la documentación en `.copilot/`
2. **Preguntar si no entiendes** algo del contexto
3. **Ser honesto** sobre limitaciones o mejores enfoques
4. **Proponer alternativas** cuando veas problemas
5. **Mantener el TODO actualizado** con progreso real
6. **Documentar las decisiones** importantes que tomes

### 🔄 Actualización de Esta Guía

**Última actualización:** 16 de septiembre de 2025
**Próxima revisión:** Después de completar refactorización MVC

**Cambios importantes siempre deben reflejarse aquí** para mantener continuidad entre sesiones y asistentes.
