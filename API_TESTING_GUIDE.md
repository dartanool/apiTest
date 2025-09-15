# Руководство по тестированию API

## Запуск сервера

```bash
php artisan serve
```

Сервер будет доступен по адресу: http://localhost:8000

## Тестирование API

### 1. Студенты

#### Получить список всех студентов
```bash
curl -s http://localhost:8000/api/students | jq .
```

#### Получить информацию о конкретном студенте
```bash
curl -s http://localhost:8000/api/students/1 | jq .
```

#### Создать студента
```bash
curl -X POST -H "Content-Type: application/json" \
  -d '{"name":"Новый Студент","email":"new@example.com","class_id":1}' \
  http://localhost:8000/api/students | jq .
```

#### Обновить студента
```bash
curl -X PUT -H "Content-Type: application/json" \
  -d '{"name":"Обновленное Имя","class_id":2}' \
  http://localhost:8000/api/students/1 | jq .
```

#### Удалить студента
```bash
curl -X DELETE http://localhost:8000/api/students/1 | jq .
```

### 2. Классы

#### Получить список всех классов
```bash
curl -s http://localhost:8000/api/classes | jq .
```

#### Получить информацию о конкретном классе
```bash
curl -s http://localhost:8000/api/classes/1 | jq .
```

#### Получить учебный план класса
```bash
curl -s http://localhost:8000/api/classes/1/curriculum | jq .
```

#### Создать класс
```bash
curl -X POST -H "Content-Type: application/json" \
  -d '{"name":"Новый Класс"}' \
  http://localhost:8000/api/classes | jq .
```

#### Обновить класс
```bash
curl -X PUT -H "Content-Type: application/json" \
  -d '{"name":"Обновленное Название"}' \
  http://localhost:8000/api/classes/1 | jq .
```

#### Удалить класс
```bash
curl -X DELETE http://localhost:8000/api/classes/1 | jq .
```

#### Обновить учебный план
```bash
curl -X PUT -H "Content-Type: application/json" \
  -d '{"lectures":[{"lecture_id":1,"order":1},{"lecture_id":2,"order":2}]}' \
  http://localhost:8000/api/classes/1/curriculum | jq .
```

## Примеры ответов

### Успешный ответ
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Имя Студента",
    "email": "email@example.com",
    "class_id": 1,
    "created_at": "2025-09-08T13:41:35.000000Z",
    "updated_at": "2025-09-08T13:41:35.000000Z",
    "class": {
      "id": 1,
      "name": "Название Класса",
      "created_at": "2025-09-08T13:41:35.000000Z",
      "updated_at": "2025-09-08T13:41:35.000000Z"
    }
  }
}
```

### Ответ с ошибкой валидации
```json
{
  "success": false,
  "message": "Ошибка валидации",
  "errors": {
    "name": ["Поле имя обязательно для заполнения."],
    "email": ["Поле email должно содержать действительный адрес электронной почты."]
  }
}
```

## Статус коды

- `200` - Успешный запрос
- `201` - Ресурс создан
- `400` - Ошибка валидации
- `404` - Ресурс не найден
- `500` - Внутренняя ошибка сервера

## Примечания

- Все ответы возвращаются в формате JSON
- Для POST и PUT запросов необходимо указывать заголовок `Content-Type: application/json`
- Валидация данных выполняется автоматически
- При удалении студента он открепляется от класса, но не удаляется из системы
- При удалении класса все студенты открепляются от него

