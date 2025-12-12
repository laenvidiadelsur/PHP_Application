# Fundación con Proveedores y Productos - Datos Reales

## 📋 Información de la Fundación

- **ID:** 27
- **Nombre:** Fundación Esperanza
- **Misión:** Brindar apoyo y esperanza a familias en situación vulnerable
- **Descripción:** Organización sin fines de lucro dedicada a mejorar la calidad de vida de comunidades necesitadas a través de programas de asistencia social, educación y desarrollo comunitario.
- **Dirección:** Av. Principal 123, Ciudad
- **Estado:** ✅ Activa
- **Verificada:** ✅ Sí
- **Total Proveedores Asociados:** 3
- **Total Productos Disponibles:** 18 productos activos

---

## 🔐 Credenciales de Acceso

**⚠️ NOTA:** Esta fundación no tiene usuario asociado en los seeders actuales. Para crear un usuario para esta fundación, puedes:

1. **Crear manualmente** desde el panel de administración
2. **O usar otra fundación** que sí tenga usuario, como:
   - **Fundación Ayuda a los Niños** - Email: `maria@fundacionayuda.com` / Contraseña: `password`

---

## 🏪 Proveedores Asociados

### 1. Distribuidora Alimentos S.A.
- **ID:** 52
- **Contacto:** Juan Pérez
- **Email:** contacto@alimentos-sa.com
- **Teléfono:** +1234567890
- **Estado:** ✅ Activo / Aprobado
- **Total Productos:** 9 productos activos

#### Productos Disponibles:

**📦 Categoría: Alimentos (6 productos)**
- **Frijoles Negros 2kg** - Precio: Bs. 5.75 | Stock: 200 unidades
- **Aceite Vegetal 1L** - Precio: Bs. 4.25 | Stock: 300 unidades
- **Azúcar Blanca 2kg** - Precio: Bs. 3.50 | Stock: 250 unidades
- **Pasta Espagueti 500g** - Precio: Bs. 2.75 | Stock: 400 unidades
- **Arroz Premium 5kg** - Precio: Bs. 8.50 | Stock: 149 unidades
- **Y 1 producto más** en esta categoría

**📦 Categoría: Materiales (2 productos)**
- **Cemento Portland 50kg** - Precio: Bs. 45.00 | Stock: 150 unidades
- **Alambre Galvanizado kg** - Precio: Bs. 12.50 | Stock: 300 unidades

**📦 Categoría: Ropa (1 producto)**
- **Pantalón Jeans x12** - Precio: Bs. 480.00 | Stock: 50 unidades

---

### 2. Materiales Constructores Ltda.
- **ID:** 53
- **Contacto:** María González
- **Email:** ventas@constructores.com
- **Teléfono:** +1234567891
- **Estado:** ✅ Activo / Aprobado
- **Total Productos:** 5 productos activos

#### Productos Disponibles:

**📦 Categoría: Materiales de Construcción (3 productos)**
- **Cemento Portland 50kg** - Precio: Bs. 12.00 | Stock: 80 unidades
- **Ladrillos Comunes x100** - Precio: Bs. 45.00 | Stock: 50 unidades
- **Varilla de Acero #3** - Precio: Bs. 8.50 | Stock: 120 unidades

**📦 Categoría: Materiales (1 producto)**
- **Piedra Triturada m3** - Precio: Bs. 150.00 | Stock: 100 unidades

**📦 Categoría: Alimentos (1 producto)**
- **Fideos Variados x12** - Precio: Bs. 45.00 | Stock: 500 unidades

---

### 3. provider
- **ID:** 63
- **Contacto:** provider
- **Email:** provider@gmail.com
- **Teléfono:** 467475
- **Estado:** ✅ Activo / Pendiente
- **Total Productos:** 4 productos activos

#### Productos Disponibles:

**📦 Categoría: Materiales (1 producto)**
- **Pintura Latex 20L** - Precio: Bs. 280.00 | Stock: 50 unidades

**📦 Categoría: Equipos (1 producto)**
- **Pulidora Angular** - Precio: Bs. 280.00 | Stock: 18 unidades

**📦 Categoría: Alimentos (1 producto)**
- **asf** - Precio: Bs. 100.00 | Stock: 0 unidades ⚠️

**📦 Categoría: Otros (1 producto)**
- **Papel Higiénico x48** - Precio: Bs. 160.00 | Stock: 150 unidades

---

## 📊 Resumen de Productos por Categoría

| Categoría | Cantidad de Productos |
|-----------|----------------------|
| Alimentos | 8 productos |
| Materiales | 4 productos |
| Materiales de Construcción | 3 productos |
| Equipos | 1 producto |
| Ropa | 1 producto |
| Otros | 1 producto |
| **TOTAL** | **18 productos** |

---

## 💰 Valor Total del Inventario

**Cálculo aproximado:** Suma de (Precio × Stock) de todos los productos activos

**Nota:** Este cálculo se realiza automáticamente en el Dashboard de Fundación.

---

## 🔍 Cómo Ver Estos Datos en el Sistema

### Opción 1: Dashboard de Fundación
1. Inicia sesión con un usuario de fundación (ej: `maria@fundacionayuda.com` / `password`)
2. Ve a `/fundacion/dashboard`
3. Verás todos los proveedores y productos asociados a tu fundación

### Opción 2: Vista de Fundación (Frontend)
1. Ve a `/foundations/{id}` donde `{id}` es el ID de la fundación (27 en este caso)
2. Verás los proveedores y productos disponibles para compra

### Opción 3: Panel Administrativo
1. Inicia sesión como administrador (`admin@lta.com` / `password`)
2. Ve a `/admin/fundaciones`
3. Selecciona la fundación para ver detalles completos

---

## 📝 Notas Importantes

1. **Asignación de Proveedores:** Los proveedores se asignan aleatoriamente a las fundaciones mediante los seeders. Cada ejecución puede generar asignaciones diferentes.

2. **Productos Activos:** Solo se muestran productos con estado `activo`. Los productos inactivos no aparecen en el catálogo.

3. **Stock Bajo:** Algunos productos pueden tener stock bajo o cero. El dashboard muestra alertas para estos casos.

4. **Categorías:** Los productos pueden tener categorías diferentes según cómo fueron creados en los seeders.

5. **Precios:** Todos los precios están en Bolivianos (Bs.) y son valores de ejemplo generados por los seeders.

---

## 🔄 Regenerar Datos

Si necesitas regenerar los datos con diferentes asignaciones:

```bash
php artisan migrate:fresh --seed
```

**⚠️ ADVERTENCIA:** Esto eliminará todos los datos existentes y creará nuevos datos aleatorios.

---

## 📋 Fundación Alternativa con Usuario

Si necesitas una fundación que **sí tenga usuario asociado**, puedes usar:

### Fundación Ayuda a los Niños
- **ID:** Variable (según seeders)
- **Email Usuario:** `maria@fundacionayuda.com`
- **Contraseña:** `password`
- **Nombre Usuario:** María González
- **URL Dashboard:** `/fundacion/dashboard`

Esta fundación también tiene proveedores y productos asignados aleatoriamente por los seeders.

---

**Documento generado:** 2025-12-11  
**Sistema:** Admin LTA - Plataforma de Gestión para Fundaciones  
**Fuente:** Datos reales de la base de datos

