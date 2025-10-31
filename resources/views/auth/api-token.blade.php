@extends('layouts.auth')
@section('title', 'API Токен')

@section('content')
    <div class="api-token-container">
        <h1>Ваш API Токен</h1>

        <div class="alert alert-warning">
            Скопируйте этот токен. Он отображается только один раз. Если вы потеряете его, вы можете сгенерировать новый, просто обновив эту страницу. Не сообщайте его никому!
        </div>

        <div class="token-display-wrapper">
            <pre id="apiTokenDisplay">{{ $token }}</pre>
            <button id="copyApiTokenBtn" class="action-btn info-btn">Копировать</button>
        </div>

        <a href="{{ route('paste.home') }}" class="secondary-link" style="margin-top: 20px; display: inline-block;">
            &larr; На главную
        </a>
    </div>

    @push('scripts')
        <script>
            const copyTokenBtn = document.getElementById('copyApiTokenBtn');
            const tokenDisplay = document.getElementById('apiTokenDisplay');

            copyTokenBtn.addEventListener('click', () => {
                navigator.clipboard.writeText(tokenDisplay.textContent).then(() => {
                    copyTokenBtn.textContent = 'Скопировано!';
                    setTimeout(() => {
                        copyTokenBtn.textContent = 'Копировать';
                    }, 2000);
                });
            });
        </script>
    @endpush
@endsection
