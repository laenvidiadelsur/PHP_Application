# Estructura de Base de Datos - Admin LTA

## Resumen de Tablas

Este documento describe la estructura completa de la base de datos del proyecto admin-lta.

### Tablas del Sistema Laravel

1. **users** - Usuarios del sistema Laravel
   - `id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `timestamps`

2. **password_reset_tokens** - Tokens para reset de contraseñas
   - `email` (PK), `token`, `created_at`

3. **sessions** - Sesiones de usuario
   - `id` (PK), `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`

4. **cache** - Caché del sistema
   - `key` (PK), `value`, `expiration`

5. **cache_locks** - Locks de caché
   - `key` (PK), `owner`, `expiration`

6. **jobs** - Cola de trabajos
   - `id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`

7. **job_batches** - Lotes de trabajos
   - `id` (PK), `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`

8. **failed_jobs** - Trabajos fallidos
   - `id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`

### Tablas del Dominio LTA (E-commerce)

#### 1. **fundacion**
Tabla principal de fundaciones.

**Campos:**
- `id` (PK, bigint)
- `nombre` (string, 120)
- `nit` (string, 50, unique)
- `direccion` (string, 200)
- `telefono` (string, 30)
- `email` (string, 120, unique)
- `representante_nombre` (string, 120)
- `representante_ci` (string, 40)
- `mision` (text)
- `fecha_creacion` (date, default: CURRENT_DATE)
- `area_accion` (string, 120)
- `cuenta_bancaria` (string, 80, nullable)
- `logo` (string, 255, nullable)
- `descripcion` (text, nullable)
- `activa` (boolean, default: true)
- `created_at` (timestampTz)
- `updated_at` (timestampTz)

#### 2. **proveedor**
Tabla de proveedores asociados a fundaciones.

**Campos:**
- `id` (PK, bigint)
- `nombre` (string, 120)
- `nit` (string, 50, unique)
- `direccion` (string, 200)
- `telefono` (string, 30)
- `email` (string, 120, unique)
- `representante_nombre` (string, 120)
- `representante_ci` (string, 40)
- `tipo_servicio` (string, 120)
- `fundacion_id` (FK → fundacion.id)
- `estado` (string, 20, default: 'pendiente')
  - Constraint: CHECK (estado IN ('pendiente','aprobado','rechazado'))
- `activo` (boolean, default: true)
- `created_at` (timestampTz)
- `updated_at` (timestampTz)

#### 3. **proveedor_imagen**
Imágenes de proveedores.

**Campos:**
- `id` (PK, bigint)
- `proveedor_id` (FK → proveedor.id, CASCADE DELETE)
- `url` (string, 255, nullable)
- `public_id` (string, 255, nullable)

#### 4. **usuario**
Tabla de usuarios del sistema (diferente de `users` de Laravel).

**Campos:**
- `id` (PK, bigint)
- `nombre` (string, 120)
- `email` (string, 120, unique)
- `password_hash` (string, 255)
- `rol` (string, 20, default: 'usuario')
  - Constraint: CHECK (rol IN ('admin','fundacion','proveedor','usuario'))
- `fundacion_id` (FK → fundacion.id, nullable, nullOnDelete)
- `proveedor_id` (FK → proveedor.id, nullable, nullOnDelete)
- `rol_model` (string, 20, nullable)
  - Constraint: CHECK (rol_model IS NULL OR rol_model IN ('Fundacion','Proveedor'))
- `activo` (boolean, default: true)
- `created_at` (timestampTz)
- `updated_at` (timestampTz)

**Constraints adicionales:**
- `usuario_rol_dependencies_check`: Valida que si `rol_model = 'Fundacion'` entonces `fundacion_id IS NOT NULL` y `proveedor_id IS NULL`, y viceversa para `Proveedor`.

#### 5. **producto**
Catálogo de productos.

**Campos:**
- `id` (PK, bigint)
- `nombre` (string, 150)
- `descripcion` (text)
- `precio` (decimal, 12, 2)
  - Constraint: CHECK (precio >= 0)
- `unidad` (string, 20)
  - Constraint: CHECK (unidad IN ('kg','unidad','litro','metro'))
- `stock` (integer, default: 0)
  - Constraint: CHECK (stock >= 0)
- `categoria` (string, 30)
  - Constraint: CHECK (categoria IN ('materiales','equipos','alimentos','gaseosas','otros'))
- `proveedor_id` (FK → proveedor.id)
- `fundacion_id` (FK → fundacion.id)
- `estado` (string, 20, default: 'activo')
  - Constraint: CHECK (estado IN ('activo','inactivo'))
- `created_at` (timestampTz)
- `updated_at` (timestampTz)

**Índices:**
- `idx_producto_nombre` (nombre)
- `idx_producto_categoria` (categoria)
- `idx_producto_proveedor` (proveedor_id)
- `idx_producto_fundacion` (fundacion_id)

#### 6. **producto_imagen**
Imágenes de productos.

**Campos:**
- `id` (PK, bigint)
- `producto_id` (FK → producto.id, CASCADE DELETE)
- `url` (string, 255, nullable)
- `public_id` (string, 255, nullable)

#### 7. **carrito**
Carritos de compra (pueden ser de usuario autenticado o por sesión).

**Campos:**
- `id` (PK, bigint)
- `usuario_id` (FK → usuario.id, nullable, nullOnDelete)
- `total` (decimal, 12, 2, default: 0)
  - Constraint: CHECK (total >= 0)
- `estado` (string, 20, default: 'activo')
  - Constraint: CHECK (estado IN ('activo','procesando','completado','abandonado'))
- `fecha_expiracion` (timestampTz, nullable)
- `session_id` (string, 100, nullable)
- `created_at` (timestampTz)
- `updated_at` (timestampTz)

**Índices:**
- `idx_carrito_usuario` (usuario_id)
- `idx_carrito_estado` (estado)
- `idx_carrito_fecha_expira` (fecha_expiracion)
- `idx_carrito_session_activo` (session_id, UNIQUE WHERE session_id IS NOT NULL)

#### 8. **carrito_item**
Items del carrito de compra.

**Campos:**
- `id` (PK, bigint)
- `carrito_id` (FK → carrito.id, CASCADE DELETE)
- `producto_id` (FK → producto.id)
- `cantidad` (integer)
  - Constraint: CHECK (cantidad >= 1)
- `precio_unitario` (decimal, 12, 2)
  - Constraint: CHECK (precio_unitario >= 0)
- `subtotal` (decimal, 12, 2)
  - Constraint: CHECK (subtotal >= 0)

#### 9. **orden**
Órdenes de compra.

**Campos:**
- `id` (PK, bigint)
- `numero_orden` (string, 50, unique)
- `usuario_id` (FK → usuario.id)
- `subtotal` (decimal, 12, 2)
  - Constraint: CHECK (subtotal >= 0)
- `impuestos` (decimal, 12, 2, default: 0)
  - Constraint: CHECK (impuestos >= 0)
- `envio` (decimal, 12, 2, default: 0)
  - Constraint: CHECK (envio >= 0)
- `total` (decimal, 12, 2)
  - Constraint: CHECK (total >= 0)
- `direccion_calle` (string, 200, nullable)
- `direccion_ciudad` (string, 120, nullable)
- `direccion_estado` (string, 120, nullable)
- `direccion_codigo_postal` (string, 20, nullable)
- `direccion_pais` (string, 5, default: 'MX')
- `coord_latitud` (decimal, 9, 6, nullable)
- `coord_longitud` (decimal, 9, 6, nullable)
- `contacto_nombre` (string, 150, nullable)
- `contacto_telefono` (string, 40, nullable)
- `contacto_email` (string, 120, nullable)
- `estado_pago` (string, 20, default: 'pendiente')
  - Constraint: CHECK (estado_pago IN ('pendiente','procesando','completado','fallido','reembolsado'))
- `estado_envio` (string, 20, default: 'pendiente')
  - Constraint: CHECK (estado_envio IN ('pendiente','procesando','enviado','entregado','cancelado'))
- `metodo_pago` (string, 20, default: 'stripe')
  - Constraint: CHECK (metodo_pago IN ('stripe','efectivo','transferencia'))
- `stripe_payment_intent_id` (string, 120, nullable)
- `stripe_charge_id` (string, 120, nullable)
- `stripe_marca` (string, 50, nullable)
- `stripe_ultimos4` (string, 4, nullable)
- `stripe_tipo` (string, 50, nullable)
- `fecha_pago` (timestampTz, nullable)
- `notas` (text, nullable)
- `created_at` (timestampTz)
- `updated_at` (timestampTz)

**Índices:**
- `idx_orden_usuario` (usuario_id)
- `idx_orden_estado_pago` (estado_pago)
- `idx_orden_estado_envio` (estado_envio)
- `idx_orden_created_at` (created_at DESC)

#### 10. **orden_item**
Items de las órdenes.

**Campos:**
- `id` (PK, bigint)
- `orden_id` (FK → orden.id, CASCADE DELETE)
- `producto_id` (FK → producto.id)
- `proveedor_id` (FK → proveedor.id)
- `nombre` (string, 150, nullable)
- `cantidad` (integer)
  - Constraint: CHECK (cantidad >= 1)
- `precio_unitario` (decimal, 12, 2)
  - Constraint: CHECK (precio_unitario >= 0)
- `subtotal` (decimal, 12, 2)
  - Constraint: CHECK (subtotal >= 0)

**Índices:**
- `idx_orden_item_proveedor` (proveedor_id)

#### 11. **licencias**
Tabla de licencias de tránsito (LTA).

**Campos:**
- `id` (PK, bigint)
- `numero` (string, unique)
- `titular_id` (unsignedBigInteger)
- `estado` (string, default: 'pendiente')
- `vigencia_desde` (date)
- `vigencia_hasta` (date, nullable)
- `created_at` (timestamp)
- `updated_at` (timestamp)

## Relaciones entre Tablas

```
fundacion (1) ──< (N) proveedor
fundacion (1) ──< (N) usuario
fundacion (1) ──< (N) producto

