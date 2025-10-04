@extends('layouts.layout')

{{-- Заголовок страницы будет содержать название пасты, если оно есть --}}
@section('title', $paste->title ?? 'Просмотр пасты')

@section('content')
    <div class="paste-view-container">
        {{-- Блок с мета-информацией о пасте --}}
        <div class="paste-meta-header">
            <h1 class="paste-title">{{ $paste->title ?? 'Без названия' }}</h1>
            <div class="meta-details">
                <span><strong>Автор:</strong> {{ $paste->user->name ?? 'Аноним' }}</span>
                <span><strong>Синтаксис:</strong> {{ $paste->programming_language }}</span>
                <span><strong>Создано:</strong> {{ $paste->created_at->format('d.m.Y в H:i') }}</span>
            </div>
        </div>

        {{-- Блок с кнопками действий --}}
        <div class="paste-actions">
            <button id="copyButton" class="action-button">Копировать</button>
        </div>

        {{--
            Основной блок для отображения контента.
            Мы используем синтаксис {!! $paste->highlighted_content !!}, чтобы Blade
            отрисовал HTML, сгенерированный вашей библиотекой подсветки на бэкенде.
            Предполагается, что в контроллере вы создаете свойство ->highlighted_content.
        --}}
        <div class="paste-code-block">
            <pre><code>{!! $paste->text !!}</code></pre>
        </div>

        {{-- Скрытый элемент, содержащий "сырой" текст для копирования в буфер обмена --}}
        <div id="raw-content" style="display: none;">{{ $paste->text }}</div>
    </div>
@endsection

@push('scripts')
    <script>
        const copyButton = document.getElementById('copyButton');
        const rawContent = document.getElementById('raw-content').textContent;

        copyButton.addEventListener('click', () => {
            // Используем современный Clipboard API для асинхронного копирования
            navigator.clipboard.writeText(rawContent).then(() => {
                // Обратная связь для пользователя
                copyButton.textContent = 'Скопировано!';
                copyButton.style.backgroundColor = '#4caf50'; // Зеленый цвет успеха

                setTimeout(() => {
                    copyButton.textContent = 'Копировать';
                    copyButton.style.backgroundColor = ''; // Возвращаем исходный цвет
                }, 2000); // Через 2 секунды возвращаем текст обратно
            }).catch(err => {
                console.error('Ошибка копирования: ', err);
                copyButton.textContent = 'Ошибка!';
                copyButton.style.backgroundColor = '#e53e3e'; // Красный цвет ошибки
            });
        });
    </script>
@endpush
