<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Friends'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="card">
            <div class="top blue">Friends</div>
            <div class="content text-center">
                @if ($friendRequests->count() == 0)
                    <span>You don't have any friend requests</span>
                @else
                    <ul class="friends-list">
                        @foreach ($friendRequests as $friendRequest)
                            <li class="col-1-5 mobile-col-1-1">
                                <div class="friend-card">
                                    <a href="{{ route('users.profile', $friendRequest->sender->id) }}">
                                        <img src="{{ $friendRequest->sender->thumbnail() }}">
                                        <div class="ellipsis">{{ $friendRequest->sender->username }}</div>
                                    </a>
                                    <form action="{{ route('account.friends.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $friendRequest->sender->id }}">
                                        <button class="button small green inline" style="left:10px;font-size:10px;" name="action" value="accept">ACCEPT</button>
                                        <button class="button small red inline" style="left:10px;font-size:10px;" name="action" value="decline">DECLINE</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="pages">{{ $friendRequests->onEachSide(1) }}</div>
    </div>
@endsection
