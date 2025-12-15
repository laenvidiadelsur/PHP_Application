#!/bin/bash

# No salir si algún comando falla (para permitir que PHP-FPM se inicie incluso si hay errores menores)
set +e

# Crear .env si no existe
if [ ! -f .env ]; then
    echo "📄 No existe .env — creando desde .env.example"
    cp .env.example .env
else
    echo "✔️ Archivo .env ya existe — no se copia"
fi

echo "📦 Instalando dependencias de Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "🔑 Generando APP_KEY (si no existe)..."
php artisan key:generate --force || true

echo "⚙️ Aplicando permisos..."
# Dar propiedad a www-data (Nginx/PHP-FPM) para evitar problemas de escritura
chown -R www-data:www-data storage bootstrap/cache
# Permisos de escritura para dueño/grupo; lectura para otros
chmod -R 775 storage bootstrap/cache
# Asegurar permisos específicos en logs y framework (incluye vistas compiladas)
find storage/logs -type d -exec chmod 775 {} \; 2>/dev/null
find storage/logs -type f -exec chmod 664 {} \; 2>/dev/null
find storage/framework -type d -exec chmod 775 {} \; 2>/dev/null
find storage/framework -type f -exec chmod 664 {} \; 2>/dev/null

echo "📁 Creando directorios públicos si no existen..."
mkdir -p storage/app/public/products
mkdir -p storage/app/public/foundations
mkdir -p storage/app/public/suppliers

echo "🔗 Creando enlace simbólico de storage..."
php artisan storage:link || true

echo "🔐 Asegurando permisos de escritura/lectura en storage público..."
# Directorios 775 (lectura/ejecución para todos, escritura para dueño/grupo)
find storage/app/public -type d -exec chmod 775 {} \;
# Archivos 664 (lectura para todos, escritura dueño/grupo)
find storage/app/public -type f -exec chmod 664 {} \;

echo "�️  Verificando esquema '$DB_SCHEMA'..."
php database/create_schema.php

echo "�🗄️ Ejecutando migraciones..."
php artisan migrate --force || true

echo "🌱 Ejecutando Seeder..."
php artisan db:seed --force || echo "⚠️ Seeder falló o no hay seeders, continuando..."
if [ ! -f public/build/manifest.json ]; then
    echo "🎨 Compilando Vite (npm run build)..."

    if command -v npm >/dev/null 2>&1; then
        npm install
        npm run build
    else
        echo "❌ npm NO está instalado dentro del contenedor."
            echo "➡ Debes compilar Vite en tu host y copiar public/build"
    fi
else
    echo "✔️ Vite build ya existe — no se compila"
fi
echo "🚀 Iniciando PHP-FPM..."
exec php-fpm

