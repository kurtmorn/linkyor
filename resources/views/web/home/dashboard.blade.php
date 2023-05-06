<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Dashboard'
])

@section('content')

    <div class="col-10-12 push-1-12">
        <div class="col-4-12">
            <div class="card">
                <div class="content rounded center-text">
                    <img src="{{ Auth::user()->thumbnail() }}" style="width:100%;">
                    <span class="bold gray-text">{{ Auth::user()->username }}</span>
                    <hr>
                    <div class="col-4-12 p0">
                        <div class="very-bold red-text smedium-text">{{ number_format(Auth::user()->friends()->count()) }}</div>
                        <div class="gray-text cap-text bold small-text">Friends</div>
                    </div>
                    <div class="col-4-12 p0">
                        <div class="very-bold blue-text smedium-text">{{ number_format(Auth::user()->forumPostCount()) }}</div>
                        <div class="gray-text cap-text bold small-text">Posts</div>
                    </div>
                    <div class="col-4-12 p0">
                        <div class="very-bold green-text smedium-text">{{ number_format(Auth::user()->visitCount()) }}</div>
                        <div class="gray-text cap-text bold small-text">Visits</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="top red">News</div>
                <div class="content">
                    @forelse ($updates as $update)
                        <div class="block">
                            <a href="{{ route('forum.thread', $update->id) }}" class="very-bold dark-gray-text block ellipsis">{{ $update->title }}</a>
                            <div class="gray-text block status-block">by <b>{{ $update->creator->username }}</b></div>
                            <span class="bold light-gray-text status-time" title="{{ $update->created_at->diffForHumans() }}">{{ $update->created_at->format('d/m/Y h:i A') }}</span>
                        </div>
                        <hr>
                    @empty
                        <span>No news found.</span>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-8-12">
            <div class="card">
                <div class="top blue">About Me</div>
                <div class="content">
                    <span class="gray-text very-hold">Status:</span>
                    <form style="width:75%;" class="pb3" method="POST" action="{{ route('home.status') }}">
                        @csrf
                        <div class="input-group fill">
                            <input name="message" placeholder="Right now I'm..." type="text">
                            <button class="input-button" type="submit">Post</button>
                        </div>
                    </form>
                    <span class="gray-text very-bold">Blurb:</span>
                    <form method="POST" action="{{ route('account.settings.update') }}">
                        @csrf
                        <input type="hidden" name="type" value="description">
                        <textarea class="width-100 mb1" style="height:80px;" name="description" placeholder="Hi, my name is {{ Auth::user()->username }}">{{ Auth::user()->description }}</textarea>
                        <button class="button small smaller-text blue" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="top orange">My Feed</div>
                <div class="content">
                    @forelse ($statuses as $status)
                        <div class="status">
                            <a href="{{ route('users.profile', $status->creator->id) }}">
                                <img src="{{ $status->creator->thumbnail() }}">
                            </a>
                            <div class="status-text ellipsis">
                                <a href="{{ route('users.profile', $status->creator->id) }}" class="very-bold dark-gray-text block">{{ $status->creator->username }}</a>
                                <div class="status-body gray-text">{{ $status->message }}</div>
                                <span class="bold dark-gray-text status-time absolute bottom" title="{{ $status->created_at->diffForHumans() }}">{{ $status->created_at->format('d/m/Y h:i A') }}</span>
                            </div>
                        </div>
                        <hr>
                    @empty
                        <span>Your feed is empty.</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
