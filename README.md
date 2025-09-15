# School Management API

RESTful API для управления школьными классами, студентами и лекциями, построенный на Laravel 10.

## 🚀 Возможности

- **Управление студентами**: создание, просмотр, обновление и удаление студентов
- **Управление классами**: создание и управление школьными классами
- **Управление лекциями**: создание и управление лекциями
- **Учебные планы**: настройка учебных планов для классов
- **Посещаемость**: отслеживание посещаемости студентов на лекциях
- **Валидация данных**: полная валидация входных данных
- **Тестирование**: полное покрытие тестами

## 📋 Требования

- PHP 8.1 или выше
- Composer
- SQLite (по умолчанию) или MySQL/PostgreSQL
- Laravel 10

## 🛠 Установка

1. **Клонирование репозитория**
   ```bash
   git clone <repository-url>
   cd api
   ```

2. **Установка зависимостей**
   ```bash
   composer install
   ```

3. **Настройка окружения**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Настройка базы данных**
   ```bash
   # Для SQLite (по умолчанию)
   touch database/database.sqlite
   
   # Или настройте .env для MySQL/PostgreSQL
   ```

5. **Запуск миграций**
   ```bash
   php artisan migrate
   ```

6. **Заполнение тестовыми данными (опционально)**
   ```bash
   php artisan db:seed
   ```

7. **Запуск сервера**
   ```bash
   php artisan serve
   ```

API будет доступен по адресу: `http://localhost:8000/api`

## 📚 API Endpoints

### Студенты
- `GET /api/students` - Получить список всех студентов
- `GET /api/students/{id}` - Получить информацию о студенте
- `POST /api/students` - Создать студента
- `PUT /api/students/{id}` - Обновить студента
- `DELETE /api/students/{id}` - Удалить студента

### Классы
- `GET /api/classes` - Получить список всех классов
- `GET /api/classes/{id}` - Получить информацию о классе
- `GET /api/classes/{id}/curriculum` - Получить учебный план класса
- `POST /api/classes` - Создать класс
- `PUT /api/classes/{id}` - Обновить класс
- `PUT /api/classes/{id}/curriculum` - Обновить учебный план
- `DELETE /api/classes/{id}` - Удалить класс

### Лекции
- `GET /api/lectures` - Получить список всех лекций
- `GET /api/lectures/{id}` - Получить информацию о лекции
- `POST /api/lectures` - Создать лекцию
- `PUT /api/lectures/{id}` - Обновить лекцию
- `DELETE /api/lectures/{id}` - Удалить лекцию

## 📖 Примеры использования

Подробные примеры использования API с curl командами и примерами ответов доступны в файле [API_EXAMPLES.md](API_EXAMPLES.md).

### Быстрый старт

**Создание класса:**
```bash
curl -X POST http://localhost:8000/api/classes \
  -H "Content-Type: application/json" \
  -d '{"name": "10-А класс"}'
```

**Создание студента:**
```bash
curl -X POST http://localhost:8000/api/students \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Иван Иванов",
    "email": "ivan@example.com",
    "class_id": 1
  }'
```

**Создание лекции:**
```bash
curl -X POST http://localhost:8000/api/lectures \
  -H "Content-Type: application/json" \
  -d '{
    "topic": "Математика",
    "description": "Основы алгебры"
  }'
```

## 🧪 Тестирование

### Запуск тестов
```bash
# Все тесты
./vendor/bin/phpunit

# Конкретный тест
./vendor/bin/phpunit tests/Feature/ApiTest.php

# С покрытием кода
./vendor/bin/phpunit --coverage-html coverage
```

Подробная информация о тестировании доступна в файле [TESTING.md](TESTING.md).

## 🏗 Архитектура

### Модели
- **Student** - Студенты с привязкой к классам и посещаемостью лекций
- **SchoolClass** - Школьные классы с учебными планами
- **Lecture** - Лекции с возможностью привязки к классам

### Сервисы
- **StudentService** - Бизнес-логика для работы со студентами
- **ClassService** - Бизнес-логика для работы с классами
- **LectureService** - Бизнес-логика для работы с лекциями

### Контроллеры
- **StudentController** - API endpoints для студентов
- **ClassController** - API endpoints для классов
- **LectureController** - API endpoints для лекций

## 📊 База данных

### Основные таблицы
- `students` - Студенты
- `classes` - Классы
- `lectures` - Лекции
- `class_lectures` - Связь классов и лекций (учебные планы)
- `student_lectures` - Посещаемость студентов на лекциях

### Связи
- Студент принадлежит одному классу
- Класс может иметь много студентов
- Класс может иметь много лекций (учебный план)
- Лекция может принадлежать многим классам
- Студент может посещать много лекций

## 🔧 Конфигурация

### Переменные окружения
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
APP_URL=http://localhost:8000
```

### Валидация
Все входные данные проходят валидацию через Form Request классы:
- `StoreStudentRequest` / `UpdateStudentRequest`
- `StoreClassRequest` / `UpdateClassRequest`
- `StoreLectureRequest` / `UpdateLectureRequest`

## 📝 Ответы API

### Успешный ответ
```json
{
  "success": true,
  "data": { ... },
  "message": "Операция выполнена успешно"
}
```

### Ошибка валидации
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field": ["Сообщение об ошибке"]
  }
}
```

### Ресурс не найден
```json
{
  "success": false,
  "message": "Ресурс не найден"
}
```

## 🚀 Развертывание

### Production
1. Настройте веб-сервер (Apache/Nginx)
2. Установите PHP 8.1+
3. Настройте базу данных
4. Выполните миграции
5. Настройте SSL сертификат

### Docker (опционально)
```dockerfile
FROM php:8.1-fpm
# ... конфигурация Docker
```

## 🤝 Вклад в проект

1. Форкните репозиторий
2. Создайте ветку для новой функции
3. Внесите изменения
4. Добавьте тесты
5. Создайте Pull Request

## 📄 Лицензия

MIT License

## 📞 Поддержка

Для вопросов и предложений создайте Issue в репозитории.

---

**Postman Collection**: [Laravel_API_Collection.postman_collection.json](Laravel_API_Collection.postman_collection.json)
