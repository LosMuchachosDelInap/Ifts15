# CONFIGURACIÓN PARA DEMO VISUAL (SIN BASE DE DATOS)
# Archivo: DEMO_MODE.md

## 🎭 MODO DEMO ACTIVADO

El proyecto está configurado en **MODO DEMO** para mostrar solo el maquetado visual sin funcionalidades de base de datos.

### ✅ FUNCIONALIDADES ACTIVAS:
- **Carrusel de imágenes** funcionando
- **Navegación responsive** 
- **Hero card con logo**
- **Dropdowns del navbar** (solo visual)
- **Estilos y animaciones**
- **Footer completo**

### ❌ FUNCIONALIDADES DESACTIVADAS:
- **Login/registro** (formularios no procesan)
- **Base de datos** (conexión deshabilitada)
- **Autenticación de usuarios**
- **Roles y permisos**
- **Dashboard de usuario**

### 🖼️ IMÁGENES UTILIZADAS:
```
assets/images/
├── carrussel_1.png ✅ (1164x257, 394KB)
├── carrussel_2.png ✅ (868x236, 40KB)
├── carrussel_3.png ✅ (1169x258, 280KB)
└── logo.png ✅ (183x137, 27KB)
```

### 🔧 PARA ACTIVAR BASE DE DATOS:
1. Configura MySQL en tu hosting
2. Importa `database/ifts15_schema.sql`
3. Actualiza credenciales en `config/config.php`
4. Cambia en `includes/init.php`:
   ```php
   define('DISABLE_DATABASE', false); // ← Cambiar a false
   ```

### 🌐 ARCHIVOS IMPORTANTES PARA HOSTING:
```
📁 SUBIR A INFINITYFREE:
✅ index.php (página principal)
✅ assets/ (CSS, JS, imágenes)
✅ layouts/ (header, navbar, footer)
✅ config/ (configuración)
✅ includes/ (funciones)
✅ .htaccess (configuración servidor)

❌ NO SUBIR:
❌ database/ (hasta configurar BD)
❌ login.php, register.php (hasta activar BD)
❌ verify-system.php, optimize-images.php (solo para desarrollo)
```

### 🎯 URLS DE TESTING:
- **Sitio principal**: `tudominio.com/index.php`
- **Verificar sistema**: `tudominio.com/verify-system.php`
- **Test de imágenes**: `tudominio.com/optimize-images.php`

---
**Estado actual**: ✅ Listo para demo visual
**Base de datos**: ❌ Deshabilitada (modo demo)
**Fecha**: 10 de septiembre de 2025
