# Documentación Frontend - Alas Chiquitanas

## 📋 Descripción

Frontend completo para la landing page de Alas Chiquitanas desarrollado con **Blade Templates (Laravel)** y **Tailwind CSS**, siguiendo el esquema de diseño proporcionado pero adaptado completamente a PHP/Laravel sin React.

## 🎨 Arquitectura

```
resources/views/
├── frontend/
│   ├── layouts/
│   │   └── app.blade.php          # Layout principal
│   ├── home/
│   │   └── index.blade.php         # Landing page
│   ├── products/
│   │   ├── index.blade.php         # Lista de productos
│   │   └── show.blade.php          # Detalle de producto
│   ├── foundations/
│   │   ├── index.blade.php         # Lista de fundaciones
│   │   └── show.blade.php          # Detalle de fundación
│   └── suppliers/
│       ├── index.blade.php         # Lista de proveedores
│       └── show.blade.php          # Detalle de proveedor
└── components/
    └── frontend/
        ├── header.blade.php        # Header/Navbar
        ├── footer.blade.php        # Footer
        ├── button.blade.php        # Componente Button
        └── card.blade.php          # Componente Card
```

## 🎨 Paleta de Colores

### Colores Principales
- **Naranja Principal**: `#ea580c` → `#f97316` (orange-600 a orange-700)
- **Ámbar**: `#f59e0b` → `#fbbf24` (amber-500 a amber-600)
- **Gris Oscuro**: `#111827` → `#1f2937` (gray-900 a gray-800)
- **Gris Claro**: `#f9fafb` → `#ffffff` (gray-50 a white)

### Gradientes
```css
/* Fondo principal */
background: linear-gradient(to bottom right, #f9fafb, #ffffff, #f9fafb)

/* Botones principales */
background: linear-gradient(to right, #ea580c, #f59e0b)
hover: linear-gradient(to right, #c2410c, #d97706)

/* Texto con gradiente */
background: linear-gradient(to right, #111827, #374151, #111827)
-webkit-background-clip: text
color: transparent
```

## 🧩 Componentes

### Layout Principal
**Archivo**: `resources/views/frontend/layouts/app.blade.php`

Layout base que incluye:
- Header sticky con navegación
- Contenido principal (slot)
- Footer
- Scripts y estilos

**Uso**:
```blade
<x-frontend.layouts.app pageTitle="Mi Página">
    <!-- Contenido -->
</x-frontend.layouts.app>
```

### Header
**Archivo**: `resources/views/components/frontend/header.blade.php`

Header sticky con:
- Logo y nombre de la marca
- Navegación principal
- Carrito de compras (si está autenticado)
- Menú de usuario o botones de login/registro

### Footer
**Archivo**: `resources/views/components/frontend/footer.blade.php`

Footer con:
- Información de la empresa
- Enlaces de navegación
- Enlaces de soporte
- Redes sociales

### Button Component
**Archivo**: `resources/views/components/frontend/button.blade.php`

Componente de botón con variantes:
- `default`: Gradiente naranja/ámbar
- `outline`: Borde naranja, fondo transparente
- `secondary`: Gris
- `ghost`: Sin fondo
- `destructive`: Rojo

**Uso**:
```blade
<x-frontend.button variant="default" size="lg" href="{{ route('products.index') }}">
    Ver Productos
</x-frontend.button>
```

### Card Component
**Archivo**: `resources/views/components/frontend/card.blade.php`

Tarjeta con:
- Hover effect (elevación)
- Slots para header, content y footer
- Sombras y transiciones

**Uso**:
```blade
<x-frontend.card>
    <x-slot:header>
        <h3>Título</h3>
    </x-slot:header>
    
    Contenido de la tarjeta
    
    <x-slot:footer>
        <button>Acción</button>
    </x-slot:footer>
</x-frontend.card>
```

## 📄 Páginas

### Home (Landing Page)
**Ruta**: `/`  
**Controlador**: `App\Http\Controllers\Frontend\HomeController`  
**Vista**: `resources/views/frontend/home/index.blade.php`

Incluye:
- Hero section con gradientes y efectos
- Sección de características
- Call-to-action

### Productos
**Ruta**: `/productos`  
**Controlador**: `App\Http\Controllers\Frontend\ProductController`  
**Vista**: `resources/views/frontend/products/index.blade.php`

Características:
- Grid de productos
- Filtros por categoría y proveedor
- Búsqueda
- Paginación

### Fundaciones
**Ruta**: `/fundaciones`  
**Controlador**: `App\Http\Controllers\Frontend\FoundationController`  
**Vista**: `resources/views/frontend/foundations/index.blade.php`

Muestra fundaciones verificadas y activas.

### Proveedores
**Ruta**: `/proveedores`  
**Controlador**: `App\Http\Controllers\Frontend\SupplierController`  
**Vista**: `resources/views/frontend/suppliers/index.blade.php`

Muestra proveedores activos con sus productos.

## 🛣️ Rutas

Todas las rutas del frontend están definidas en `routes/web.php`:

