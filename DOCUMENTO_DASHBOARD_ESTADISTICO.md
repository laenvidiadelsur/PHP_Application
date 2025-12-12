# Documento Técnico: Dashboard Estadístico - Sistema Admin LTA

## Información del Proyecto

**Nombre del Sistema:** Admin LTA - Plataforma de Gestión para Fundaciones  
**Plataforma:** Laravel (PHP 8.4)  
**Base de Datos:** PostgreSQL  
**Fecha de Desarrollo:** 2025  
**Desarrollador:** [Nombre del Estudiante]

---

## 1. Descripción General del Sistema de Dashboards

El Sistema Admin LTA cuenta con **tres dashboards especializados** diseñados para diferentes roles de usuario, cada uno con métricas y visualizaciones específicas según las necesidades operativas de cada perfil.

### 1.1 Arquitectura de Dashboards

El sistema implementa una arquitectura multi-dashboard que permite:

- **Personalización por Rol:** Cada usuario ve solo las métricas relevantes para su función
- **Seguridad de Datos:** Los datos se filtran automáticamente según la entidad del usuario
- **Análisis Especializado:** Cada dashboard está optimizado para las necesidades específicas del rol

### 1.2 Dashboards Implementados

1. **Dashboard Administrativo:** Visión global del sistema completo
2. **Dashboard de Fundación:** Métricas específicas para gestores de fundaciones
3. **Dashboard de Proveedor:** Estadísticas para proveedores de productos
4. **Dashboard de Comprador:** Panel personalizado para usuarios compradores

---

## 2. DASHBOARD ADMINISTRATIVO

### 2.1 Propósito

El Dashboard Administrativo proporciona una visión completa y en tiempo real del estado general del sistema Admin LTA. Está diseñado para administradores que necesitan supervisar todas las operaciones, entidades y métricas del e-commerce de fundaciones.

### 2.2 Objetivos Específicos

1. **Monitoreo Global:** Visualizar el estado de todas las fundaciones, proveedores y productos
2. **Análisis de Tendencias:** Identificar patrones en ventas, usuarios y operaciones a nivel sistema
3. **Control Operativo:** Supervisar el funcionamiento general del e-commerce
4. **Toma de Decisiones Estratégicas:** Proporcionar datos procesados para decisiones de alto nivel
5. **Identificación de Problemas:** Detectar anomalías o áreas que requieren atención

### 2.3 Usuarios Objetivo

- **Administradores del Sistema:** Personal con acceso completo a todas las funcionalidades
- **Supervisores:** Usuarios que necesitan visión general para supervisión

---

## 3. DASHBOARD DE FUNDACIÓN

### 3.1 Propósito

El Dashboard de Fundación está diseñado específicamente para los gestores de fundaciones que necesitan monitorear y analizar las operaciones relacionadas con su entidad. Proporciona métricas específicas sobre proveedores asociados, productos disponibles, órdenes recibidas e ingresos generados.

### 3.2 Objetivos Específicos

1. **Gestión de Proveedores:** Monitorear proveedores asociados a la fundación
2. **Análisis de Productos:** Visualizar productos disponibles a través de proveedores
3. **Seguimiento de Órdenes:** Monitorear el estado y tendencias de órdenes recibidas
4. **Análisis de Ingresos:** Evaluar el rendimiento financiero de la fundación
5. **Optimización de Operaciones:** Identificar proveedores y productos más exitosos

### 3.3 Usuarios Objetivo

- **Gestores de Fundaciones:** Personal administrativo de fundaciones registradas
- **Coordinadores:** Usuarios que gestionan proveedores y productos para su fundación

### 3.4 Métricas Implementadas

#### Métrica 1: Resumen de la Fundación (KPIs Principales)
**Tipo:** Tarjetas de Indicadores

**Visualizaciones:**
- Total de Proveedores Asociados
- Total de Productos Disponibles
- Estado de la Fundación (Activa/Inactiva)
- Ingresos Totales
- Total de Órdenes
- Órdenes Pendientes

**Propósito:**
Proporcionar una visión rápida del estado operativo de la fundación, permitiendo identificar:
- El volumen de proveedores gestionados
- La cantidad de productos disponibles para compra
- El estado operativo de la fundación
- La salud financiera y operativa

**Fuente de Datos:**
```sql
-- Total de Proveedores de la Fundación
SELECT COUNT(*) as total 
FROM test.suppliers 
WHERE fundacion_id = :fundacion_id;

-- Total de Productos Disponibles
SELECT COUNT(*) as total 
FROM test.products p
INNER JOIN test.suppliers s ON p.supplier_id = s.id
WHERE s.fundacion_id = :fundacion_id;

-- Ingresos Totales (órdenes completadas)
SELECT COALESCE(SUM(total_amount), 0) as ingresos_totales 
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
WHERE c.foundation_id = :fundacion_id 
AND o.estado = 'completado';

-- Órdenes Pendientes
SELECT COUNT(*) as pendientes 
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
WHERE c.foundation_id = :fundacion_id 
AND o.estado = 'pendiente';
```

**Código Laravel:**
```php
// En Fundacion/DashboardController.php
$proveedoresCount = Proveedor::where('fundacion_id', $fundacion->id)->count();
$productosCount = Producto::whereHas('supplier', function ($query) use ($fundacion) {
    $query->where('fundacion_id', $fundacion->id);
})->count();
$totalRevenue = Orden::whereHas('cart', function ($query) use ($fundacion) {
    $query->where('foundation_id', $fundacion->id);
})->where('estado', 'completado')->sum('total_amount') ?? 0;
$pendingOrders = Orden::whereHas('cart', function ($query) use ($fundacion) {
    $query->where('foundation_id', $fundacion->id);
})->where('estado', 'pendiente')->count();
```

**Espacio para Captura de Pantalla FD-1:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Fundación - Tarjetas de KPIs principales]
```

#### Métrica 2: Top 5 Proveedores por Órdenes
**Tipo:** Gráfico de Barras Horizontales

**Visualización:**
Gráfico que muestra los 5 proveedores asociados a la fundación con mayor número de órdenes completadas, incluyendo:
- Nombre del proveedor
- Número de órdenes recibidas
- Ranking de rendimiento

**Propósito:**
- Identificar proveedores más activos y exitosos
- Reconocer relaciones comerciales estratégicas
- Planificar estrategias de colaboración con proveedores clave
- Evaluar el rendimiento de proveedores asociados

**Fuente de Datos:**
```sql
-- Top 5 Proveedores por Órdenes
SELECT 
    s.id,
    s.name as supplier_name,
    COUNT(DISTINCT o.id) as orders_count
FROM test.suppliers s
INNER JOIN test.products p ON s.id = p.supplier_id
INNER JOIN test.cart_items ci ON p.id = ci.product_id
INNER JOIN test.carts c ON ci.cart_id = c.id
INNER JOIN test.orders o ON c.id = o.cart_id
WHERE s.fundacion_id = :fundacion_id
AND o.estado = 'completado'
GROUP BY s.id, s.name
ORDER BY orders_count DESC
LIMIT 5;
```

**Código Laravel:**
```php
// En Fundacion/DashboardController.php
$topProveedores = Proveedor::where('fundacion_id', $fundacion->id)
    ->select('test.suppliers.*')
    ->selectSub(function ($query) {
        $query->from('test.products')
            ->join('test.cart_items', 'test.products.id', '=', 'test.cart_items.product_id')
            ->join('test.carts', 'test.cart_items.cart_id', '=', 'test.carts.id')
            ->join('test.orders', 'test.carts.id', '=', 'test.orders.cart_id')
            ->whereColumn('test.products.supplier_id', 'test.suppliers.id')
            ->selectRaw('COUNT(DISTINCT test.orders.id)');
    }, 'orders_count')
    ->orderByDesc('orders_count')
    ->limit(5)
    ->get();
