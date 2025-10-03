@extends('layouts.layout')

@section('title', 'Создать новую пасту')


@section('content')
    <h1>Создать новую пасту</h1>

    <form action="{{ route('paste.store') }} " method="POST">
        @csrf

        <div class="form-group">
            <label for="text">Ваш текст или код:</label>
            <textarea id="pasteContent"
                      name="text"
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
                <label for="programming_language">Подсветка синтаксиса:</label>
                <select id="programming_language" name="programming_language" class="@error('syntax') is-invalid @enderror">
                    @foreach(\App\Enums\LanguageEnum::cases() as $lang)
                        <option value="{{$lang->name}}" @selected(old('syntax') == $lang->name)>{{$lang->value}}</option>
                    @endforeach
                </select>
                @error('syntax')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="expiration_at">Срок действия:</label>
                <select id="expiration_at" name="expiration_at">
                    @foreach(\App\Enums\ExpirationEnum::cases() as $expiration)
                        <option value="{{$expiration->name}}" @selected(old('expiration') == $expiration->name)>{{$expiration->value}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="visibility">Доступ:</label>
                <select id="visibility" name="visibility">

                    @foreach(\App\Enums\VisibilityEnum::cases() as $visibility)
                        @if($visibility->name === 'private')
                            @auth
                                <option value="{{$visibility->name}}" @selected(old('access') == $visibility->name)>{{$visibility->value}}</option>
                            @endauth
                        @else
                            <option value="{{$visibility->name}}" @selected(old('access') == $visibility->name)>{{$visibility->value}}</option>
                        @endif
                    @endforeach
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
