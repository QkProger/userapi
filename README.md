## Установка и тестирование

1. Клонируйте репозиторий:
    git clone https://github.com/QkProger/userapi.git

2. Перейдите в папку проекта

3. Установите зависимости:
    composer install,

4. Создайте файл `.env` и настройте переменные окружения:
    cp .env.example .env

5. Запустите миграции:
    php artisan migrate

6. Запустите локальный сервер:
    php artisan serve

7. Откройте в браузере [http://127.0.0.1:8000/].

8. Перейдите в Swagger [http://127.0.0.1:8000/api/documentation].