```

**Espacio para Captura de Pantalla FD-2:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Fundación - Top 5 Proveedores por Órdenes]
```

#### Métrica 3: Tendencias de Órdenes Mensuales
**Tipo:** Gráfico de Líneas

**Visualización:**
Gráfico que muestra la evolución mensual de órdenes recibidas por la fundación, incluyendo:
- Número de órdenes por mes
- Ingresos mensuales
- Tendencias de crecimiento

**Propósito:**
- Analizar el crecimiento de operaciones a lo largo del tiempo
- Identificar períodos de alta y baja actividad
- Planificar recursos según demanda histórica
- Detectar anomalías o cambios significativos

**Fuente de Datos:**
```sql
-- Tendencias de Órdenes Mensuales
SELECT 
    EXTRACT(YEAR FROM o.created_at) as year,
    EXTRACT(MONTH FROM o.created_at) as month,
    COUNT(*) as count,
    SUM(o.total_amount) as revenue
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
WHERE c.foundation_id = :fundacion_id
AND o.created_at BETWEEN :date_from AND :date_to
AND o.estado = :status -- Opcional
GROUP BY year, month
ORDER BY year, month;
```

**Código Laravel:**
```php
// En Fundacion/DashboardController.php
$monthlyOrders = Orden::whereHas('cart', function ($query) use ($fundacion) {
    $query->where('foundation_id', $fundacion->id);
})
->selectRaw('EXTRACT(YEAR FROM created_at) as year, EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count, SUM(total_amount) as revenue')
->whereBetween('created_at', [$dateFrom, $dateTo])
->when($statusFilter, function ($query) use ($statusFilter) {
    return $query->where('estado', $statusFilter);
})
->groupBy('year', 'month')
->orderBy('year')
->orderBy('month')
->get();
```

**Espacio para Captura de Pantalla FD-3:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Fundación - Tendencias de Órdenes Mensuales]
```

#### Métrica 4: Distribución de Productos por Categoría
**Tipo:** Gráfico Circular (Pie Chart)

**Visualización:**
Gráfico que muestra la distribución de productos disponibles según su categoría:
- Materiales
- Equipos
- Alimentos
- Gaseosas
- Otros

**Propósito:**
- Entender la composición del catálogo disponible
- Identificar categorías con mayor o menor representación
- Planificar estrategias de diversificación
- Analizar la demanda por tipo de producto

**Fuente de Datos:**
```sql
-- Distribución de Productos por Categoría
SELECT 
    c.name as categoria,
    COUNT(p.id) as total_productos,
    ROUND(COUNT(p.id) * 100.0 / SUM(COUNT(p.id)) OVER (), 2) as percentage
FROM test.products p
INNER JOIN test.suppliers s ON p.supplier_id = s.id
INNER JOIN test.categories c ON p.category_id = c.id
WHERE s.fundacion_id = :fundacion_id
GROUP BY c.id, c.name
ORDER BY total_productos DESC;
```

**Código Laravel:**
```php
// En Fundacion/DashboardController.php
$productosPorCategoria = Producto::whereHas('supplier', function ($query) use ($fundacion) {
    $query->where('fundacion_id', $fundacion->id);
})
->with('category')
->selectRaw('category_id, COUNT(*) as total')
->groupBy('category_id')
->get()
->map(function ($item) {
    return [
        'categoria' => $item->category?->name ?? 'Sin categoría',
        'total' => $item->total,
    ];
});
```

**Espacio para Captura de Pantalla FD-4:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Fundación - Distribución de Productos por Categoría]
```

#### Métrica 5: Distribución de Órdenes por Estado
**Tipo:** Gráfico de Barras o Gráfico Circular

**Visualización:**
Gráfico que muestra la distribución porcentual y absoluta de las órdenes según su estado:
- Pendientes
- Completadas
- Canceladas
- En Proceso

**Propósito:**
- Visualizar el estado general del flujo de órdenes
- Identificar cuellos de botella en el proceso
- Monitorear la eficiencia operativa
- Detectar problemas en el procesamiento de pedidos

**Fuente de Datos:**
```sql
-- Distribución de Órdenes por Estado
SELECT 
    o.estado as status,
    COUNT(*) as count,
    ROUND(COUNT(*) * 100.0 / SUM(COUNT(*)) OVER (), 2) as percentage
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
WHERE c.foundation_id = :fundacion_id
GROUP BY o.estado
ORDER BY count DESC;
```

**Código Laravel:**
```php
// En Fundacion/DashboardController.php
$ordenesPorEstado = Orden::whereHas('cart', function ($query) use ($fundacion) {
    $query->where('foundation_id', $fundacion->id);
})
->selectRaw('estado as status, COUNT(*) as count')
->groupBy('estado')
->get();
```

**Espacio para Captura de Pantalla FD-5:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Fundación - Distribución de Órdenes por Estado]
```

### 3.5 Filtros Disponibles

- **Rango de Fechas:** Fecha desde y fecha hasta
- **Filtro por Proveedor:** Selección de proveedor específico
- **Filtro por Estado:** Pendiente, Completada, Cancelada, etc.

---

## 4. DASHBOARD DE PROVEEDOR

### 4.1 Propósito

El Dashboard de Proveedor está diseñado para proveedores que necesitan monitorear el rendimiento de sus productos, ventas, inventario y relaciones comerciales con fundaciones. Proporciona métricas específicas sobre productos gestionados, ventas realizadas, ingresos generados y estado del inventario.

### 4.2 Objetivos Específicos

1. **Gestión de Inventario:** Monitorear stock, productos activos y alertas de bajo stock
2. **Análisis de Ventas:** Visualizar productos más vendidos y tendencias de ventas
3. **Seguimiento de Ingresos:** Evaluar el rendimiento financiero por fundación y categoría
4. **Optimización de Productos:** Identificar productos exitosos y oportunidades de mejora
5. **Gestión de Relaciones:** Analizar relaciones comerciales con diferentes fundaciones

### 4.3 Usuarios Objetivo

- **Proveedores Registrados:** Usuarios con cuenta de proveedor activa
- **Gestores de Productos:** Personal que gestiona el catálogo de productos

### 4.4 Métricas Implementadas

#### Métrica 1: Resumen del Proveedor (KPIs Principales)
**Tipo:** Tarjetas de Indicadores

**Visualizaciones:**
- Total de Productos
- Productos Activos
- Stock Total
- Ingresos Totales
- Productos con Bajo Stock (< 10 unidades)
- Productos Sin Stock

**Propósito:**
Proporcionar una visión rápida del estado operativo del proveedor, permitiendo identificar:
- El volumen de productos gestionados
- El estado del inventario
- La salud financiera
- Alertas críticas de inventario

**Fuente de Datos:**
```sql
-- Total de Productos del Proveedor
SELECT COUNT(*) as total 
FROM test.products 
WHERE supplier_id = :supplier_id;

-- Productos Activos
SELECT COUNT(*) as activos 
FROM test.products 
WHERE supplier_id = :supplier_id 
AND estado = 'activo';

-- Stock Total
SELECT COALESCE(SUM(stock), 0) as stock_total 
FROM test.products 
WHERE supplier_id = :supplier_id;

