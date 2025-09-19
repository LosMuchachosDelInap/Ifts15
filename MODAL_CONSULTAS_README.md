# Modal de Consultas - IFTS15

## 📋 **Componente Implementado**

Se ha creado un **Modal de Consultas** completamente funcional que permite a los usuarios enviar consultas desde cualquier página del sitio web sin necesidad de redireccionar.

### 📁 **Archivos Creados**

```
src/
├── Components/
│   └── modalConsultas.php         # ✅ Componente del modal
└── Css/
    └── consultasCss.css           # ✅ Estilos específicos
```

### 📝 **Archivos Modificados**

```
layouts/
├── header.php                    # ✅ Agregado CSS del modal
├── navbar.php                    # ✅ Botón "Consultas" agregado
├── sidebar.php                   # ✅ Enlace en menú "Comunicación"
└── footer.php                    # ✅ Enlace + inclusión del modal
```

---

## 🎯 **Características del Modal**

### ✅ **Formulario Completo**
- **Campos obligatorios:** Nombre, Email, Consulta
- **Campos opcionales:** Teléfono, Carrera de interés
- **Validación JavaScript:** Tiempo real y en envío
- **Feedback visual:** Alertas de éxito y error
- **Loading state:** Botón con spinner durante envío

### ✅ **Información de Contacto**
- **Dirección:** Av. Corrientes 1234, CABA
- **Teléfonos:** Secretaría, Admisiones, WhatsApp
- **Emails:** General, Admisiones, Académico
- **Horarios:** Lunes a Viernes, Sábados
- **Enlaces:** Redes sociales y FAQ

### ✅ **Diseño Responsive**
- **Desktop:** Layout de 2 columnas (formulario + info)
- **Tablet/Mobile:** Layout apilado optimizado
- **Modal XL:** Espacio amplio para contenido
- **Scroll interno:** Modal con scroll si es necesario

### ✅ **UX/UI Optimizada**
- **Animaciones suaves:** Entrada del modal, efectos hover
- **Colores institucionales:** Amarillo/gris de IFTS15
- **Iconografía consistente:** Font Awesome
- **Accesibilidad:** Focus visible, navegación por teclado

---

## 🔗 **Puntos de Acceso**

El modal de consultas está disponible desde:

### 1. **Navbar (Usuarios no logueados)**
```html
Inicio > Carreras > Nosotros > Contacto > Consultas
```

### 2. **Sidebar (Usuarios logueados)**
```html
Comunicación > Consultas
```

### 3. **Footer (Todos los usuarios)**
```html
Enlaces Útiles > Consultas
```

### 4. **Desde cualquier página** con JavaScript:
```javascript
// Mostrar modal programáticamente
const consultasModal = new bootstrap.Modal(document.getElementById('consultasModal'));
consultasModal.show();
```

---

## 🎨 **Estilos CSS - consultasCss.css**

### **Estructura principal:**
- Modal con diseño XL y centrado
- Gradientes institucionales (amarillo/gris)
- Efectos de blur y sombras avanzadas
- Animaciones de entrada y interacción

### **Responsive breakpoints:**
- **> 768px:** Layout completo 2 columnas
- **576px - 768px:** Ajustes para tablet
- **< 576px:** Optimización móvil completa

### **Componentes estilizados:**
- Formulario con efectos de focus
- Botones con gradientes y hover effects
- Alertas con animaciones
- Cards de información con glass-morphism
- Botones sociales con grid responsive

---

## 🔧 **Funcionalidad JavaScript**

### **Validaciones implementadas:**
```javascript
✅ Campos obligatorios no vacíos
✅ Email con formato válido (@)
✅ Longitud mínima de caracteres
✅ Sanitización básica de datos
```

### **Estados del formulario:**
```javascript
✅ Estado normal: Listo para envío
✅ Estado loading: Spinner + botón deshabilitado
✅ Estado éxito: Mensaje + auto-cierre (2s)
✅ Estado error: Mensaje de error visible
✅ Reset: Limpieza al cerrar modal
```

### **Integraciones:**
```javascript
✅ Bootstrap 5 Modal API
✅ Fetch API para envío AJAX (simulado)
✅ Event listeners para interacciones
✅ Auto-hide de alertas (5s)
```

---

## 📊 **Datos del Formulario**

### **Campos capturados:**
```php
$nombre     // string, obligatorio
$email      // email, obligatorio  
$telefono   // string, opcional
$carrera    // select, opcional
$consulta   // textarea, obligatorio
```

### **Opciones de carrera:**
- Realizador y Productor Televisivo
- Análisis de Sistemas
- Ciencia de Datos e IA
- Administración Pública
- Otro / Información general

### **Procesamiento:**
```php
// En modalConsultas.php línea 8-25
if (isset($_POST['action']) && $_POST['action'] === 'enviar_consulta_modal') {
    // Sanitización de datos
    // Validación server-side
    // Respuesta JSON
    // Posible integración con email/BD
}
```

---

## 🚀 **Beneficios Implementados**

### ✅ **Usuario (UX):**
- **Acceso rápido:** Sin cambiar de página
- **Información completa:** Todo en un lugar
- **Responsive:** Funciona en todos los dispositivos
- **Feedback inmediato:** Confirmación visual

### ✅ **Desarrollador (DX):**
- **Modular:** Componente reutilizable
- **Escalable:** Fácil modificar y extender
- **Mantenible:** CSS y JS organizados
- **Documentado:** Código comentado

### ✅ **Institución (Business):**
- **Más consultas:** Menor fricción = más leads
- **Mejor experiencia:** Usuarios satisfechos
- **Profesional:** Imagen moderna y cuidada
- **Eficiente:** Proceso optimizado de contacto

---

## 🔄 **Posibles Extensiones Futuras**

```javascript
✅ Integración con sistema de emails (PHPMailer)
✅ Guardado en base de datos
✅ Sistema de tickets/seguimiento
✅ Notificaciones push
✅ Integración con CRM
✅ Analytics de consultas
✅ Chat en vivo integrado
✅ Respuestas automáticas
```

---

*Componente implementado para IFTS15 Sistema Web - Septiembre 2025*