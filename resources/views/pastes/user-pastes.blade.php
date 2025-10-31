@extends('layouts.layout')

@section('title', 'Мои пасты')

@section('content')
    <h1>Мои пасты</h1>

    @if ($pastes->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Название / Содержимое</th>
                    <th>Синтаксис</th>
                    <th>Доступ</th>
                    <th>Создано</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pastes as $paste)
                    <tr>
                        <td>

                            <a href="{{ route('paste.show', $hashIds[$loop->index]) }}" class="paste-title-link">
                                {{ $paste->title}}
                            </a>
                        </td>
                        <td>{{ $paste->programming_language }}</td>
                        <td>
                            <span class="access-badge access-{{ $paste->visibility }}">
                                    {{ \App\Enums\VisibilityEnum::fromName($paste->visibility) }}
                                </span>
                        </td>
                        <td>{{ $paste->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-links">
            {{ $pastes->links() }}
        </div>

    @else
        <div class="no-pastes-message">
            <p>Вы еще не создали ни одной пасты.</p>
            <a href="{{ route('paste.home') }}" class="create-button" style="width: auto; padding: 10px 20px;">Создать первую пасту</a>
        </div>
    @endif
@endsection
