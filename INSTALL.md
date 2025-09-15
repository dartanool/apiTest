# Инструкция по установке и запуску

## Требования

- PHP 8.1 или выше
- Composer
- MySQL 5.7+ или PostgreSQL 9.6+
- Веб-сервер (Apache/Nginx) или встроенный сервер PHP

## Установка

1. **Клонируйте проект и установите зависимости:**
```bash
cd /home/aleksandra/projects/api
composer install
```

2. **Создайте файл конфигурации:**
```bash
cp .env.example .env
```

3. **Сгенерируйте ключ приложения:**
```bash
php artisan key:generate
```

4. **Настройте базу данных в файле `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Создайте базу данных:**
```sql
CREATE DATABASE your_database_name;
```

6. **Запустите миграции:**
```bash
php artisan migrate
```

7. **Заполните базу тестовыми данными:**
```bash
php artisan db:seed
```

## Запуск

### Встроенный сервер PHP (для разработки)
```bash
php artisan serve
```
Приложение будет доступно по адресу: http://localhost:8000

### Настройка веб-сервера

#### Apache
Убедитесь, что DocumentRoot указывает на папку `public/`:
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /home/aleksandra/projects/api/public
    
    <Directory /home/aleksandra/projects/api/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /home/aleksandra/projects/api/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Тестирование API

После запуска приложения вы можете протестировать API endpoints:

### Примеры запросов:

1. **Получить список студентов:**
```bash
curl -X GET http://localhost:8000/api/students
```

2. **Создать студента:**
```bash
curl -X POST http://localhost:8000/api/students \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Иван Иванов",
    "email": "ivan@example.com",
    "class_id": 1
  }'
```

3. **Получить список классов:**
```bash
curl -X GET http://localhost:8000/api/classes
```

4. **Создать класс:**
```bash
curl -X POST http://localhost:8000/api/classes \
  -H "Content-Type: application/json" \
  -d '{
    "name": "10-А класс"
  }'
```

## Структура проекта

```
api/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/     # API контроллеры
│   │   ├── Middleware/          # Middleware
│   │   └── Requests/            # Request классы для валидации
│   ├── Models/                  # Eloquent модели
│   ├── Services/                # Сервисы с бизнес-логикой
│   └── Providers/               # Service providers
├── database/
│   ├── factories/               # Фабрики для тестовых данных
│   ├── migrations/              # Миграции базы данных
│   └── seeders/                 # Сидеры для заполнения БД
├── routes/
│   └── api.php                  # API маршруты
└── public/                      # Публичная папка
```

## Возможные проблемы

1. **Ошибка "Class not found":**
   - Выполните `composer dump-autoload`

2. **Ошибка подключения к БД:**
   - Проверьте настройки в `.env`
   - Убедитесь, что база данных создана

3. **Ошибка прав доступа:**
   - Установите правильные права на папки:
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

