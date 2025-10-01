@extends('layouts.layout')

@section('title', 'Создать новую пасту')


@section('content')
    <h1>Создать новую пасту</h1>

    <form action="{{ route('paste.store') }} " method="POST">
        @csrf

        <div class="form-group">
            <label for="content">Ваш текст или код:</label>
            <textarea id="pasteContent"
                      name="content"
                      class="paste-textarea @error('content') is-invalid @enderror"
                      placeholder="Вставьте ваш текст или код сюда..."
                      required>{{ old('content') }}</textarea>

            @error('content')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="options-grid">
            <div class="form-group">
                <label for="title">Название / Заголовок:</label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
                       placeholder="Необязательно"
                       class="@error('title') is-invalid @enderror">
                @error('title')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="syntax">Подсветка синтаксиса:</label>
                <select id="syntax" name="syntax" class="@error('syntax') is-invalid @enderror">
                    <option value="plaintext" @selected(old('syntax') == 'plaintext')>Простой текст</option>
                    <option value="javascript" @selected(old('syntax') == 'javascript')>JavaScript</option>
                    <option value="python" @selected(old('syntax') == 'python')>Python</option>
                    <option value="html" @selected(old('syntax') == 'html')>HTML</option>
                    <option value="css" @selected(old('syntax') == 'css')>CSS</option>
                    <option value="php" @selected(old('syntax') == 'php')>PHP</option>
                    <option value="sql" @selected(old('syntax') == 'sql')>SQL</option>
                    <option value="java" @selected(old('syntax') == 'java')>Java</option>
                </select>
                @error('syntax')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="expiration">Срок действия:</label>
                <select id="expiration" name="expiration">
                    <option value="never" @selected(old('expiration') == 'never')>Никогда</option>
                    <option value="10m" @selected(old('expiration') == '10m')>10 минут</option>
                    <option value="1h" @selected(old('expiration') == '1h')>1 час</option>
                    <option value="1d" @selected(old('expiration') == '1d')>1 день</option>
                    <option value="1w" @selected(old('expiration') == '1w')>1 неделя</option>
                </select>
            </div>

            <div class="form-group">
                <label for="access">Доступ:</label>
                <select id="access" name="access">
                    <option value="public" @selected(old('access') == 'public')>Публичный</option>
                    <option value="unlisted" @selected(old('access') == 'unlisted')>По ссылке</option>
                    @auth
                    <option value="private" @selected(old('access') == 'private')>Приватный (только для меня)</option>
                    @endauth
                </select>
            </div>
        </div>

        <button type="submit" class="create-button">Создать новую пасту</button>
    </form>
@endsection

@push('scripts')
    <script>
        const textarea = document.getElementById('pasteContent');

        function autoResize() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        }

        textarea.addEventListener('input', autoResize, false);

        document.addEventListener('DOMContentLoaded', () => {
            if (textarea.value) {
                autoResize.call(textarea);
            }
        });
    </script>
@endpush
