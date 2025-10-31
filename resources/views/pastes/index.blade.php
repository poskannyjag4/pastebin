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
                       placeholder="Название"
                       class="@error('title') is-invalid @enderror">
                @error('title')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="programming_language">Подсветка синтаксиса:</label>
                <select id="programming_language" name="programming_language" class="@error('programming_language') is-invalid @enderror">
                    @foreach(\App\Enums\LanguageEnum::cases() as $lang)
                        <option value="{{$lang->name}}" @selected(old('programming_language') == $lang->name)>{{$lang->value}}</option>
                    @endforeach
                </select>
                @error('programming_language')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="expires_at">Срок действия:</label>
                <select id="expires_at" name="expires_at" class="@error('expires_at') is-invalid @enderror">
                    @foreach(\App\Enums\ExpirationEnum::cases() as $expiration)
                        <option value="{{$expiration->value}}" @selected(old('expires_at') == $expiration->value)>{{\App\Enums\ExpirationEnum::toHumanString($expiration)}}</option>
                    @endforeach
                </select>
                @error('expires_at')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="visibility">Доступ:</label>
                <select id="visibility" name="visibility">

                    @foreach(\App\Enums\VisibilityEnum::cases() as $visibility)
                        @if($visibility->name === 'private')
                            @auth
                                <option value="{{$visibility->name}}" @selected(old('visibility') == $visibility->name)>{{$visibility->value}}</option>
                            @endauth
                        @else
                            <option value="{{$visibility->name}}" @selected(old('visibility') == $visibility->name)>{{$visibility->value}}</option>
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
