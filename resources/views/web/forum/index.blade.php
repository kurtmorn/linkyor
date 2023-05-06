<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Forum'
])

@section('content')
    <div class="col-8-12">
        @include('web.forum._header')
    </div>
    <div class="col-8-12">
        <div class="card">
            @if ($topics->count() == 0)
                <span>There are currently no forum topics.</span>
            @else
                <div class="top blue">
                    <div class="col-7-12">{{ config('site.name') }}</div>
                    <div class="no-mobile overflow-auto topic text-center">
                        <div class="col-3-12 stat">Threads</div>
                        <div class="col-3-12 stat">Replies</div>
                        <div class="col-6-12"></div>
                    </div>
                </div>
                <div class="content">
                    @foreach ($topics as $topic)
                        <div class="board-info mb1">
                            <div class="col-7-12 board">
                                <div><a href="{{ route('forum.topic', $topic->id) }}" class="label dark">{{ $topic->name }}</a></div>
                                <span class="label small">{{ $topic->description }}</span>
                            </div>
                            <div class="no-mobile overflow-auto board ellipsis" style="overflow:hidden;">
                                <div class="col-3-12 stat">
                                    <span class="title">{{ number_format($topic->threads(false)->count()) }}</span>
                                </div>
                                <div class="col-3-12 stat">
                                    <span class="title">{{ number_format(0) }}</span>
                                </div>
                                <div class="col-6-12 text-right ellipsis pt2" style="max-width:180px;">
                                    @if ($topic->lastPost())
                                        <a href="{{ route('forum.thread', $topic->lastPost()->id) }}" class="label dark">{{ $topic->lastPost()->title }}</a>
                                        <br>
                                        <span class="label small">{{ $topic->lastPost()->updated_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="col-4-12">
        <div class="card">
            <div class="top">Recent Topics</div>
            <div class="content">
                @forelse ($recentThreads as $key => $thread)
                    <div class="thread">
                        <div class="col-10-12 ellipsis">
                            <div class="ellipsis mb1">
                                <a href="{{ route('forum.thread', $thread->id) }}" class="label dark">{{ $thread->title }}</a>
                            </div>
                            <div class="label small ellipsis">
                                by <a href="{{ route('users.profile', $thread->creator->id) }}" class="dark-gray-text">{{ $thread->creator->username }}</a> in <a href="{{ route('forum.topic', $thread->topic->id) }}" class="dark-gray-text">{{ $thread->topic->name }}</a>
                            </div>
                        </div>
                        <div class="col-2-12">
                            <div class="forum-tag">{{ number_format($thread->replies(false)->count()) }}</div>
                        </div>
                    </div>

                    @if ($key != $recentThreads->count() - 1)
                        <hr>
                    @endif
                @empty
                    <span>No topics found.</span>
                @endforelse
            </div>
        </div>
        <div class="card">
            <div class="top">Popular Topics</div>
            <div class="content">
                <span>Coming soon.</span>
            </div>
        </div>
    </div>
@endsection
