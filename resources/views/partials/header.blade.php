<header class="app-header">
    <div class="logo">
        <a href="{{ route('paste.home') }}">MyPastebin</a>
    </div>
    <nav class="main-nav">
        <ul>
            <li><a href="{{ route('paste.home') }}">Создать</a></li>

            @auth
                <li><a href="{{ route('paste.my-pastes') }}">Мои пасты</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-button">Выйти</button>
                    </form>
                </li>
            @endauth

            @guest
                <li><a href="{{ route('login') }}">Войти</a></li>
                <li><a href="{{ route('register') }}">Регистрация</a></li>
            @endguest
        </ul>
    </nav>
</header>
