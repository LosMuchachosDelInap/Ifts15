# Preferencias de Desarrollo - IFTS15

## 👤 Perfil del Usuario/Desarrollador

### Estilo de Trabajo
- **Enfoque:** Progresivo y paso a paso
- **Comunicación:** Directa, quiere feedback crítico y constructivo
- **Metodología:** "Si no es correcto, dímelo y corrígeme"
- **Organización:** Valora la sincronización y documentación completa

### Preferencias Técnicas

#### Arquitectura
- **Objetivo:** Refactorización a patrón MVC
- **Prioridad:** Código ordenado y mantenible
- **Enfoque:** Separación clara de responsabilidades
- **Estilo:** Clean Code, mejores prácticas

#### Base de Datos
- **Actual:** MySQLi (por limitaciones de PDO)
- **Consultas:** Preparadas con parámetros
- **Transacciones:** Implementadas para operaciones complejas
- **Nombres:** Consistentes entre HTML, PHP y BD

#### Frontend
- **Framework:** Bootstrap 5.3.2
- **JavaScript:** Vanilla JS, funcional
- **UX:** Modales para interacciones rápidas
- **Responsive:** Mobile-first approach

#### PHP
- **Versión:** 8.4.6
- **Estilo:** Orientado a objetos donde sea apropiado
- **Debug:** Mode activado durante desarrollo
- **Errores:** Manejo explícito y mensajes claros

### Flujo de Desarrollo Preferido

#### 1. Análisis Primero
- Mapear estructura actual antes de cambios
- Identificar problemas y dependencias
- Documentar decisiones importantes

#### 2. Cambios Incrementales
- No reescribir todo de una vez
- Mantener funcionalidad existente
- Probar cada cambio antes del siguiente

#### 3. Documentación Continua
- Actualizar `.copilot/` con cada sesión
- Mantener historial de decisiones
- Sincronizar contexto entre sesiones

#### 4. Críticas Constructivas
- **Expectativa:** "Si no es correcto o sugiero algo malo, dímelo"
- **Respuesta esperada:** Alternativas mejores, no solo confirmación
- **Objetivo:** Aprender y mejorar, no solo completar tareas

### Patrones y Antipatrones

#### ✅ Patrones Preferidos
- **Separación de responsabilidades** (MVC, SOLID)
- **Reutilización de código** (DRY principle)
- **Validación robusta** (client + server side)
- **Manejo de errores explícito**
- **Código autoexplicativo** con comentarios donde necesario

#### ❌ Antipatrones a Evitar
- **Lógica mezclada** (HTML + PHP + SQL en mismo archivo)
- **Código duplicado** sin abstracción
- **Dependencias hardcodeadas**
- **Queries SQL directas** sin preparación
- **Magic numbers/strings** sin constantes

### Herramientas y Entorno

#### Servidor de Desarrollo
```bash
# Comando preferido para desarrollo
cd "c:\xampp\htdocs\Mis_Proyectos\Ifts15"
php -S localhost:8000
```

#### IDE/Editor
- **VS Code** con extensiones PHP
- **Error highlighting** activado
- **Debugging** integrado

#### Control de Versiones
- **Git** con commits descriptivos
- **Branch:** main (desarrollo directo)
- **Repo:** LosMuchachosDelInap/Ifts15

### Expectativas de Colaboración

#### Del Asistente AI
1. **Crítico constructivo:** No solo confirmar, sugerir mejoras
2. **Explicativo:** Mostrar por qué una solución es mejor
3. **Incremental:** Cambios paso a paso, no reescrituras masivas
4. **Documentado:** Actualizar contexto y decisiones
5. **Pragmático:** Soluciones que funcionen, no perfectas teóricas

#### Del Proceso
1. **Análisis antes de acción:** Entender antes de cambiar
2. **Testing continuo:** Verificar que todo sigue funcionando
3. **Rollback ready:** Poder volver atrás si algo falla
4. **Clear goals:** Objetivos específicos para cada tarea

### Métricas de Éxito

#### Funcionalidad
- ✅ Todo lo que funcionaba sigue funcionando
- ✅ Nuevas features implementadas correctamente
- ✅ UX mejorada o mantenida

#### Código
- ✅ Más legible y mantenible
- ✅ Menos acoplamiento
- ✅ Mayor reutilización
- ✅ Mejor organización

#### Proceso
- ✅ Documentación actualizada
- ✅ Decisiones explicadas
- ✅ Pasos claros y lógicos
- ✅ Feedback constructivo recibido

## 🎯 Objetivos Actuales

### Inmediatos
1. **MVC Refactoring:** Reorganizar código existente
2. **Models:** Abstraer lógica de datos
3. **Controllers:** Separar lógica de negocio
4. **Views:** Mantener presentación funcionando

### A Largo Plazo
- Sistema educativo completo y escalable
- Código limpio y profesional
- Arquitectura sólida para futuras features
- Base para aprendizaje de mejores prácticas
