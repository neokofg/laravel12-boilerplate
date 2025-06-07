#!/bin/bash
set -e

cleanup() {
    echo "Получен сигнал завершения, останавливаем процессы..."
    supervisorctl -c /etc/supervisor/conf.d/supervisord.conf shutdown
    exit 0
}

trap cleanup SIGTERM SIGINT

if [ -n "$DB_HOST" ]; then
    echo "Ожидание готовности базы данных..."
    timeout=60
    while ! pg_isready -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "$DB_USERNAME" > /dev/null 2>&1; do
        timeout=$((timeout - 1))
        if [ $timeout -eq 0 ]; then
            echo "Время ожидания базы данных истекло"
            exit 1
        fi
        sleep 1
    done
    echo "База данных готова"
fi

if [ "$APP_ENV" = "production" ]; then
    echo "Выполнение production команд..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
fi

php artisan storage:link --force

# Подставляем переменные окружения в supervisord.conf
if [ -n "$SUPERVISOR_USERNAME" ] && [ -n "$SUPERVISOR_PASSWORD" ]; then
    echo "Настройка Supervisor аутентификации..."
    sed -i "s/username=supervisor/username=$SUPERVISOR_USERNAME/g" /etc/supervisor/conf.d/supervisord.conf
    sed -i "s/password=changeme123/password=$SUPERVISOR_PASSWORD/g" /etc/supervisor/conf.d/supervisord.conf
fi

echo "Запуск Supervisor..."
exec "$@"
