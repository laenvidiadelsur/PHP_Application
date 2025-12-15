## Admin LTA - Configuración Rápida

Proyecto Laravel enfocado en la administración de licencias de tránsito (LTA) con panel dedicado y dominio LTA modular.

### 🐳 Despliegue Local con Docker

Para desplegar el proyecto localmente usando Docker:

1. **Asegúrate de tener Docker y Docker Compose instalados**

2. **Construir y levantar los contenedores:**
   ```bash
   docker-compose up -d --build
   ```

3. **Acceder a la aplicación:**
   - La aplicación estará disponible en: `http://localhost:7777`
   - La base de datos PostgreSQL estará disponible en el puerto `5432`

4. **Ver los logs:**
   ```bash
   docker-compose logs -f laravel
   ```

5. **Detener los contenedores:**
   ```bash
   docker-compose down
   ```

6. **Detener y eliminar volúmenes (incluyendo la base de datos):**
   ```bash
   docker-compose down -v
   ```

**Nota:** El script `entrypoint.sh` se ejecutará automáticamente al iniciar el contenedor y:
- Creará el archivo `.env` si no existe (desde `.env.example`)
- Instalará las dependencias de Composer
- Generará la APP_KEY
- Ejecutará las migraciones
- Ejecutará los seeders
- Compilará los assets de Vite (si es necesario)

**Servicios Docker:**
- `marketplace-laravel`: Contenedor PHP-FPM con Laravel
- `marketplace`: Contenedor Nginx (puerto 7777)
- `marketplace-db`: Contenedor PostgreSQL (puerto 5432)

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
