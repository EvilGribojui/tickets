# Используем официальный образ PHP с поддержкой FPM
FROM php:8.3-fpm

# Устанавливаем зависимости для сборки PostgreSQL расширений
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем код проекта в контейнер
COPY . .

# Устанавливаем права доступа для веб-сервера
RUN chown -R www-data:www-data /var/www/html
