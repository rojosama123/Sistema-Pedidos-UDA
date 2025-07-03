# Usa la imagen base de PHP con FPM
FROM php:8.2-fpm

# TRIGGER DEPLOY (Railway hook)
RUN echo "trigger migrate"

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    curl \
    zip \
    unzip \
    git \
    nodejs \
    npm \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    default-mysql-client

# Instala extensiones necesarias de PHP
RUN docker-php-ext-install bcmath gd zip pdo_mysql

# Copia Composer desde imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establece directorio de trabajo
WORKDIR /var/www

# Copia archivos del proyecto al contenedor
COPY . .

# Instala dependencias de Composer y compila assets con Vite
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build

# Expone el puerto que Railway usará
EXPOSE 8080

# Comandos al iniciar el contenedor
CMD php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear \
 && php artisan migrate --force \
 && php artisan db:seed --force \
 && php artisan storage:link \
 && php artisan serve --host=0.0.0.0 --port=8080
