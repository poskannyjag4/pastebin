<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доступ запрещен</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background-color: #1e1e24; color: #dcdce0; display: flex; justify-content: center; align-items: center; height: 100vh; text-align: center; }
        .container { padding: 20px; }
        h1 { font-size: 5rem; margin: 0; color: #7e57c2; }
        p { font-size: 1.2rem; margin: 10px 0 20px; }
        a { color: #7e57c2; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <h1>403</h1>
    <p>{{ $exception->getMessage() }}</p>
    <a href="{{ route('paste.home') }}">Вернуться на главную</a>
</div>
</body>
</html>
