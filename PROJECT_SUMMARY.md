# Laravel API - Управление студентами, классами и лекциями

## Краткое описание

Полнофункциональное REST API на Laravel для управления образовательной системой с тремя основными сущностями: студенты, классы и лекции.

## Реализованные требования

### ✅ Технические требования
- **Строгая типизация** - все методы и свойства типизированы
- **Разделение ответственности** - контроллеры только обрабатывают HTTP, бизнес-логика в сервисах
- **Валидация данных** - через Request классы
- **JSON ответы** - все endpoints возвращают JSON
- **Dependency Injection** - используется во всех контроллерах и сервисах
- **Оптимизированные запросы** - жадная загрузка связанных данных

### ✅ API Endpoints (12 методов)

#### Студенты (5 методов)
1. `GET /api/students` - список всех студентов
2. `GET /api/students/{id}` - информация о студенте + класс + лекции
3. `POST /api/students` - создание студента
4. `PUT /api/students/{id}` - обновление студента
5. `DELETE /api/students/{id}` - удаление студента

#### Классы (7 методов)
6. `GET /api/classes` - список всех классов
7. `GET /api/classes/{id}` - информация о классе + студенты
8. `GET /api/classes/{id}/curriculum` - учебный план класса
9. `PUT /api/classes/{id}/curriculum` - обновление учебного плана
10. `POST /api/classes` - создание класса
11. `PUT /api/classes/{id}` - обновление класса
12. `DELETE /api/classes/{id}` - удаление класса (студенты открепляются)

## Архитектура проекта

```
app/
├── Http/
│   ├── Controllers/Api/     # API контроллеры
│   ├── Middleware/          # Middleware
│   └── Requests/            # Валидация запросов
├── Models/                  # Eloquent модели
└── Services/                # Бизнес-логика

database/
├── factories/               # Фабрики для тестовых данных
├── migrations/              # Миграции БД
└── seeders/                 # Заполнение БД

tests/
└── Feature/                 # API тесты
```

## База данных

### Таблицы
- `students` - студенты (id, name, email, class_id)
- `classes` - классы (id, name)
- `lectures` - лекции (id, topic, description)
- `class_lectures` - учебный план (class_id, lecture_id, order)
- `student_lectures` - посещения (student_id, lecture_id, attended_at)

### Связи
- Студент → Класс (один ко многим)
- Класс → Лекции (многие ко многим с порядком)
- Студент → Лекции (многие ко многим с датой посещения)

## Особенности реализации

### Модели
- `Student` - с отношениями к классу и лекциям
- `SchoolClass` - с отношениями к студентам и лекциям
- `Lecture` - с отношениями к классам и студентам

### Сервисы
- `StudentService` - вся бизнес-логика работы со студентами
- `ClassService` - вся бизнес-логика работы с классами

### Валидация
- `StoreStudentRequest` - валидация создания студента
- `UpdateStudentRequest` - валидация обновления студента
- `StoreClassRequest` - валидация создания класса
- `UpdateClassRequest` - валидация обновления класса
- `UpdateCurriculumRequest` - валидация учебного плана

### Тестирование
- Полное покрытие всех API endpoints
- Тесты валидации и обработки ошибок
- Использование фабрик для тестовых данных

## Файлы документации

- `README.md` - основная документация
- `INSTALL.md` - инструкция по установке
- `API_EXAMPLES.md` - примеры использования API
- `TESTING.md` - инструкция по тестированию
- `PROJECT_SUMMARY.md` - краткое описание проекта

## Быстрый старт

```bash
# Установка
composer install
cp .env.example .env
php artisan key:generate

# Настройка БД в .env
php artisan migrate
php artisan db:seed

# Запуск
php artisan serve
```

## Тестирование

```bash
# Запуск тестов
./vendor/bin/phpunit

# Запуск с покрытием
./vendor/bin/phpunit --coverage-html coverage
```

## Примеры запросов

```bash
# Создать студента
curl -X POST http://localhost:8000/api/students \
  -H "Content-Type: application/json" \
  -d '{"name": "Иван Иванов", "email": "ivan@example.com", "class_id": 1}'

# Получить список студентов
curl -X GET http://localhost:8000/api/students

# Создать класс
curl -X POST http://localhost:8000/api/classes \
  -H "Content-Type: application/json" \
  -d '{"name": "10-А класс"}'
```

Проект полностью готов к использованию и соответствует всем техническим требованиям задания.

