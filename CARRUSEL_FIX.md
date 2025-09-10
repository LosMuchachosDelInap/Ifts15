# SOLUCIÓN ESPECÍFICA PARA CARRUSEL EN INFINITYFREE
# Archivo: CARRUSEL_FIX.md

## 🎠 PROBLEMA COMÚN: CARRUSEL NO FUNCIONA

### CAUSAS MÁS FRECUENTES:

#### 1. **Bootstrap no carga correctamente**
**Síntomas**: Carrusel estático, sin animación
**Solución**: Verificar que los CDN funcionen
```html
<!-- En layouts/header.php, verificar estas líneas: -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
```

#### 2. **Imágenes no cargan**
**Síntomas**: Carrusel en blanco o con placeholders
**Solución**: 
- Verificar que las imágenes estén en `assets/images/`
- Verificar permisos de archivos (644 para imágenes, 755 para carpetas)
- Comprobar rutas en index.php

#### 3. **JavaScript bloqueado**
**Síntomas**: Carrusel estático, funciones no responden
**Solución**: Verificar en F12 (Consola) si hay errores de JavaScript

#### 4. **ID duplicados**
**Síntomas**: Solo funciona parcialmente
**Solución**: Verificar que `id="heroCarousel"` sea único

### 🔧 VERIFICACIONES PASO A PASO:

#### Paso 1: Verificar HTML del carrusel
El carrusel debe tener esta estructura en `index.php`:
```html
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <!-- Primera imagen -->
        </div>
        <div class="carousel-item">
            <!-- Segunda imagen -->
        </div>
        <!-- etc... -->
    </div>
    <!-- Controles -->
</div>
```

#### Paso 2: Verificar CSS de imágenes
En `assets/css/custom.css`:
```css
.carousel-image {
    height: 400px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
}
```

#### Paso 3: Verificar rutas de imágenes
Las rutas deben usar `SITE_URL`:
```php
url('<?php echo SITE_URL; ?>/assets/images/carrussel_1.png')
```

#### Paso 4: Verificar en navegador
1. Abre F12 → Consola
2. Busca errores rojos
3. Ve a Network → verifica que las imágenes carguen (200 OK)

### 🚨 SOLUCIÓN INMEDIATA:

Si el carrusel no funciona en InfinityFree, prueba esto:

#### Opción A: Imágenes como `<img>` en lugar de background
Reemplaza en `index.php`:
```html
<!-- En lugar de background-image, usa: -->
<div class="carousel-item active">
    <img src="<?php echo SITE_URL; ?>/assets/images/carrussel_1.png" 
         class="d-block w-100" 
         alt="Slide 1"
         style="height: 400px; object-fit: cover;">
    <div class="carousel-caption d-none d-md-block">
        <h2>Título</h2>
        <p>Descripción</p>
    </div>
</div>
```

#### Opción B: Inicialización manual de Bootstrap
Agrega al final de `layouts/footer.php`:
```javascript
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar carrusel manualmente
    var carousel = new bootstrap.Carousel(document.getElementById('heroCarousel'), {
        interval: 5000,
        wrap: true
    });
});
</script>
```

#### Opción C: Verificar permisos de archivos
En InfinityFree File Manager:
- Archivos PHP: 644
- Imágenes: 644
- Carpetas: 755

### 📱 TEST RÁPIDO:

1. Sube el archivo `verify-system.php` a tu host
2. Visita: `tudominio.com/verify-system.php`
3. Revisa que todas las verificaciones salgan en verde
4. Si hay errores rojos, sigue las instrucciones del reporte

### 🆘 SI NADA FUNCIONA:

#### Carrusel simple sin Bootstrap:
```html
<div class="simple-carousel">
    <img src="<?php echo SITE_URL; ?>/assets/images/carrussel_1.png" 
         alt="IFTS15" 
         class="img-fluid w-100"
         style="height: 400px; object-fit: cover;">
</div>
```

#### CSS alternativo:
```css
.simple-carousel img {
    max-height: 400px;
    width: 100%;
    object-fit: cover;
}
```

---
**Nota**: Si sigues teniendo problemas, es probable que sea una limitación específica de InfinityFree o un problema de configuración del servidor. En ese caso, contacta el soporte técnico de InfinityFree.
