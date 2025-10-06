@extends('layouts.layout')

@section('title', $paste->title ?? 'Просмотр пасты')

@section('content')
    <div class="paste-view-container">
        <div class="paste-meta-header">
            <h1 class="paste-title">{{ $paste->title ?? 'Без названия' }}</h1>
            <div class="meta-details">
                <span><strong>Автор:</strong> {{ $paste->user->name ?? 'Аноним' }}</span>
                <span><strong>Синтаксис:</strong> {{ $paste->programming_language }}</span>
                <span><strong>Создано:</strong> {{ $paste->created_at->format('d.m.Y в H:i') }}</span>
            </div>
        </div>

        <div class="paste-actions">

            <button id="copyLinkButton"
                    class="action-button"
                    data-visibility="{{ $paste->visibility  }}"
                    data-identifier="{{ $identifier }}">
                Скопировать ссылку
            </button>
            <button id="copyContentButton" class="action-button">Копировать содержимое</button>
        </div>
        <div class="paste-code-block">
            <pre><code>{!! $paste->text !!}</code></pre>
        </div>

        <div id="raw-content" style="display: none;">{{ $paste->text }}</div>
    </div>
@endsection

@push('scripts')
    <script>

        const copyLinkButton = document.getElementById('copyLinkButton');

        copyLinkButton.addEventListener('click', () => {
            const accessType = copyLinkButton.dataset.visibility;
            const identifier = copyLinkButton.dataset.identifier;
            let urlToCopy = '';

            if (accessType === 'unlisted') {
                urlToCopy = `${window.location.origin}/s/${identifier}`;
            } else {
                urlToCopy = `${window.location.origin}/${identifier}`;
            }
            console.log(accessType);
            navigator.clipboard.writeText(urlToCopy).then(() => {
                copyLinkButton.textContent = 'Ссылка скопирована!';
                copyLinkButton.style.backgroundColor = '#4caf50';
                setTimeout(() => {
                    copyLinkButton.textContent = 'Скопировать ссылку';
                    copyLinkButton.style.backgroundColor = '';
                }, 2000);
            }).catch(err => {
                console.error('Ошибка копирования ссылки: ', err);
                copyLinkButton.textContent = 'Ошибка!';
            });
        });



        const copyContentButton = document.getElementById('copyContentButton');
        const rawContent = document.getElementById('raw-content').textContent;

        copyContentButton.addEventListener('click', () => {
            navigator.clipboard.writeText(rawContent).then(() => {
                copyContentButton.textContent = 'Скопировано!';
                copyContentButton.style.backgroundColor = '#4caf50';

                setTimeout(() => {
                    copyContentButton.textContent = 'Копировать содержимое';
                    copyContentButton.style.backgroundColor = '';
                }, 2000);
            }).catch(err => {
                console.error('Ошибка копирования содержимого: ', err);
                copyContentButton.textContent = 'Ошибка!';
            });
        });
    </script>
@endpush
