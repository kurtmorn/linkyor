<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Play'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="large-text margin-bottom">Games</div>
        @forelse ($games as $game)
            <div class="col-1-4 mobile-col-1-3 set">
                <div class="card ellipsis">
                    <div class="thumbnail no-padding">
                        <a href="{{ route('games.view', $game->id) }}">
                            <img class="round-top" src="{{ $game->thumbnail() }}">
                        </a>
                    </div>
                    <div class="content">
                        <div class="name game-name ellipsis">
                            <a href="{{ route('games.view', $game->id) }}">{{ $game->name }}</a>
                        </div>
                        <div class="creator ellipsis">By <a href="{{ route('users.profile', $game->creator->id) }}">{{ $game->creator->username }}</a></div>
                    </div>
                    <div class="footer">
                        <div class="playing">{{ $game->playing }} Playing</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="center-text bold">There are no servers currently online :(</div>
        @endforelse
    </div>
    <div class="col-1-1 pages blue">{{ $games->onEachSide(1) }}</div>
@endsection
