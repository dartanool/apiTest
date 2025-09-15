# Примеры использования API

## Студенты

### 1. Получить список всех студентов
```bash
curl -X GET http://localhost:8000/api/students
```

**Ответ:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Иван Иванов",
            "email": "ivan@example.com",
            "class_id": 1,
            "class": {
                "id": 1,
                "name": "10-А класс"
            }
        }
    ]
}
```

### 2. Получить информацию о конкретном студенте
```bash
curl -X GET http://localhost:8000/api/students/1
```

**Ответ:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Иван Иванов",
        "email": "ivan@example.com",
        "class_id": 1,
        "class": {
            "id": 1,
            "name": "10-А класс"
        },
        "attended_lectures": [
            {
                "id": 1,
                "topic": "Математика",
                "description": "Основы алгебры",
                "pivot": {
                    "attended_at": "2024-01-15T10:00:00.000000Z"
                }
            }
        ]
    }
}
```

### 3. Создать студента
```bash
curl -X POST http://localhost:8000/api/students \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Петр Петров",
    "email": "petr@example.com",
    "class_id": 1
  }'
```

**Ответ:**
```json
{
    "success": true,
    "message": "Студент успешно создан.",
    "data": {
        "id": 2,
        "name": "Петр Петров",
        "email": "petr@example.com",
        "class_id": 1,
        "class": {
            "id": 1,
            "name": "10-А класс"
        }
    }
}
```

### 4. Обновить студента
```bash
curl -X PUT http://localhost:8000/api/students/2 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Петр Сидоров",
    "class_id": 2
  }'
```

**Ответ:**
```json
{
    "success": true,
    "message": "Студент успешно обновлен.",
    "data": {
        "id": 2,
        "name": "Петр Сидоров",
        "email": "petr@example.com",
        "class_id": 2,
        "class": {
            "id": 2,
            "name": "11-А класс"
        }
    }
}
```

### 5. Удалить студента
```bash
curl -X DELETE http://localhost:8000/api/students/2
```

**Ответ:**
```json
{
    "success": true,
    "message": "Студент успешно удален."
}
```

## Классы

### 6. Получить список всех классов
```bash
curl -X GET http://localhost:8000/api/classes
```

**Ответ:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "10-А класс",
            "students": [
                {
                    "id": 1,
                    "name": "Иван Иванов",
                    "email": "ivan@example.com",
                    "class_id": 1
                }
            ]
        }
    ]
}
```

### 7. Получить информацию о конкретном классе
```bash
curl -X GET http://localhost:8000/api/classes/1
```

**Ответ:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "10-А класс",
        "students": [
            {
                "id": 1,
                "name": "Иван Иванов",
                "email": "ivan@example.com",
                "class_id": 1
            }
        ]
    }
}
```

### 8. Получить учебный план для конкретного класса
```bash
curl -X GET http://localhost:8000/api/classes/1/curriculum
```

**Ответ:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "10-А класс",
        "lectures": [
            {
                "id": 1,
                "topic": "Математика",
                "description": "Основы алгебры",
                "pivot": {
                    "order": 1
                }
            },
            {
                "id": 2,
                "topic": "Физика",
                "description": "Механика",
                "pivot": {
                    "order": 2
                }
            }
        ]
    }
}
```

### 9. Создать/обновить учебный план для конкретного класса
```bash
curl -X PUT http://localhost:8000/api/classes/1/curriculum \
  -H "Content-Type: application/json" \
  -d '{
    "lectures": [
        {
            "lecture_id": 1,
            "order": 1
        },
        {
            "lecture_id": 2,
            "order": 2
        },
        {
            "lecture_id": 3,
            "order": 3
        }
    ]
  }'
```

**Ответ:**
```json
{
    "success": true,
    "message": "Учебный план успешно обновлен.",
    "data": {
        "id": 1,
        "name": "10-А класс",
        "lectures": [
            {
                "id": 1,
                "topic": "Математика",
                "description": "Основы алгебры",
                "pivot": {
                    "order": 1
                }
            },
            {
                "id": 2,
                "topic": "Физика",
                "description": "Механика",
                "pivot": {
                    "order": 2
                }
            },
            {
                "id": 3,
                "topic": "Химия",
                "description": "Органическая химия",
                "pivot": {
                    "order": 3
                }
            }
        ]
    }
}
```

### 10. Создать класс
```bash
curl -X POST http://localhost:8000/api/classes \
  -H "Content-Type: application/json" \
  -d '{
    "name": "9-Б класс"
  }'
```

**Ответ:**
```json
{
    "success": true,
    "message": "Класс успешно создан.",
    "data": {
        "id": 3,
        "name": "9-Б класс"
    }
}
```

### 11. Обновить класс
```bash
curl -X PUT http://localhost:8000/api/classes/3 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "10-Б класс"
  }'
```

**Ответ:**
```json
{
    "success": true,
    "message": "Класс успешно обновлен.",
    "data": {
        "id": 3,
        "name": "10-Б класс"
    }
}
```

### 12. Удалить класс
```bash
curl -X DELETE http://localhost:8000/api/classes/3
```

**Ответ:**
```json
{
    "success": true,
    "message": "Класс успешно удален."
}
```

## Обработка ошибок

### Валидация данных
```bash
curl -X POST http://localhost:8000/api/students \
  -H "Content-Type: application/json" \
  -d '{
    "name": "",
    "email": "invalid-email"
  }'
```

**Ответ:**
```json
{
    "message": "The name field is required. (and 1 more error)",
    "errors": {
        "name": [
            "Имя студента обязательно для заполнения."
        ],
        "email": [
            "Email должен быть действительным адресом электронной почты."
        ]
    }
}
```

### Ресурс не найден
```bash
curl -X GET http://localhost:8000/api/students/999
```

**Ответ:**
```json
{
    "success": false,
    "message": "Студент не найден."
}
```

## HTTP коды ответов

- `200` - Успешный запрос
- `201` - Ресурс успешно создан
- `400` - Ошибка валидации
- `404` - Ресурс не найден
- `422` - Ошибка валидации данных
- `500` - Внутренняя ошибка сервера

