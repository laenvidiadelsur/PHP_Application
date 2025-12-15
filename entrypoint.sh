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
chmod -R 777 storage bootstrap/cache

echo "📁 Creando directorio de productos si no existe..."
mkdir -p storage/app/public/products

echo "🔗 Creando enlace simbólico de storage..."
php artisan storage:link || true

echo "🔐 Asegurando permisos de lectura para Nginx..."
# Asegurar que Nginx pueda leer los archivos: 755 para directorios, 644 para archivos
find storage/app/public -type d -exec chmod 755 {} \;
find storage/app/public -type f -exec chmod 644 {} \;

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

