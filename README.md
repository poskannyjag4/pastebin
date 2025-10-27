# Pastebin


# Установка
1. Склонировать репозиторий
2. создать файл .env по шаблону в .env.example
3. запустить `docker-compose up -d --build`
4. в контейнере php-fpm ввести команды `php artisan key:generate` и `php artisan migrate`

# Возможности Сайта
### /
Главная страница позволяет создать новую пасту
### /p/{hashid}
Просмотр конкретной пасты
### /p/s/{uuid}
Просмотр пасты доступной только по ссылке
### /login
Аутентификация по логину и паролю и через github
### /register
Регистрация по логину и паролю и через github
### /my-pastes
Все пасты пользователя
### /token
Получение api токена
## Администрирование
Сначала необходимо в конейнере php-fpm ввести команду `php artisan orchid:admin {email} {password}` дял создания нового пользователя с максимальными правами

### /admin/login
аутентификация в панель администратора с помощью ранее созданного пользователя
### /admin/pastes
Спиоск всех паст с возиожностью их удалять
### /admin/user-list
Спиоск всех пользователей с возможностью бана
### /admin/compaints
Список всех жалоб

## API
Для того чтобы пользоваться API требуется API-токен, который можно получть по пути `/token`

### POST /pastes
Добавление новой пасты
Пример:
```json
{
    "title": "title",

    "text": "text1",
    "visibility": "public",
    "programming_language": "plaintext",
    "expires_at": 3123123
}
```
Пример ответа:
```json
{
    "data": {
        "paste": {
            "id": 3,
            "title": "title",
            "text": "text1",
            "expires_at": "2025-12-02 08:21:18",
            "visibility": "public",
            "programming_language": "plaintext",
            "user_id": 3,
            "created_at": "2025-10-27T04:49:15.000000Z",
            "updated_at": "2025-10-27T04:49:15.000000Z",
            "token": null
        },
        "identifier": "7nVmw2kNpb"
    }
}
```
### GET /pastes/latest-public
Список последних 10 публичных паст
Пример ответа:
```json
{
    "data": [
        {
            "paste": {
                "id": 3,
                "title": "title",
                "text": "text1",
                "expires_at": "2025-12-02 08:21:18",
                "visibility": "public",
                "programming_language": "plaintext",
                "user_id": 3,
                "created_at": "2025-10-27T04:49:15.000000Z",
                "updated_at": "2025-10-27T04:49:15.000000Z",
                "token": null
            },
            "identifier": "7nVmw2kNpb"
        },
        {
            "paste": {
                "id": 1,
                "title": "title",
                "text": "text1",
                "expires_at": "2025-10-27 08:19:18",
                "visibility": "public",
                "programming_language": "plaintext",
                "user_id": 3,
                "created_at": "2025-10-27T04:45:21.000000Z",
                "updated_at": "2025-10-27T04:45:21.000000Z",
                "token": null
            },
            "identifier": "qzxkXG8ZWa"
        }
    ]
}
```
### GET /pastes/latest-user
Список 10 последних паст пользователя
Пример ответа:
```json
{
    "data": [
        {
            "paste": {
                "id": 3,
                "title": "title",
                "text": "text1",
                "expires_at": "2025-12-02 08:21:18",
                "visibility": "public",
                "programming_language": "plaintext",
                "user_id": 3,
                "created_at": "2025-10-27T04:49:15.000000Z",
                "updated_at": "2025-10-27T04:49:15.000000Z",
                "token": null
            },
            "identifier": "7nVmw2kNpb"
        },
        {
            "paste": {
                "id": 2,
                "title": "title",
                "text": "text1",
                "expires_at": "2025-12-02 08:20:50",
                "visibility": "unlisted",
                "programming_language": "plaintext",
                "user_id": 3,
                "created_at": "2025-10-27T04:48:47.000000Z",
                "updated_at": "2025-10-27T04:48:47.000000Z",
                "token": "c56f3970-ce68-4134-a25e-94098c853167"
            },
            "identifier": "jGzmdv8vpK"
        },
        {
            "paste": {
                "id": 1,
                "title": "title",
                "text": "text1",
                "expires_at": "2025-10-27 08:19:18",
                "visibility": "public",
                "programming_language": "plaintext",
                "user_id": 3,
                "created_at": "2025-10-27T04:45:21.000000Z",
                "updated_at": "2025-10-27T04:45:21.000000Z",
                "token": null
            },
            "identifier": "qzxkXG8ZWa"
        }
    ]
}
```

### GET /pastes/{hashid} И GET /pastes/s/{uuid}
Просмотр конкретной пасты и конкретной пасты, доступной только по ссылке
Под uuid понимается поле token пасты
Пример ответа:
```json
{
    "data": {
        "paste": {
            "id": 3,
            "title": "title",
            "text": "text1",
            "expires_at": "2025-12-02 08:21:18",
            "visibility": "public",
            "programming_language": "plaintext",
            "user_id": 3,
            "created_at": "2025-10-27T04:49:15.000000Z",
            "updated_at": "2025-10-27T04:49:15.000000Z",
            "token": null
        },
        "identifier": "7nVmw2kNpb"
    }
}
```

### POST /pastes/{hashId}/complaint И POST /pastes/s/{uuid}/complaint
Добавление жалобы на пасту
Пример запроса:
```json
{
    "details": "asdsadasd"
}
```

Пример ответа:
```json
{
    "data": {
        "details": "asdsadasd",
        "user": {
            "id": 3,
            "name": "me",
            "email": "nifed5000@gmail.com",
            "email_verified_at": null,
            "created_at": "2025-10-27T04:20:51.000000Z",
            "updated_at": "2025-10-27T04:20:51.000000Z",
            "is_banned": false
        }
    }
}
```