proveedor (1) ──< (N) proveedor_imagen
proveedor (1) ──< (N) usuario
proveedor (1) ──< (N) producto
proveedor (1) ──< (N) orden_item

usuario (1) ──< (N) carrito
usuario (1) ──< (N) orden

producto (1) ──< (N) producto_imagen
producto (1) ──< (N) carrito_item
producto (1) ──< (N) orden_item

carrito (1) ──< (N) carrito_item

orden (1) ──< (N) orden_item
```

## Migraciones Disponibles

Todas las migraciones están en `database/migrations/`:

1. `0001_01_01_000000_create_users_table.php` - Tablas base de Laravel
2. `0001_01_01_000001_create_cache_table.php` - Sistema de caché
3. `0001_01_01_000002_create_jobs_table.php` - Sistema de colas
4. `2025_11_13_000000_create_licencias_table.php` - Licencias LTA
5. `2025_11_13_010000_create_fundacion_table.php` - Fundaciones
6. `2025_11_13_010100_create_proveedor_table.php` - Proveedores
7. `2025_11_13_010200_create_proveedor_imagen_table.php` - Imágenes de proveedores
8. `2025_11_13_010300_create_usuario_table.php` - Usuarios del sistema
9. `2025_11_13_010400_create_producto_table.php` - Productos
10. `2025_11_13_010500_create_producto_imagen_table.php` - Imágenes de productos
11. `2025_11_13_010600_create_carrito_table.php` - Carritos
12. `2025_11_13_010700_create_carrito_item_table.php` - Items de carrito
13. `2025_11_13_010800_create_orden_table.php` - Órdenes
14. `2025_11_13_010900_create_orden_item_table.php` - Items de órdenes

## Notas Importantes

- El proyecto usa **PostgreSQL** como base de datos (configurado en `config/database.php`)
- Todas las tablas del dominio LTA usan `timestampTz` para timestamps (con zona horaria)
- Se utilizan constraints CHECK para validar valores permitidos en varios campos
- Las relaciones de eliminación están configuradas con CASCADE DELETE donde corresponde
- El sistema soporta carritos tanto para usuarios autenticados como para sesiones anónimas