-- Productos con Bajo Stock
SELECT COUNT(*) as bajo_stock 
FROM test.products 
WHERE supplier_id = :supplier_id 
AND stock < 10 
AND estado = 'activo';

-- Productos Sin Stock
SELECT COUNT(*) as sin_stock 
FROM test.products 
WHERE supplier_id = :supplier_id 
AND stock = 0 
AND estado = 'activo';

-- Ingresos Totales
SELECT COALESCE(SUM(o.total_amount), 0) as ingresos_totales 
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
INNER JOIN test.cart_items ci ON c.id = ci.cart_id
INNER JOIN test.products p ON ci.product_id = p.id
WHERE p.supplier_id = :supplier_id
AND o.estado = 'completado';
```

**Código Laravel:**
```php
// En Proveedor/DashboardController.php
$productosCount = Producto::where('supplier_id', $proveedor->id)->count();
$productosActivos = Producto::where('supplier_id', $proveedor->id)
    ->where('estado', 'activo')->count();
$stockTotal = Producto::where('supplier_id', $proveedor->id)->sum('stock');
$productosBajoStock = Producto::where('supplier_id', $proveedor->id)
    ->where('stock', '<', 10)->where('estado', 'activo')->count();
$productosSinStock = Producto::where('supplier_id', $proveedor->id)
    ->where('stock', '=', 0)->where('estado', 'activo')->count();
```

**Espacio para Captura de Pantalla PR-1:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Proveedor - Tarjetas de KPIs principales]
```

#### Métrica 2: Top 5 Productos Más Vendidos
**Tipo:** Gráfico de Barras Horizontales

**Visualización:**
Gráfico que muestra los 5 productos del proveedor con mayor número de ventas, incluyendo:
- Nombre del producto
- Cantidad de unidades vendidas
- Categoría del producto

**Propósito:**
- Identificar productos estrella del catálogo
- Optimizar el inventario basándose en demanda real
- Planificar estrategias de marketing para productos populares
- Reconocer oportunidades de expansión de productos similares

**Fuente de Datos:**
```sql
-- Top 5 Productos Más Vendidos
SELECT 
    p.id,
    p.name,
    p.price,
    c.name as category_name,
    COUNT(ci.id) as sales_count,
    SUM(ci.quantity) as total_quantity_sold
FROM test.products p
INNER JOIN test.categories c ON p.category_id = c.id
INNER JOIN test.cart_items ci ON p.id = ci.product_id
INNER JOIN test.carts ca ON ci.cart_id = ca.id
INNER JOIN test.orders o ON ca.id = o.cart_id
WHERE p.supplier_id = :supplier_id
AND o.estado = 'completado'
GROUP BY p.id, p.name, p.price, c.name
ORDER BY sales_count DESC
LIMIT 5;
```

**Código Laravel:**
```php
// En Proveedor/DashboardController.php
$topProductos = Producto::where('supplier_id', $proveedor->id)
    ->select('test.products.*')
    ->selectSub(function ($query) use ($foundationFilter) {
        $query->from('test.cart_items')
            ->join('test.carts', 'test.cart_items.cart_id', '=', 'test.carts.id')
            ->join('test.orders', 'test.carts.id', '=', 'test.orders.cart_id')
            ->whereColumn('test.cart_items.product_id', 'test.products.id')
            ->when($foundationFilter, function ($q) use ($foundationFilter) {
                return $q->where('test.carts.foundation_id', $foundationFilter);
            })
            ->selectRaw('COUNT(*)');
    }, 'sales_count')
    ->with('category')
    ->orderByDesc('sales_count')
    ->limit(5)
    ->get();
```

**Espacio para Captura de Pantalla PR-2:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Proveedor - Top 5 Productos Más Vendidos]
```

#### Métrica 3: Tendencias de Ventas Mensuales
**Tipo:** Gráfico de Líneas

**Visualización:**
Gráfico que muestra la evolución mensual de ventas (cantidad de unidades vendidas) del proveedor, permitiendo identificar:
- Tendencias de crecimiento o decrecimiento
- Meses de mayor y menor actividad comercial
- Estacionalidad en las ventas

**Propósito:**
- Analizar el crecimiento de ventas a lo largo del tiempo
- Identificar períodos de alta y baja demanda
- Planificar estrategias comerciales basadas en tendencias históricas
- Detectar anomalías o cambios significativos en las ventas

**Fuente de Datos:**
```sql
-- Tendencias de Ventas Mensuales
SELECT 
    EXTRACT(YEAR FROM o.created_at) as year,
    EXTRACT(MONTH FROM o.created_at) as month,
    SUM(ci.quantity) as quantity
FROM test.cart_items ci
INNER JOIN test.products p ON ci.product_id = p.id
INNER JOIN test.carts c ON ci.cart_id = c.id
INNER JOIN test.orders o ON c.id = o.cart_id
WHERE p.supplier_id = :supplier_id
AND o.created_at BETWEEN :date_from AND :date_to
AND o.estado = 'completado'
GROUP BY year, month
ORDER BY year, month;
```

**Código Laravel:**
```php
// En Proveedor/DashboardController.php
$monthlySales = CarritoItem::whereHas('product', function ($query) use ($proveedor, $categoryFilter) {
    $query->where('supplier_id', $proveedor->id)
        ->when($categoryFilter, function ($q) use ($categoryFilter) {
            return $q->where('category_id', $categoryFilter);
        });
})
->whereHas('cart.order')
->join('test.carts', 'test.cart_items.cart_id', '=', 'test.carts.id')
->join('test.orders', 'test.carts.id', '=', 'test.orders.cart_id')
->selectRaw('EXTRACT(YEAR FROM test.orders.created_at) as year, EXTRACT(MONTH FROM test.orders.created_at) as month, SUM(test.cart_items.quantity) as quantity')
->whereBetween('test.orders.created_at', [$dateFrom, $dateTo])
->groupBy('year', 'month')
->orderBy('year')
->orderBy('month')
->get();
```

**Espacio para Captura de Pantalla PR-3:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Proveedor - Tendencias de Ventas Mensuales]
```

#### Métrica 4: Ingresos por Fundación (Top 5)
**Tipo:** Gráfico de Barras

**Visualización:**
Gráfico que muestra las 5 fundaciones que generan mayores ingresos para el proveedor, incluyendo:
- Nombre de la fundación
- Ingresos generados
- Número de órdenes

**Propósito:**
- Identificar clientes estratégicos (fundaciones)
- Evaluar relaciones comerciales más rentables
- Planificar estrategias de fidelización
- Reconocer oportunidades de crecimiento con fundaciones clave

**Fuente de Datos:**
```sql
-- Ingresos por Fundación (Top 5)
SELECT 
    f.name as foundation_name,
    SUM(o.total_amount) as revenue,
    COUNT(DISTINCT o.id) as orders_count
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
INNER JOIN test.cart_items ci ON c.id = ci.cart_id
INNER JOIN test.products p ON ci.product_id = p.id
INNER JOIN test.foundations f ON c.foundation_id = f.id
WHERE p.supplier_id = :supplier_id
AND o.estado = 'completado'
GROUP BY f.id, f.name
ORDER BY revenue DESC
LIMIT 5;
```

**Código Laravel:**
```php
// En Proveedor/DashboardController.php
$revenueByFoundation = Orden::whereHas('cart.items.product', function ($query) use ($proveedor) {
    $query->where('supplier_id', $proveedor->id);
})
->with('cart.foundation')
->where('estado', 'completado')
->get()
->groupBy('cart.foundation.nombre')
->map(function ($orders, $foundation) {
    return [
        'foundation' => $foundation ?? 'Sin fundación',
        'revenue' => $orders->sum('total_amount'),
        'orders' => $orders->count(),
    ];
})
->sortByDesc('revenue')
->take(5)
->values();
```

