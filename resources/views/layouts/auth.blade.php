<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyPastebin')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
{{-- Этот контейнер будет просто центрировать контент по горизонтали --}}
<div class="guest-container">
    <div class="logo" style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('paste.home') }}" style="font-size: 28px; font-weight: bold; text-decoration: none; color: var(--primary-color);">MyPastebin</a>
    </div>
    <main class="guest-content">
        @yield('content') {{-- Сюда будет вставляться форма входа или регистрации --}}
    </main>
</div>

@stack('scripts')
</body>
</html>
