FROM php:8.4-alpine

# Установка системных зависимостей
RUN apk update && apk add --no-cache \
    bash \
    git \
    nano \
    htop \
    fish \
    libpq-dev \
    postgresql-client \
    zip \
    wget \
    ffmpeg \
    supervisor \
    && rm -rf /var/cache/apk/*

# Добавление и настройка установщика PHP расширений
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Установка PHP расширений
RUN install-php-extensions \
    pdo_pgsql \
    pgsql \
    pcntl \
    swoole \
    opcache \
    redis \
    @composer

# Копирование конфигурации PHP
COPY --chown=laravel:laravel php.ini /usr/local/etc/php/conf.d/swoole.ini

# Создание пользователя и директорий
RUN addgroup -g 1000 -S laravel && \
    adduser -u 1000 -S laravel -G laravel && \
    mkdir -p /var/www /var/log/supervisor && \
    chown -R laravel:laravel /var/www /var/log/supervisor

WORKDIR /var/www

# Копирование composer файлов
COPY --chown=laravel:laravel composer.json composer.lock ./

# Установка зависимостей
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Копирование остального кода
COPY --chown=laravel:laravel . .

# Настройка прав доступа
RUN chown -R laravel:laravel /var/www && \
    chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Копирование конфигурации supervisor
COPY --chown=laravel:laravel ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Настройка health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=30s --retries=3 \
    CMD curl -f http://localhost:8000/health || exit 1

# Переключение на non-root пользователя
USER laravel

# Экспорт портов
EXPOSE 8000 9001

# graceful shutdown script
COPY --chown=laravel:laravel docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
