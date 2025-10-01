<div class="sidebar-block">
    <h3>Последние публичные пасты</h3>
    <ul class="paste-list">
        @forelse ($latestPublicPastes as $paste)
            <li>
                <a href="{{-- route('pastes.show', $paste->unique_id) --}}">{{ $paste->title ?? 'Без названия' }}</a>
                <span>{{ $paste->programming_language }} | {{ $paste->created_at->diffForHumans() }}</span>
            </li>
        @empty
            <li>
                <p>Здесь пока нет публичных паст.</p>
            </li>
        @endforelse
    </ul>
</div>


@auth
    <div class="sidebar-block">
        <h3>Мои последние пасты</h3>
        <ul class="paste-list">
            @forelse ($userLatestPastes as $paste)
                <li>
                    <a href="{{-- route('pastes.show', $paste->unique_id) --}}">{{ $paste->title ?? 'Без названия' }}</a>
                    <span>{{ $paste->syntax }} | {{ $paste->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li>
                    <p>Вы еще не создали ни одной пасты.</p>
                </li>
            @endforelse
        </ul>
    </div>
@endauth
