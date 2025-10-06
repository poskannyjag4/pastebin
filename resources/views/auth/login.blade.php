@extends('layouts.auth')

@section('title', 'Вход в аккаунт')

@section('content')
    <div class="auth-form-container">
        <h1>Вход в аккаунт</h1>

        @if (session('status'))
            <div class="auth-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" class="block mt-1 w-full @error('email') is-invalid @enderror" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" class="block mt-1 w-full @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" />
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Запомнить меня</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        Забыли пароль?
                    </a>
                @endif


            </div>
            <div class="auth-actions">
                <a href="{{ route('register') }}" class="secondary-link">
                    Нет аккаунта? Создать
                </a>

                <button type="submit" class="create-button">
                    Войти
                </button>
            </div>
        </form>
        <div class="social-login-container">
            <div class="separator">Или войдите с помощью</div>
            <div class="social-buttons">
                <a href="{{ route('socialite.redirect', 'github') }}" class="social-login-btn github-btn">
                    <i class="fab fa-github"></i> GitHub
                </a>
                <a href="{{ route('socialite.redirect', 'google') }}" class="social-login-btn google-btn">
                    <i class="fab fa-google"></i> Google
                </a>
            </div>
        </div>
    </div>
@endsection
