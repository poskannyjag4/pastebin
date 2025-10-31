@extends('layouts.auth')

@section('title', 'Регистрация')

@section('content')
    <div class="auth-form-container">
        <h1>Регистрация</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Имя</label>
                <input id="name" class="block mt-1 w-full @error('name') is-invalid @enderror" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" class="block mt-1 w-full @error('email') is-invalid @enderror" type="email" name="email" :value="old('email')" required autocomplete="username" />
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input id="password" class="block mt-1 w-full @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Подтвердите пароль</label>
                <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="auth-actions">
                <a href="{{ route('login') }}" class="secondary-link">
                    Уже есть аккаунт? Войти
                </a>

                <button type="submit" class="create-button">
                    Зарегистрироваться
                </button>
            </div>
        </form>
        <div class="social-login-container">
            <div class="separator">Или войдите с помощью</div>
            <div class="social-buttons">
                <a href="{{ route('socialite.redirect', 'github') }}" class="social-login-btn github-btn">
                    <i class="fab fa-github"></i> GitHub
                </a>
            </div>
        </div>
    </div>
@endsection
