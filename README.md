# Brief Management System

Система управления брифами для производственной практики на Yii2.

## Установка и запуск

### Требования
- PHP 7.4+
- MySQL/MariaDB
- Composer

### 1. Клонирование репозитория
```bash
git clone https://github.com/Neu3BecTHo/Brief-managment.git
cd Brief-managment
```

### 2. Установка зависимостей
```bash
composer install
```

### 3. Настройка переменных окружения
1. Скопируйте файл шаблона:
```bash
cp environment.example .env
```

2. Отредактируйте `.env` файл:
```bash
# Сгенерируйте новый ключ для production
COOKIE_VALIDATION_KEY=your-secret-key-here

# Настройки базы данных
DB_HOST=localhost
DB_NAME=brief_management
DB_USER=your_username
DB_PASSWORD=your_password
```

### 4. Настройка базы данных
Создайте базу данных `brief_management` и настройте подключение в `.env` файле.

### 5. Применение миграций
```bash
php yii migrate
```

### 6. Инициализация ролей
```bash
php yii seed/init
```

### 7. Создание администратора
```bash
php yii seed/create-admin
```
- Логин: `admin`
- Пароль: `admin`

### 8. Запуск сервера
```bash
php yii serve
```
Сайт будет доступен по адресу: http://localhost:8080

> Если сайт не открывается по данному адресу, то можно добавить к команде **127.0.0.1:1234** для доступа по адресу 127.0.0.1:1234.

## Структура проекта

```
├── commands/         - Консольные команды
├── config/          - Конфигурационные файлы
├── controllers/     - Контроллеры
├── models/          - Модели данных
├── migrations/      - Миграции базы данных
├── views/           - Шаблоны представлений
├── web/             - Веб-ресурсы и точка входа
└── tests/           - Тесты
```

## Роли пользователей

- **Пользователь** - базовые права
- **Менеджер** - рассмотрение брифов
- **Администратор** - полные права

## Основные возможности

- Управление брифами
- Система вопросов и ответов
- Ролевая модель доступа


## CI/CD

- [ ] Добавление GitHub Actions workflow
- [ ] Добавление PHP CodeSniffer и PHPStan
- [ ] Автоматическое исправление кода и внесение его в репозиторий (при возможности)

## Безопасность

- **Никогда не храните** `.env` файл в Git репозитории
- **Всегда генерируйте** новый `COOKIE_VALIDATION_KEY` для production
- **Используйте** разные пароли для development и production
- **Файл `.env`** уже добавлен в `.gitignore` и не попадет в репозиторий

## Production развертывание

1. Сгенерируйте новый ключ: `openssl rand -base64 32`
2. Установите `YII_ENV=prod` и `YII_DEBUG=0` в `.env`
3. Настройте веб-сервер (Apache/Nginx) на директорию `web/`
4. Запустите миграции: `php yii migrate`
