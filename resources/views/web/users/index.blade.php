<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Users'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="card">
            <div class="top blue">Search Users</div>
            <div class="content">
                <div class="col-1-1" style="text-align:center;margin-bottom:10px;padding-right:0;">
                    <form action="{{ route('users.index', $category) }}" method="GET">
                        <input class="input rigid" style="width:70%;margin-right:5px;" type="text" name="search" placeholder="Search users">
                        <button style="height:100%" class="blue shop-search-button" type="submit">SEARCH</button>
                        <a href="{{ route('users.index', 'online') }}" class="button green" style="font-size:14px;">ONLINE</a>
                    </form>
                </div>
                <div class="col-1-1" style="padding-right:0;">
                    <hr>
                    @forelse ($users as $user)
                        <a href="{{ route('users.profile', $user->id) }}">
                            <div class="search-user-card ellipsis">
                                <img src="{{ $user->thumbnail() }}">
                                <div class="data">
                                    <div class="ellipsis">
                                        <b>{{ $user->username }}</b>
                                        <span style="float:right;" class="status-dot {{ ($user->online()) ? 'online' : '' }}"></span>
                                    </div>
                                    <span class="ellipsis">{!! nl2br(e($user->description)) !!}</span>
                                </div>
                            </div>
                        </a>
                        <hr>
                    @empty
                        <div style="text-align:center">
                            <span>No users found.</span>
                        </div>
                    @endforelse
                    <div class="pages">{{ $users->onEachSide(1) }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
