<div class="sidebar-block">
    <h3>Последние публичные пасты</h3>
    <ul class="paste-list">
        @forelse ($latestPastes as $hashId =>  $paste)
            <li>
                <a href="{{ route('paste.show', $hashId) }}">{{ $paste->title ?? 'Без названия' }}</a>
                <span>{{ $paste->programming_language }} | {{ $paste->created_at->diffForHumans() }}</span>
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
            @forelse ($latestUserPastes as $hashId => $paste)
                <li>
                    <a href="{{ route('paste.show', $hashId) }}">{{ $paste->title ?? 'Без названия' }}</a>
                    <span>{{ $paste->programming_language }} | {{ $paste->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li>
                    <p>Вы еще не создали ни одной пасты.</p>
                </li>
            @endforelse
        </ul>
    </div>
@endauth
