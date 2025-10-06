<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyPastebin')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/css/github-dark.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="app-container">

    @include('partials.header')

    <div class="main-content-area">
        <main class="content-column">
            @yield('content')
        </main>

        <aside class="sidebar-column">
            @include('partials.sidebar')
        </aside>
    </div>

    @include('partials.footer')
</div>

@stack('scripts')
</body>
</html>
