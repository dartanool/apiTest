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
