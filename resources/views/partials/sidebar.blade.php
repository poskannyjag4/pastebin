<div class="sidebar-block">
    <h3>Последние публичные пасты</h3>
    <ul class="paste-list">
        @forelse ($latestPastes->latestPastes as $paste)
            <li>
                <a href="{{ route('paste.show', $paste->identifier) }}">{{ $paste->paste->title ?? 'Без названия' }}</a>
                <span>{{ $paste->paste->programming_language }} | {{ $paste->paste->created_at->diffForHumans() }}</span>
            </li>
        @empty
            <li>
                <p>Здесь пока нет публи чных паст.</p>
            </li>
        @endforelse
    </ul>
</div>


@auth
    <div class="sidebar-block">
        <h3>Мои последние пасты</h3>
        <ul class="paste-list">
            @forelse ($latestUserPastes->latestPastes as $paste)
                <li>
                    <a href="{{ route('paste.show', $paste->identifier) }}">{{ $paste->paste->title ?? 'Без названия' }}</a>
                    <span>{{ $paste->paste->programming_language }} | {{ $paste->paste->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li>
                    <p>Вы еще не создали ни одной пасты.</p>
                </li>
            @endforelse
        </ul>
    </div>
@endauth
