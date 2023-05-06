<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => $topic->name
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="col-8-12">
            @include('web.forum._header')
        </div>
    </div>
    <div class="col-10-12 push-1-12">
        @if (Auth::check() && ((Auth::user()->isStaff() && $topic->is_staff_only_posting) || !$topic->is_staff_only_posting))
            <div class="push-right mobile-col-1-1 pr0">
                <a href="{{ route('forum.new', ['thread', $topic->id]) }}" class="button small {{ $topic->color() }}">CREATE</a>
            </div>
        @endif
        <div class="forum-bar weight600" style="padding:10px 5px 10px 0;">
            <a href="{{ route('forum.index') }}">Forum</a>
            <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
            <a href="{{ route('forum.topic', $topic->id) }}">{{ $topic->name }}</a>
        </div>
        <div class="card">
            <div class="top {{ $topic->color() }}">
                <div class="col-7-12">{{ $topic->name }}</div>
                <div class="no-mobile overflow-auto topic text-center">
                    <div class="col-3-12 stat">Replies</div>
                    <div class="col-3-12 stat">Views</div>
                    <div class="col-5-12"></div>
                </div>
            </div>
            <div class="content" style="padding: 0px">
                @forelse ($topic->threads() as $thread)
                    <div class="hover-card m0 thread-card" style="{{ ($thread->is_deleted) ? 'opacity:.5;' : '' }}">
                        <div class="col-7-12 topic ellipsis">
                            @if ($thread->is_pinned)
                                <span class="thread-label {{ $topic->color() }}">Pinned</span>
                            @endif
                            @if ($thread->is_locked)
                                <span class="thread-label {{ $topic->color() }}">Locked</span>
                            @endif
                            <a href="{{ route('forum.thread', $thread->id) }}">
                                <span class="small-text label dark">{{ $thread->title }}</span>
                            </a>
                            <br>
                            <span class="label smaller-text">By <a href="{{ route('users.profile', $thread->creator->id) }}" class="darkest-gray-text">{{ $thread->creator->username }}</a></span>
                        </div>
                        <div class="no-mobile overflow-auto topic">
                            <div class="col-3-12 pt2 stat center-text">
                                <span class="title">{{ number_format($thread->replies(false)->count()) }}</span>
                            </div>
                            <div class="col-3-12 pt2 stat center-text">
                                <span class="title">{{ number_format($thread->views ?? 0) }}</span>
                            </div>
                            <div class="col-6-12 post ellipsis text-right">
                                <span class="label dark small-text"></span>
                                @if ($thread->lastReply())
                                    <span class="label dark small-text">{{ $thread->lastReply()->created_at->diffForHumans() }}</span>
                                    <br>
                                    <span class="label dark-gray-text smaller-text">By <a href="{{ route('users.profile', $thread->lastReply()->creator->username) }}" class="darkest-gray-text">{{ $thread->lastReply()->creator->username }}</a></span>
                                @else
                                    <span class="label dark small-text">{{ $thread->created_at->diffForHumans() }}</span>
                                    <br>
                                    <span class="label dark-gray-text smaller-text">By <a href="{{ route('users.profile', $thread->creator->username) }}" class="darkest-gray-text">{{ $thread->creator->username }}</a></span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:10px;">Nothing here :(</div>
                @endforelse
            </div>
        </div>
        <div class="pages {{ $topic->color() }}">{{ $topic->threads()->onEachSide(1) }}</div>
    </div>
@endsection