```php
// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{producto}', [ProductController::class, 'show'])->name('products.show');
Route::get('/fundaciones', [FoundationController::class, 'index'])->name('foundations.index');
Route::get('/fundaciones/{fundacion}', [FoundationController::class, 'show'])->name('foundations.show');
Route::get('/proveedores', [SupplierController::class, 'index'])->name('suppliers.index');
Route::get('/proveedores/{proveedor}', [SupplierController::class, 'show'])->name('suppliers.show');
```

## 🎯 Patrones de Diseño

### Hero Section
- Fondo con gradiente sutil
- Efectos de blur animados (partículas de fondo)
- Grid de 2 columnas en desktop
- Badge superior + Título grande + Descripción + Botones CTA

### Cards
- `shadow-lg hover:shadow-2xl`
- `hover:-translate-y-2` (elevación al hover)
- `transition-all duration-500`
- Bordes redondeados: `rounded-lg` o `rounded-2xl`

### Espaciado
- Secciones: `py-20 md:py-32`
- Container: `px-6 md:px-8 mx-auto max-w-7xl`
- Gaps: `gap-4`, `gap-8`, `gap-12`

## 📐 Layout Patterns

### Container
```blade
<div class="container px-6 md:px-8 mx-auto max-w-7xl">
```

### Grid Responsive
```blade
<!-- 1 columna mobile, 2 tablet, 3 desktop -->
<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
```

### Flex Layout
```blade
<div class="flex flex-col sm:flex-row gap-4">
```

## 🔧 Tecnologías

- **Laravel 12** (Framework PHP)
- **Blade Templates** (Motor de plantillas)
- **Tailwind CSS 4.1.1** (Framework CSS)
- **Vite** (Build tool)
- **Font Awesome** (Iconos - opcional)

## 🚀 Instalación y Configuración

### 1. Asegurar que Tailwind CSS esté configurado

El proyecto ya tiene Tailwind configurado. Verificar `resources/css/app.css` y `vite.config.js`.

### 2. Compilar assets

```bash
npm install
npm run dev
# o para producción
npm run build
```

### 3. Verificar rutas

Las rutas del frontend ya están definidas en `routes/web.php`.

## 📝 Estilos Reutilizables

### Header Sticky
```blade
className="border-b bg-white/80 backdrop-blur-sm sticky top-0 z-50"
```

### Botón CTA Principal
```blade
className="bg-gradient-to-r from-orange-600 to-amber-600 
           hover:from-orange-700 hover:to-amber-700 
           text-white shadow-lg hover:shadow-xl 
           transition-all duration-300"
```

### Card con Hover
```blade
className="group overflow-hidden border-0 shadow-lg 
           hover:shadow-2xl transition-all duration-500 
           transform hover:-translate-y-2 bg-white"
```

### Fondo con Partículas Animadas
```blade
<div class="absolute inset-0 bg-gradient-to-br from-gray-50/50 via-transparent to-gray-100/30" />
<div class="absolute top-20 right-20 w-72 h-72 bg-gray-200 rounded-full 
            mix-blend-multiply filter blur-xl opacity-10 animate-pulse" />
```

## 🎨 Tipografía

- **Títulos Grandes**: `text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold`
- **Títulos Medianos**: `text-2xl font-bold`
- **Descripciones**: `text-xl text-gray-600 leading-relaxed`
- **Texto Pequeño**: `text-sm text-gray-500`

## 📱 Breakpoints (Tailwind)

- `sm:` 640px
- `md:` 768px
- `lg:` 1024px
- `xl:` 1280px

## 🔄 Integración con Backend

El frontend está completamente integrado con el backend Laravel:

- **Modelos**: Usa los modelos de dominio (`App\Domain\Lta\Models`)
- **Controladores**: Controladores en `App\Http\Controllers\Frontend`
- **Rutas**: Rutas públicas en `routes/web.php`
- **Autenticación**: Integrado con el sistema de autenticación de Laravel

## 📦 Próximos Pasos

1. **Carrito de Compras**: Implementar funcionalidad de carrito
2. **Checkout**: Página de checkout y pago
3. **Órdenes**: Vista de órdenes del usuario
4. **Perfil de Usuario**: Edición de perfil
5. **Búsqueda Avanzada**: Mejorar filtros y búsqueda
6. **Detalles de Productos**: Página de detalle completa
7. **Detalles de Fundaciones**: Página de detalle completa
8. **Detalles de Proveedores**: Página de detalle completa

## 🐛 Solución de Problemas

### Los estilos no se aplican
- Ejecutar `npm run dev` o `npm run build`
- Verificar que Vite esté corriendo
- Limpiar caché: `php artisan view:clear`

### Las rutas no funcionan
- Verificar que las rutas estén en `routes/web.php`
- Ejecutar `php artisan route:clear`
- Verificar que los controladores existan

### Los componentes no se renderizan
- Verificar que los componentes estén en `resources/views/components/frontend/`
- Verificar la sintaxis de Blade
- Revisar los logs en `storage/logs/laravel.log`

