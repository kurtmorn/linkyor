<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

<div class="col-1-1" style="padding-right:0;">
    @forelse ($staffUsers as $staffUser)
        <a href="{{ route('users.profile', $staffUser->user->id) }}">
            <div class="search-user-card ellipsis">
                <img src="{{ $staffUser->user->thumbnail() }}">
                <div class="data">
                    <div class="ellipsis">
                        <b>{{ $staffUser->user->username }}</b>
                        <span style="float:right;" class="status-dot {{ ($staffUser->user->online()) ? 'online' : '' }}"></span>
                    </div>
                    <span class="ellipsis">{!! nl2br(e($staffUser->user->description)) !!}</span>
                </div>
            </div>
        </a>
        <hr>
    @empty
        <span>There are currently no staff.</span>
    @endforelse
    <div class="pages">{{ $staffUsers->onEachSide(1) }}</div>
</div>