**Espacio para Captura de Pantalla PR-4:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Proveedor - Ingresos por Fundación (Top 5)]
```

#### Métrica 5: Estado del Inventario
**Tipo:** Indicadores y Alertas

**Visualización:**
Métricas que muestran el estado crítico del inventario:
- Productos con bajo stock (< 10 unidades)
- Productos sin stock (0 unidades)
- Productos recientes agregados

**Propósito:**
- Alertar sobre productos que requieren reabastecimiento
- Prevenir desabastecimientos
- Mantener niveles óptimos de inventario
- Identificar productos que necesitan atención inmediata

**Fuente de Datos:**
```sql
-- Productos con Bajo Stock
SELECT 
    p.id,
    p.name,
    p.stock,
    c.name as category_name
FROM test.products p
INNER JOIN test.categories c ON p.category_id = c.id
WHERE p.supplier_id = :supplier_id
AND p.stock < 10
AND p.estado = 'activo'
ORDER BY p.stock ASC;

-- Productos Sin Stock
SELECT 
    p.id,
    p.name,
    c.name as category_name
FROM test.products p
INNER JOIN test.categories c ON p.category_id = c.id
WHERE p.supplier_id = :supplier_id
AND p.stock = 0
AND p.estado = 'activo';
```

**Código Laravel:**
```php
// En Proveedor/DashboardController.php
$productosBajoStock = Producto::where('supplier_id', $proveedor->id)
    ->where('stock', '<', 10)
    ->where('estado', 'activo')
    ->count();
$productosSinStock = Producto::where('supplier_id', $proveedor->id)
    ->where('stock', '=', 0)
    ->where('estado', 'activo')
    ->count();
$productosRecientes = Producto::where('supplier_id', $proveedor->id)
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();
```

**Espacio para Captura de Pantalla PR-5:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Proveedor - Estado del Inventario]
```

### 4.5 Filtros Disponibles

- **Rango de Fechas:** Fecha desde y fecha hasta
- **Filtro por Categoría:** Selección de categoría de producto
- **Filtro por Fundación:** Selección de fundación específica

---

## 5. DASHBOARD DE COMPRADOR

### 5.1 Propósito

El Dashboard de Comprador está diseñado para usuarios compradores que necesitan un panel personalizado para gestionar sus actividades en la plataforma. Proporciona métricas sobre fundaciones disponibles, votos realizados, órdenes activas, progreso de metas de donación y fundaciones más votadas.

### 5.2 Objetivos Específicos

1. **Gestión Personal:** Visualizar estadísticas personales de actividad en la plataforma
2. **Seguimiento de Órdenes:** Monitorear órdenes activas y recientes
3. **Participación Social:** Ver fundaciones más votadas y participar en votaciones
4. **Metas de Donación:** Seguir el progreso hacia metas mensuales de donación
5. **Descubrimiento:** Explorar fundaciones activas disponibles en la plataforma

### 5.3 Usuarios Objetivo

- **Compradores Registrados:** Usuarios con cuenta activa que realizan compras
- **Donantes:** Usuarios interesados en contribuir a fundaciones

### 5.4 Métricas Implementadas

#### Métrica 1: Resumen Personal (KPIs del Usuario)
**Tipo:** Tarjetas de Indicadores

**Visualizaciones:**
- Total de Fundaciones Activas Disponibles
- Votos Realizados por el Usuario
- Órdenes Activas (Pendientes/En Proceso/Enviadas)
- Progreso de Meta de Donación Mensual

**Propósito:**
Proporcionar una visión rápida de la actividad personal del usuario, permitiendo identificar:
- El alcance de fundaciones disponibles para apoyar
- El nivel de participación en votaciones
- El estado de compras activas
- El progreso hacia objetivos de donación

**Fuente de Datos:**
```sql
-- Total de Fundaciones Activas
SELECT COUNT(*) as total 
FROM test.foundations 
WHERE activa = true;

-- Votos del Usuario
SELECT COUNT(*) as total_votos 
FROM test.foundation_votes 
WHERE user_id = :user_id;

-- Órdenes Activas del Usuario
SELECT COUNT(*) as activas 
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
WHERE c.user_id = :user_id
AND o.estado IN ('pendiente', 'procesando', 'enviado');

-- Donaciones del Mes Actual
SELECT COALESCE(SUM(total_amount), 0) as donaciones_mes 
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
WHERE c.user_id = :user_id
AND o.estado = 'completado'
AND EXTRACT(YEAR FROM o.created_at) = EXTRACT(YEAR FROM CURRENT_DATE)
AND EXTRACT(MONTH FROM o.created_at) = EXTRACT(MONTH FROM CURRENT_DATE);
```

**Código Laravel:**
```php
// En Frontend/BuyerDashboardController.php
$totalFoundations = Fundacion::where('activa', true)->count();
$userVotes = $user->votes()->count();
$activeOrders = Orden::whereHas('cart', function ($query) use ($user) {
    $query->where('user_id', $user->id);
})->whereIn('estado', ['pendiente', 'procesando', 'enviado'])->count();
$currentMonthDonations = Orden::whereHas('cart', function ($query) use ($user) {
    $query->where('user_id', $user->id);
})->where('estado', 'completado')
->whereYear('created_at', now()->year)
->whereMonth('created_at', now()->month)
->sum('total_amount');
```

**Espacio para Captura de Pantalla CO-1:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Comprador - Tarjetas de KPIs personales]
```

#### Métrica 2: Progreso de Meta de Donación Mensual
**Tipo:** Gráfico de Barras de Progreso o Indicador Circular

**Visualización:**
Indicador visual que muestra:
- Meta mensual de donación (ej: $10,000)
- Donaciones realizadas en el mes actual
- Porcentaje de cumplimiento
- Monto restante para alcanzar la meta

**Propósito:**
- Motivar al usuario a alcanzar metas de donación
- Visualizar el progreso hacia objetivos personales
- Fomentar la participación continua en donaciones
- Proporcionar feedback visual del impacto personal

**Fuente de Datos:**
```sql
-- Cálculo de Meta de Donación
-- Meta mensual: $10,000 (configurable)
-- Donaciones del mes actual
SELECT 
    COALESCE(SUM(total_amount), 0) as donaciones_actuales,
    10000 as meta_mensual,
    CASE 
        WHEN COALESCE(SUM(total_amount), 0) >= 10000 THEN 100
        ELSE ROUND((COALESCE(SUM(total_amount), 0) / 10000.0) * 100, 2)
    END as porcentaje_cumplimiento,
    GREATEST(0, 10000 - COALESCE(SUM(total_amount), 0)) as monto_restante
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
WHERE c.user_id = :user_id
AND o.estado = 'completado'
AND EXTRACT(YEAR FROM o.created_at) = EXTRACT(YEAR FROM CURRENT_DATE)
AND EXTRACT(MONTH FROM o.created_at) = EXTRACT(MONTH FROM CURRENT_DATE);
```

**Código Laravel:**
```php
// En Frontend/BuyerDashboardController.php
$monthlyGoal = 10000; // Meta mensual configurable
$currentMonthDonations = Orden::whereHas('cart', function ($query) use ($user) {
    $query->where('user_id', $user->id);
})->where('estado', 'completado')
->whereYear('created_at', now()->year)
->whereMonth('created_at', now()->month)
->sum('total_amount');
$remainingAmount = max(0, $monthlyGoal - $currentMonthDonations);
$donationPercentage = min(100, ($currentMonthDonations / $monthlyGoal) * 100);
```

**Espacio para Captura de Pantalla CO-2:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Comprador - Progreso de Meta de Donación]
```

