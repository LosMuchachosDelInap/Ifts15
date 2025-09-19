# Estructura CSS Modular - IFTS15

## 📁 Organización de Archivos CSS

La estructura CSS del proyecto IFTS15 ha sido reorganizada de manera modular para mejorar el mantenimiento y la escalabilidad.

### 📍 Ubicación de Archivos

```
Ifts15/
├── assets/css/
│   └── custom.css              # ❌ OBSOLETO - No se usa más (modelo anterior)
├── src/Css/
│   ├── styles.css              # ✅ CSS base y variables globales
│   ├── navbarCss.css           # ✅ Estilos específicos del navbar
│   ├── sidebarCss.css          # ✅ Estilos específicos del sidebar
│   └── footerCss.css           # ✅ Estilos específicos del footer
└── layouts/
    ├── header.php              # Incluye solo los nuevos archivos CSS
    ├── navbar.php              # Barra de navegación
    ├── sidebar.php             # Barra lateral
    └── footer.php              # Pie de página
```

## 📋 Descripción de Archivos

### 🎨 `src/Css/styles.css`
**CSS base y variables globales**
- Variables CSS (colores institucionales)
- Reset y estilos base
- Layout principal (body, main-wrapper)
- Cards y componentes generales
- Botones personalizados
- Utilidades y helpers
- Responsive design general
- Animaciones generales

### 🧭 `src/Css/navbarCss.css`
**Estilos del navbar y navegación**
- Navbar principal con gradientes
- Logo y branding
- Links de navegación
- Dropdowns y submenús
- Modales de login/registro
- Alertas del sistema
- Responsive para navbar
- Animaciones específicas del navbar

### 📋 `src/Css/sidebarCss.css`
**Estilos del sidebar (Bootstrap Offcanvas)**
- Offcanvas principal
- Header del sidebar
- Información del usuario
- Navegación del sidebar
- Submenús colapsables
- Sección de administración
- Footer del sidebar
- Efectos y animaciones
- Responsive para sidebar

### 🦶 `src/Css/footerCss.css`
**Estilos del footer**
- Footer principal con gradientes
- Estructura y layout
- Títulos y encabezados
- Enlaces y listas
- Información de contacto
- Copyright e información legal
- Redes sociales (preparado)
- Debug info
- Responsive para footer
- Efectos especiales

## 🔧 Orden de Carga

Los archivos CSS se cargan en el siguiente orden desde `layouts/header.php`:

1. **Bootstrap CSS** (CDN)
2. **Font Awesome** (CDN)
3. **styles.css** (base y variables)
4. **navbarCss.css**
5. **sidebarCss.css**
6. **footerCss.css**

> ⚠️ **Nota:** El archivo `assets/css/custom.css` ha sido **descontinuado** y reemplazado por la estructura modular.

## 🎯 Variables CSS Globales

Definidas en `styles.css`:
```css
:root {
    --primary-color: #ffd700;    /* Amarillo institucional */
    --primary-dark: #e6c200;     /* Amarillo oscuro */
    --secondary-color: #6c757d;  /* Gris Bootstrap */
    --text-on-primary: #212529;  /* Texto sobre amarillo */
    --text-on-secondary: #ffffff; /* Texto sobre gris */
    --navbar-height: 56px;
    --content-padding: 20px;
}
```

## 📱 Responsive Design

Cada archivo incluye sus propios breakpoints:
- **Desktop:** > 768px
- **Tablet:** 576px - 768px
- **Mobile:** < 576px

## 🚀 Ventajas de la Nueva Estructura

### ✅ **Mantenibilidad**
- Cada componente tiene su propio archivo
- Fácil localización de estilos específicos
- Menos conflictos entre desarrolladores

### ✅ **Escalabilidad**
- Fácil agregar nuevos componentes
- Estructura preparada para crecimiento
- Separación clara de responsabilidades

### ✅ **Performance**
- Carga modular (se pueden cargar componentes específicos)
- Mejor compresión por archivo
- Cache más eficiente

### ✅ **Organización**
- Estructura lógica y predecible
- Comentarios detallados en cada archivo
- Documentación integrada

## 🔄 Migración Completada

### ✅ **Archivos Actualizados**
- `layouts/header.php` - Referencias CSS actualizadas (removido custom.css)
- `src/Css/styles.css` - Estilos base consolidados con variables globales
- Nuevos archivos CSS específicos creados y funcionando

### ✅ **Migración Completa**
- ❌ `assets/css/custom.css` **descontinuado** (modelo anterior)
- ✅ Nueva estructura modular implementada
- ✅ Todos los estilos migrados correctamente
- ✅ Funcionalidad 100% mantenida con mejor organización

### ✅ **Mejoras Técnicas**
- Compatibilidad Safari agregada (-webkit-backdrop-filter)
- Variables CSS optimizadas
- Animaciones mejoradas
- Responsive design refinado

## 📖 Guía de Uso

### Para modificar estilos del **navbar**:
```
Editar: src/Css/navbarCss.css
```

### Para modificar estilos del **sidebar**:
```
Editar: src/Css/sidebarCss.css
```

### Para modificar estilos del **footer**:
```
Editar: src/Css/footerCss.css
```

### Para modificar estilos **generales**:
```
Editar: src/Css/styles.css
```

## 🎨 Colores Institucionales

- **Primario:** `#ffd700` (Amarillo IFTS15)
- **Secundario:** `#6c757d` (Gris Bootstrap)
- **Texto sobre primario:** `#212529` (Oscuro)
- **Texto sobre secundario:** `#ffffff` (Blanco)

---

*Estructura implementada para IFTS15 Sistema Web - Septiembre 2025*