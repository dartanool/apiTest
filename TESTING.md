# Тестирование API

## Запуск тестов

### Установка зависимостей для тестирования
```bash
composer install --dev
```

### Запуск всех тестов
```bash
./vendor/bin/phpunit
```

### Запуск конкретного теста
```bash
./vendor/bin/phpunit tests/Feature/ApiTest.php
```

### Запуск тестов с покрытием кода
```bash
./vendor/bin/phpunit --coverage-html coverage
```

## Структура тестов

### Feature тесты
- `tests/Feature/ApiTest.php` - тесты всех API endpoints

### Unit тесты
- Модели, сервисы и другие компоненты можно тестировать отдельно

## Что тестируется

### Студенты
- ✅ Получение списка всех студентов
- ✅ Получение информации о конкретном студенте
- ✅ Создание студента
- ✅ Обновление студента
- ✅ Удаление студента

### Классы
- ✅ Получение списка всех классов
- ✅ Получение информации о конкретном классе
- ✅ Получение учебного плана класса
- ✅ Создание класса
- ✅ Обновление класса
- ✅ Обновление учебного плана
- ✅ Удаление класса (с откреплением студентов)

### Валидация и ошибки
- ✅ Валидация входных данных
- ✅ Обработка ошибок "ресурс не найден"
- ✅ Правильные HTTP коды ответов

## Примеры тестов

### Тест создания студента
```php
public function test_create_student(): void
{
    $class = SchoolClass::factory()->create();
    $studentData = [
        'name' => 'Тест Студент',
        'email' => 'test@example.com',
        'class_id' => $class->id
    ];

    $response = $this->postJson('/api/students', $studentData);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);

    $this->assertDatabaseHas('students', [
        'name' => 'Тест Студент',
        'email' => 'test@example.com',
        'class_id' => $class->id
    ]);
}
```

### Тест валидации
```php
public function test_validation_errors(): void
{
    $response = $this->postJson('/api/students', [
        'name' => '',
        'email' => 'invalid-email'
    ]);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors'
        ]);
}
```

## Настройка тестовой базы данных

Тесты используют SQLite в памяти для быстрого выполнения:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

## Запуск тестов в CI/CD

### GitHub Actions
```yaml
name: Tests

on: [push, pull_request]

jobs:
  tests:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'
        
    - name: Install dependencies
      run: composer install --no-progress --prefer-dist --optimize-autoloader
      
    - name: Run tests
      run: ./vendor/bin/phpunit
```

## Отладка тестов

### Вывод ответа API
```php
$response->dump();
```

### Проверка содержимого базы данных
```php
$this->assertDatabaseHas('students', [
    'name' => 'Тест Студент'
]);
```

### Проверка JSON структуры
```php
$response->assertJsonStructure([
    'success',
    'data' => [
        'id',
        'name',
        'email'
    ]
]);
```

## Покрытие кода

Для анализа покрытия кода тестами:

```bash
# Установка Xdebug (если не установлен)
sudo apt-get install php-xdebug

# Запуск тестов с покрытием
./vendor/bin/phpunit --coverage-html coverage

# Просмотр отчета
open coverage/index.html
```

## Непрерывное тестирование

Для автоматического запуска тестов при изменении файлов:

```bash
# Установка fswatch (macOS)
brew install fswatch

# Запуск тестов при изменении файлов
fswatch -o app/ tests/ | xargs -n1 -I{} ./vendor/bin/phpunit
```