#### Métrica 3: Top 4 Fundaciones Más Votadas
**Tipo:** Tarjetas o Lista Visual

**Visualización:**
Lista de las 4 fundaciones con mayor número de votos en la plataforma, mostrando:
- Nombre de la fundación
- Número de votos recibidos
- Estado (Activa/Inactiva)
- Información básica

**Propósito:**
- Descubrir fundaciones populares y reconocidas
- Fomentar la participación en votaciones
- Mostrar el impacto social de las fundaciones
- Facilitar la selección de fundaciones para apoyar

**Fuente de Datos:**
```sql
-- Top 4 Fundaciones Más Votadas
SELECT 
    f.id,
    f.name,
    f.mission,
    COUNT(fv.id) as votes_count,
    f.activa
FROM test.foundations f
LEFT JOIN test.foundation_votes fv ON f.id = fv.foundation_id
WHERE f.activa = true
GROUP BY f.id, f.name, f.mission, f.activa
ORDER BY votes_count DESC
LIMIT 4;
```

**Código Laravel:**
```php
// En Frontend/BuyerDashboardController.php
$topFoundations = Fundacion::where('activa', true)
    ->withCount('votes')
    ->orderByDesc('votes_count')
    ->take(4)
    ->get();
```

**Espacio para Captura de Pantalla CO-3:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Comprador - Top 4 Fundaciones Más Votadas]
```

#### Métrica 4: Órdenes Recientes
**Tipo:** Lista o Tabla de Órdenes

**Visualización:**
Lista de las 10 órdenes más recientes del usuario, mostrando:
- Número de orden
- Fecha de creación
- Estado de la orden
- Monto total
- Productos incluidos

**Propósito:**
- Proporcionar acceso rápido al historial de compras
- Facilitar el seguimiento de órdenes recientes
- Permitir revisar detalles de compras anteriores
- Mejorar la experiencia de usuario con información accesible

**Fuente de Datos:**
```sql
-- Órdenes Recientes del Usuario
SELECT 
    o.id,
    o.total_amount,
    o.estado,
    o.created_at,
    COUNT(ci.id) as items_count
FROM test.orders o
INNER JOIN test.carts c ON o.cart_id = c.id
LEFT JOIN test.cart_items ci ON c.id = ci.cart_id
WHERE c.user_id = :user_id
GROUP BY o.id, o.total_amount, o.estado, o.created_at
ORDER BY o.created_at DESC
LIMIT 10;
```

**Código Laravel:**
```php
// En Frontend/BuyerDashboardController.php
$recentOrders = Orden::whereHas('cart', function ($query) use ($user) {
    $query->where('user_id', $user->id);
})
->with(['items.product'])
->orderByDesc('created_at')
->take(10)
->get();
```

**Espacio para Captura de Pantalla CO-4:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Comprador - Órdenes Recientes]
```

#### Métrica 5: Fundaciones Disponibles (Carrusel)
**Tipo:** Carrusel o Grid de Fundaciones

**Visualización:**
Carrusel visual que muestra fundaciones activas disponibles en la plataforma, incluyendo:
- Nombre de la fundación
- Misión
- Número de votos
- Estado activo

**Propósito:**
- Facilitar el descubrimiento de nuevas fundaciones
- Mostrar la diversidad de opciones disponibles
- Fomentar la exploración y participación
- Mejorar la experiencia de navegación

**Fuente de Datos:**
```sql
-- Fundaciones Disponibles para Carrusel
SELECT 
    f.id,
    f.name,
    f.mission,
    f.description,
    COUNT(fv.id) as votes_count
FROM test.foundations f
LEFT JOIN test.foundation_votes fv ON f.id = fv.foundation_id
WHERE f.activa = true
GROUP BY f.id, f.name, f.mission, f.description
ORDER BY RANDOM()
LIMIT 10;
```

**Código Laravel:**
```php
// En Frontend/BuyerDashboardController.php
$foundations = Fundacion::where('activa', true)
    ->withCount('votes')
    ->inRandomOrder()
    ->take(10)
    ->get();
```

**Espacio para Captura de Pantalla CO-5:**
```
[INSERTAR CAPTURA DE PANTALLA: Dashboard Comprador - Fundaciones Disponibles (Carrusel)]
```

### 5.5 Características Especiales

- **Interactividad:** El usuario puede votar por fundaciones directamente desde el dashboard
- **Personalización:** Las métricas se adaptan al usuario específico
- **Motivación:** Indicadores de progreso que fomentan la participación continua

---

## 6. Comparativa de Dashboards

| Característica | Admin | Fundación | Proveedor | Comprador |
|---------------|-------|-----------|-----------|-----------|
| **Visión** | Global del sistema | Específica de fundación | Específica de proveedor | Personal del usuario |
| **Métricas Principales** | 5+ métricas globales | 5 métricas de fundación | 5 métricas de proveedor | 5 métricas personales |
| **Filtros** | Fecha, Estado, Fundación, Proveedor | Fecha, Proveedor, Estado | Fecha, Categoría, Fundación | N/A |
| **Enfoque** | Supervisión y control | Gestión de proveedores y órdenes | Gestión de productos y ventas | Participación y donaciones |
| **Gráficos** | Tendencias globales | Tendencias de órdenes | Tendencias de ventas | Progreso personal |
| **Alertas** | Sistema completo | Órdenes pendientes | Bajo stock | Metas de donación |

---

## 7. MÉTRICAS DEL DASHBOARD ADMINISTRATIVO

El Dashboard Administrativo incluye **5 métricas principales** con múltiples visualizaciones:

### 7.1 Métrica 1: Resumen General del Sistema (KPIs Principales)

**Tipo:** Tarjetas de Indicadores (KPI Cards)

**Visualizaciones:**
- Total de Fundaciones (Activas/Inactivas)
- Total de Proveedores (Activos/Inactivos)
- Total de Productos (Activos/Inactivos)
- Total de Usuarios Registrados
- Total de Órdenes
- Ingresos Totales
- Productos con Bajo Stock

**Propósito:**
Proporcionar una visión rápida del estado general del sistema mediante indicadores clave que permiten identificar de un vistazo:
- El volumen de entidades gestionadas
- El estado de operación (activos vs inactivos)
- La salud financiera del sistema
- Alertas de inventario

**Fuente de Datos:**
```sql
-- Total de Fundaciones
SELECT COUNT(*) as total FROM test.foundations;

-- Fundaciones Activas
SELECT COUNT(*) as activas FROM test.foundations WHERE activa = true;

-- Total de Proveedores
SELECT COUNT(*) as total FROM test.suppliers;

-- Proveedores Activos
SELECT COUNT(*) as activos FROM test.suppliers WHERE activo = true;

-- Total de Productos
SELECT COUNT(*) as total FROM test.products;

-- Productos Activos
SELECT COUNT(*) as activos FROM test.products WHERE estado = 'activo';

-- Productos con Bajo Stock (< 10 unidades)
SELECT COUNT(*) as bajo_stock FROM test.products 
WHERE stock < 10 AND estado = 'activo';

-- Ingresos Totales
SELECT COALESCE(SUM(total_amount), 0) as ingresos_totales 
FROM test.orders;
```

