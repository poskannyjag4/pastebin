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
                    {{-- @foreach(\App\Enums\ExpirationEnum::cases() as $expiration)
                        <option value="{{$expiration->name}}" @selected(old('expires_at') == $expiration->name)>{{$expiration->value}}</option>
                    @endforeach --}}
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
        const month = 40320;
        const week = 10080;
        const day = 1440;
        const hour = 60;
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

        function parseExpiration(expiration){
            console.log(expiration/10080);
            if(expiration == 0)
                return 'Никогда';

            if(expiration%week == 0){
                let curWeeks = expiration/week;
                if(curWeeks == 1)
                    return curWeeks + ' неделя';
                if(curWeeks >3){
                    if(curWeeks == 4)
                        return curWeeks/4 + ' месяц';
                    else
                        return curWeeks + ' месяцев'
                }
                return curWeeks + ' недель'
            }

            if(expiration%day == 0){
                let curDays = expiration/day;
                if(curDays == 1)
                    return curDays + ' день';
                return curDays + ' дней';
            }
            if(expiration%hour == 0){
                let curHours = expiration/hour;
                if(curHours == 1)
                    return curHours + ' час';
                return curHours + ' часов'
            }
            
            return expiration + ' минут';
        }

        const possibleValues = [0, 10, 60, 180, 1440, 10080, 40320]; //Возможные варианты истечения пасты в минутах
        let expirationSelect = document.getElementById('expires_at');
        possibleValues.forEach(element => {
            let option = document.createElement('option');
            console.log(element);
            option.value = element;
            option.innerText = parseExpiration(element);
            expirationSelect.appendChild(option);
        });
        
    </script>
@endpush
