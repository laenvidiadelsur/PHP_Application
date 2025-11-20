## Admin LTA - Configuración Rápida

Proyecto Laravel enfocado en la administración de licencias de tránsito (LTA) con panel dedicado y dominio LTA modular.

### Requisitos
- PHP 8.2+ con extensión `pdo_pgsql`
- Composer y Node.js (v18+ recomendado)
- PostgreSQL 13+

### Instalación básica
1. `composer install`
2. `npm install`
3. Copia `.env.example` a `.env` y genera la APP key:
   ```bash
   php artisan key:generate
   ```

### Conexión a PostgreSQL
Actualiza tu `.env` con los datos del servidor:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=admin_lta
DB_USERNAME=postgres
DB_PASSWORD=secret
DB_SCHEMA=public
```
Si usas SSL, agrega `DB_SSLMODE=require`. Luego limpia la caché de configuración:
```bash
php artisan config:clear
```

### Migraciones y seeders
```bash
php artisan migrate
php artisan db:seed
```
Esto crea la estructura de LTA (fundaciones, proveedores, productos, carritos, órdenes) y un usuario admin demo (`admin@example.com` / `password`).

### Assets y servidor
```bash
npm run dev    # ó npm run build para producción
php artisan serve
```

### Scripts útiles
- `php artisan migrate:fresh --seed` reinicia el esquema completo.
- `php artisan queue:work` procesa los jobs como `SyncLicenciasJob`.

### Estructura Destacada
- `app/Domain/Lta` dominio principal
- `app/Http/Controllers/Admin` panel administrativo
- `resources/views/admin` vistas y layout del panel
- `database/migrations/*_lta_*.php` migraciones específicas de negocio

Para más personalización revisa los archivos en `config/admin.php` y `config/database.php`.