**Código Laravel:**
```php
// En DashboardController.php
$totalFundaciones = Fundacion::count();
$fundacionesActivas = Fundacion::where('activa', true)->count();
$totalProveedores = Proveedor::count();
$proveedoresActivos = Proveedor::where('activo', true)->count();
$totalProductos = Producto::count();
$productosActivos = Producto::where('estado', 'activo')->count();
$productosBajoStock = Producto::where('stock', '<', 10)
    ->where('estado', 'activo')->count();
$totalIngresos = Orden::sum('total_amount') ?? 0;
```

**Espacio para Captura de Pantalla 1:**
```
[INSERTAR CAPTURA DE PANTALLA: Tarjetas de KPIs principales]
```

---

### 7.2 Métrica 2: Tendencias de Ingresos Mensuales

**Tipo:** Gráfico de Líneas (Line Chart)

**Visualización:**
Gráfico que muestra la evolución de los ingresos mensuales durante un período seleccionado, permitiendo identificar:
- Tendencias de crecimiento o decrecimiento
- Meses de mayor y menor actividad comercial
- Estacionalidad en las ventas

**Propósito:**
- Analizar el crecimiento de ingresos a lo largo del tiempo
- Identificar períodos de alta y baja demanda
- Planificar estrategias comerciales basadas en tendencias históricas
- Detectar anomalías o cambios significativos en los ingresos

**Fuente de Datos:**
```sql
-- Tendencias de Ingresos Mensuales
SELECT 
    EXTRACT(YEAR FROM created_at) as year,
    EXTRACT(MONTH FROM created_at) as month,
    SUM(total_amount) as revenue
FROM test.orders
WHERE created_at BETWEEN :date_from AND :date_to
    AND estado = :status -- Opcional: filtrar por estado
GROUP BY year, month
ORDER BY year, month;
```

**Código Laravel:**
```php
// En DashboardController.php
$monthlyRevenue = Orden::selectRaw('
        EXTRACT(YEAR FROM created_at) as year, 
        EXTRACT(MONTH FROM created_at) as month, 
        SUM(total_amount) as revenue
    ')
    ->whereBetween('created_at', [$dateFrom, $dateTo])
    ->when($statusFilter, function ($query) use ($statusFilter) {
        return $query->where('estado', $statusFilter);
    })
    ->groupBy('year', 'month')
    ->orderBy('year')
    ->orderBy('month')
    ->get()
    ->map(function ($item) {
        return [
            'month' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)),
            'revenue' => $item->revenue,
        ];
    });
```

**Espacio para Captura de Pantalla 2:**
```
[INSERTAR CAPTURA DE PANTALLA: Gráfico de líneas - Tendencias de Ingresos Mensuales]
```

---

### 7.3 Métrica 3: Distribución de Órdenes por Estado

**Tipo:** Gráfico de Barras o Gráfico Circular (Pie/Donut Chart)

**Visualización:**
Gráfico que muestra la distribución porcentual y absoluta de las órdenes según su estado:
- Pendientes
- Completadas
- Canceladas
- En Proceso

**Propósito:**
- Visualizar el estado general del flujo de órdenes
- Identificar cuellos de botella en el proceso de cumplimiento
- Monitorear la eficiencia operativa
- Detectar problemas en el procesamiento de pedidos

**Fuente de Datos:**
```sql
-- Distribución de Órdenes por Estado
SELECT 
    estado as status,
    COUNT(*) as count,
    ROUND(COUNT(*) * 100.0 / SUM(COUNT(*)) OVER (), 2) as percentage
FROM test.orders
GROUP BY estado
ORDER BY count DESC;
```

**Código Laravel:**
```php
// En DashboardController.php
$ordenesPorEstado = Orden::selectRaw('estado as status, COUNT(*) as count')
    ->groupBy('estado')
    ->get();

$totalOrdenes = Orden::count();
$ordenesPendientes = Orden::where('estado', 'pendiente')->count();
$ordenesCompletadas = Orden::where('estado', 'completada')->count();
```

**Espacio para Captura de Pantalla 3:**
```
[INSERTAR CAPTURA DE PANTALLA: Gráfico de distribución de órdenes por estado]
```

---

### 7.4 Métrica 4: Top 5 Productos Más Vendidos

**Tipo:** Gráfico de Barras Horizontales (Horizontal Bar Chart)

**Visualización:**
Gráfico que muestra los 5 productos con mayor número de ventas, incluyendo:
- Nombre del producto
- Cantidad de unidades vendidas
- Proveedor asociado
- Categoría

**Propósito:**
- Identificar productos estrella y tendencias de consumo
- Optimizar el inventario basándose en demanda real
- Reconocer proveedores con productos exitosos
- Planificar estrategias de marketing para productos populares

**Fuente de Datos:**
```sql
-- Top 5 Productos Más Vendidos
SELECT 
    p.id,
    p.name,
    p.price,
    s.name as supplier_name,
    COUNT(ci.id) as sales_count,
    SUM(ci.quantity) as total_quantity_sold
FROM test.products p
INNER JOIN test.suppliers s ON p.supplier_id = s.id
INNER JOIN test.cart_items ci ON p.id = ci.product_id
INNER JOIN test.carts c ON ci.cart_id = c.id
INNER JOIN test.orders o ON c.id = o.cart_id
WHERE o.estado = 'completada'
GROUP BY p.id, p.name, p.price, s.name
ORDER BY sales_count DESC
LIMIT 5;
```

**Código Laravel:**
```php
// En DashboardController.php
$topProductos = Producto::select('test.products.*')
    ->selectSub(function ($query) {
        $query->from('test.cart_items')
            ->join('test.carts', 'test.cart_items.cart_id', '=', 'test.carts.id')
            ->join('test.orders', 'test.carts.id', '=', 'test.orders.cart_id')
            ->whereColumn('test.cart_items.product_id', 'test.products.id')
            ->where('test.orders.estado', 'completada')
            ->selectRaw('COUNT(*)');
    }, 'sales_count')
    ->with('supplier')
    ->orderByDesc('sales_count')
    ->limit(5)
    ->get();
```

**Espacio para Captura de Pantalla 4:**
```
[INSERTAR CAPTURA DE PANTALLA: Gráfico de barras horizontales - Top 5 Productos Más Vendidos]
```

---

### 7.5 Métrica 5: Distribución de Productos por Categoría

**Tipo:** Gráfico Circular (Pie Chart) o Gráfico de Barras

**Visualización:**
Gráfico que muestra la distribución de productos según su categoría:
- Materiales
- Equipos
- Alimentos
- Gaseosas
- Otros

**Propósito:**
- Entender la composición del catálogo de productos
- Identificar categorías con mayor o menor representación
- Planificar estrategias de diversificación
- Analizar la demanda por tipo de producto

**Fuente de Datos:**
```sql
-- Distribución de Productos por Categoría
SELECT 
    c.name as categoria,
    COUNT(p.id) as total_productos,
    ROUND(COUNT(p.id) * 100.0 / SUM(COUNT(p.id)) OVER (), 2) as percentage
FROM test.products p
INNER JOIN test.categories c ON p.category_id = c.id
WHERE p.estado = 'activo'
GROUP BY c.id, c.name
ORDER BY total_productos DESC;
```

**Código Laravel:**
```php
// En DashboardController.php
$productosPorCategoria = Producto::with('category')
    ->selectRaw('category_id, COUNT(*) as total')
    ->where('estado', 'activo')
    ->groupBy('category_id')
    ->get()
    ->map(function ($item) {
        return [
            'categoria' => $item->category?->name ?? 'Sin categoría',
            'total' => $item->total,
        ];
    });
```

**Espacio para Captura de Pantalla 5:**
```
[INSERTAR CAPTURA DE PANTALLA: Gráfico circular - Distribución de Productos por Categoría]
```

---

## 8. Información Procesada y Análisis

### 3.1 Tendencias Calculadas

El dashboard procesa información para generar:

1. **Porcentajes de Actividad:**
   - Porcentaje de fundaciones activas vs inactivas
   - Porcentaje de proveedores activos vs inactivos
   - Porcentaje de productos activos vs inactivos

2. **Tendencias Temporales:**
   - Crecimiento mensual de ingresos
   - Tendencias de registro de usuarios
   - Evolución de órdenes por mes

3. **Rankings y Top Lists:**
   - Top 5 productos más vendidos
   - Top 5 fundaciones por número de órdenes
   - Top 5 proveedores por cantidad de productos

4. **Estados y Distribuciones:**
   - Distribución de órdenes por estado
   - Distribución de productos por categoría
   - Distribución de usuarios por rol

### 3.2 Alertas y Notificaciones

El sistema genera alertas automáticas para:
- Productos con bajo stock (< 10 unidades)
- Órdenes pendientes por más de X días
- Fundaciones inactivas
- Proveedores sin productos activos

---

## 9. Filtros y Controles Interactivos

### 4.1 Filtros Implementados

El dashboard incluye los siguientes controles de filtrado:

1. **Filtro por Rango de Fechas:**
   - Fecha desde (date_from)
   - Fecha hasta (date_to)
   - Permite analizar períodos específicos

2. **Filtro por Estado de Orden:**
   - Pendiente
   - Completada
   - Cancelada
   - En Proceso

3. **Filtro por Fundación:**
   - Selección de fundación específica
   - Permite análisis por entidad

4. **Filtro por Proveedor:**
   - Selección de proveedor específico
   - Permite análisis por proveedor

**Código de Implementación de Filtros:**
```php
// En DashboardController.php - método index()
public function __invoke(): View
{
    // Obtener parámetros de filtro
    $dateFrom = request('date_from', now()->subDays(30)->format('Y-m-d'));
    $dateTo = request('date_to', now()->format('Y-m-d'));
    $foundationFilter = request('foundation_id');
    $supplierFilter = request('supplier_id');
    $statusFilter = request('status');

    // Aplicar filtros a las consultas
    $query = Orden::query();
    
    if ($dateFrom) {
        $query->where('created_at', '>=', $dateFrom);
    }
    
    if ($dateTo) {
        $query->where('created_at', '<=', $dateTo);
    }
    
    if ($statusFilter) {
        $query->where('estado', $statusFilter);
    }
    
    // ... más filtros
}
```

**Espacio para Captura de Pantalla 6:**
```
[INSERTAR CAPTURA DE PANTALLA: Panel de filtros del dashboard]
```

---

## 10. Integración en el Sistema Laravel

### 5.1 Estructura de Archivos

El dashboard está integrado en la estructura del proyecto Laravel:

```
app/
├── Http/
│   └── Controllers/
│       └── Admin/
│           └── DashboardController.php    # Controlador principal
│
resources/
└── views/
    └── admin/
        └── dashboard/
            └── index.blade.php            # Vista del dashboard
```

### 5.2 Rutas

```php
// routes/web.php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, '__invoke'])
        ->name('admin.dashboard');
});
```

### 5.3 Tecnologías Utilizadas

- **Backend:** Laravel 12.38.1 (PHP 8.4)
- **Base de Datos:** PostgreSQL
- **Frontend:** Blade Templates + Tailwind CSS
- **Gráficos:** Chart.js o ApexCharts (según implementación)
- **JavaScript:** Vanilla JS o Alpine.js

**Espacio para Captura de Pantalla 7:**
```
[INSERTAR CAPTURA DE PANTALLA: Código del controlador DashboardController.php]
```

**Espacio para Captura de Pantalla 8:**
```
[INSERTAR CAPTURA DE PANTALLA: Código de la vista index.blade.php - Sección de gráficos]
```

---

## 11. Consultas Optimizadas y Fuentes de Datos

### 6.1 Optimización de Consultas

Las consultas están optimizadas mediante:

1. **Uso de Índices:**
   - Índices en campos de fecha (created_at)
   - Índices en campos de estado (estado, activa, activo)
   - Índices en claves foráneas

2. **Agregaciones en Base de Datos:**
   - Uso de GROUP BY y funciones de agregación
   - Evita procesamiento en memoria

3. **Eager Loading:**
   - Uso de `with()` para evitar N+1 queries
   - Carga anticipada de relaciones

### 6.2 Ejemplo de Consulta Optimizada Completa

```sql
-- Consulta optimizada para Top Productos con relaciones
SELECT 
    p.id,
    p.name,
    p.price,
    p.stock,
    s.name as supplier_name,
    c.name as category_name,
    COUNT(DISTINCT o.id) as order_count,
    SUM(ci.quantity) as total_quantity_sold,
    SUM(ci.quantity * ci.price) as total_revenue
FROM test.products p
INNER JOIN test.suppliers s ON p.supplier_id = s.id
INNER JOIN test.categories c ON p.category_id = c.id
LEFT JOIN test.cart_items ci ON p.id = ci.product_id
LEFT JOIN test.carts ca ON ci.cart_id = ca.id
LEFT JOIN test.orders o ON ca.id = o.cart_id AND o.estado = 'completada'
WHERE p.estado = 'activo'
GROUP BY p.id, p.name, p.price, p.stock, s.name, c.name
ORDER BY order_count DESC, total_revenue DESC
LIMIT 5;

-- Índices recomendados:
CREATE INDEX idx_products_estado ON test.products(estado);
CREATE INDEX idx_orders_estado_created ON test.orders(estado, created_at);
CREATE INDEX idx_cart_items_product ON test.cart_items(product_id);
```

**Espacio para Captura de Pantalla 9:**
```
[INSERTAR CAPTURA DE PANTALLA: Consultas SQL optimizadas ejecutadas en pgAdmin o herramienta de BD]
```

---

## 12. Justificación del Valor para el Cliente

### 7.1 Beneficios Estratégicos

1. **Visibilidad Completa del Negocio:**
   - Los administradores pueden ver el estado completo del sistema en un solo lugar
   - Reduce el tiempo necesario para obtener información crítica
   - Facilita la identificación rápida de problemas

2. **Toma de Decisiones Basada en Datos:**
   - Las tendencias de ingresos permiten planificar estrategias comerciales
   - Los rankings de productos ayudan a optimizar el inventario
   - La distribución por estados permite mejorar procesos operativos

3. **Eficiencia Operativa:**
   - Las alertas de bajo stock previenen desabastecimientos
   - La visualización de órdenes pendientes permite priorizar trabajo
   - Los filtros permiten análisis específicos sin necesidad de consultas manuales

4. **Análisis de Rendimiento:**
   - Identificación de productos exitosos para replicar estrategias
   - Detección de categorías con menor representación para diversificar
   - Monitoreo del crecimiento del negocio mes a mes

5. **Mejora Continua:**
   - Los datos históricos permiten comparar períodos
   - Las métricas de actividad ayudan a identificar áreas de mejora
   - Los indicadores de estado facilitan el seguimiento de objetivos

### 7.2 Casos de Uso Específicos

**Caso 1: Gestión de Inventario**
- El administrador revisa el dashboard y ve que hay 15 productos con bajo stock
- Revisa el Top 5 de productos más vendidos
- Toma la decisión de reabastecer primero los productos del Top 5 que están con bajo stock

**Caso 2: Análisis de Temporada**
- El administrador filtra los ingresos del último trimestre
- Observa un pico en diciembre y una caída en enero
- Planifica estrategias de marketing para mantener ventas en períodos bajos

**Caso 3: Optimización de Catálogo**
- El administrador revisa la distribución por categoría
- Identifica que "Gaseosas" tiene solo 5 productos mientras "Alimentos" tiene 50
- Decide diversificar la categoría de gaseosas para aumentar opciones

**Caso 4: Monitoreo de Operaciones**
- El administrador revisa la distribución de órdenes por estado
- Observa que hay 30% de órdenes pendientes
- Investiga el proceso de cumplimiento para identificar cuellos de botella

**Espacio para Captura de Pantalla 10:**
```
[INSERTAR CAPTURA DE PANTALLA: Vista completa del dashboard funcionando]
```

---

## 13. Diseño y Usabilidad

### 8.1 Principios de Diseño Aplicados

1. **Claridad Visual:**
   - Uso de colores consistentes para estados (verde=activo, rojo=inactivo)
   - Tipografía legible y tamaños apropiados
   - Espaciado adecuado entre elementos

2. **Jerarquía de Información:**
   - KPIs principales en la parte superior
   - Gráficos de tendencias en el centro
   - Tablas y listas detalladas en la parte inferior

3. **Responsive Design:**
   - Adaptable a diferentes tamaños de pantalla
   - Gráficos que se ajustan automáticamente
   - Navegación móvil optimizada

4. **Interactividad:**
   - Filtros que actualizan todos los gráficos simultáneamente
   - Tooltips informativos en gráficos
   - Navegación intuitiva

**Espacio para Captura de Pantalla 11:**
```
[INSERTAR CAPTURA DE PANTALLA: Diseño responsive del dashboard en móvil/tablet]
```

---

## 14. Implementación Técnica de Gráficos

### 9.1 Ejemplo de Código JavaScript para Gráficos

```javascript
// Ejemplo usando Chart.js para el gráfico de ingresos mensuales
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($monthlyRevenue->pluck('month')),
        datasets: [{
            label: 'Ingresos Mensuales',
            data: @json($monthlyRevenue->pluck('revenue')),
            borderColor: 'rgb(147, 51, 234)',
            backgroundColor: 'rgba(147, 51, 234, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Ingresos: $' + context.parsed.y.toLocaleString('es-BO');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString('es-BO');
                    }
                }
            }
        }
    }
});
```

**Espacio para Captura de Pantalla 12:**
```
[INSERTAR CAPTURA DE PANTALLA: Código JavaScript de implementación de gráficos]
```

---

## 15. Métricas Adicionales y Expansión Futura

### 10.1 Métricas Adicionales Implementadas

Además de las 5 métricas principales, el dashboard incluye:

1. **Tendencias de Registro de Usuarios:**
   - Gráfico de línea mostrando crecimiento de usuarios por mes
   - Permite identificar períodos de mayor adopción

2. **Top 5 Fundaciones por Órdenes:**
   - Ranking de fundaciones más activas
   - Útil para identificar socios estratégicos

3. **Valor Total del Inventario:**
   - Cálculo del valor monetario total del stock
   - Importante para gestión financiera

4. **Carritos Activos vs Completados:**
   - Métrica de conversión de carritos a órdenes
   - Identifica oportunidades de mejora en el proceso de compra

### 10.2 Posibles Expansiones Futuras

- Dashboard específico para eventos (registros, asistencia, participación)
- Análisis de satisfacción de clientes (ratings, votos)
- Predicciones y forecasting de ventas
- Análisis de comportamiento de usuarios
- Reportes exportables en PDF/Excel

---

## 16. Conclusión

El Dashboard Estadístico del Sistema Admin LTA proporciona una solución integral para la visualización y análisis de datos del e-commerce de fundaciones. Con sus 5 métricas principales, múltiples visualizaciones, filtros interactivos y análisis procesados, cumple con todos los requisitos establecidos:

✅ **3-5 métricas o visualizaciones:** Implementadas (5 métricas principales + adicionales)  
✅ **Información procesada:** Tendencias, conteos, top 5, porcentajes, estados  
✅ **Integración en Laravel:** Completamente integrado en el sistema  
✅ **Claridad y utilidad:** Diseño claro y orientado al usuario  
✅ **Estado general del sistema:** KPIs y métricas clave visibles de inmediato  

El dashboard aporta valor significativo al cliente al facilitar la toma de decisiones, mejorar la eficiencia operativa y proporcionar insights accionables basados en datos reales del sistema.

---

## 17. Anexos

### Anexo A: Capturas de Pantalla Requeridas

#### Dashboard Administrativo:
1. ✅ Vista completa del dashboard administrativo funcionando
2. ✅ Tarjetas de KPIs principales (Admin)
3. ✅ Gráfico de líneas - Tendencias de Ingresos Mensuales (Admin)
4. ✅ Gráfico de distribución de órdenes por estado (Admin)
5. ✅ Gráfico de barras horizontales - Top 5 Productos Más Vendidos (Admin)
6. ✅ Gráfico circular - Distribución de Productos por Categoría (Admin)
7. ✅ Panel de filtros del dashboard administrativo

#### Dashboard de Fundación:
8. ✅ Vista completa del dashboard de fundación (FD-1)
9. ✅ Top 5 Proveedores por Órdenes (FD-2)
10. ✅ Tendencias de Órdenes Mensuales (FD-3)
11. ✅ Distribución de Productos por Categoría (FD-4)
12. ✅ Distribución de Órdenes por Estado (FD-5)

#### Dashboard de Proveedor:
13. ✅ Vista completa del dashboard de proveedor (PR-1)
14. ✅ Top 5 Productos Más Vendidos (PR-2)
15. ✅ Tendencias de Ventas Mensuales (PR-3)
16. ✅ Ingresos por Fundación Top 5 (PR-4)
17. ✅ Estado del Inventario (PR-5)

#### Dashboard de Comprador:
18. ✅ Vista completa del dashboard de comprador (CO-1)
19. ✅ Progreso de Meta de Donación (CO-2)
20. ✅ Top 4 Fundaciones Más Votadas (CO-3)
21. ✅ Órdenes Recientes (CO-4)
22. ✅ Fundaciones Disponibles Carrusel (CO-5)

#### Código y Consultas:
23. ✅ Código del controlador DashboardController.php (Admin)
24. ✅ Código del controlador Fundacion/DashboardController.php
25. ✅ Código del controlador Proveedor/DashboardController.php
26. ✅ Código del controlador BuyerDashboardController.php
27. ✅ Código de las vistas blade.php - Sección de gráficos
28. ✅ Consultas SQL optimizadas ejecutadas
29. ✅ Diseño responsive de los dashboards
30. ✅ Código JavaScript de implementación de gráficos

### Anexo B: Estructura de Base de Datos Relevante

```
test.foundations          # Fundaciones
test.suppliers            # Proveedores
test.products             # Productos
test.categories           # Categorías
test.orders               # Órdenes
test.carts                # Carritos
test.cart_items           # Items de carrito
test.users                # Usuarios
test.events               # Eventos
test.event_registrations  # Registros de eventos
```

---

**Fin del Documento**

*Documento generado para el proyecto Admin LTA - Sistema de Gestión para Fundaciones*  
*Fecha: [Fecha Actual]*  
*Versión: 1.0*

