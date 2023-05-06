<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => $thread->title,
    'image' => $thread->creator->thumbnail()
])

@section('css')
    <style>.post_css_overwrite img{max-width:100%;}</style>
@endsection

@section('content')
    @if ($thread->is_deleted)
        <div class="col-10-12 push-1-12">
            <div class="alert error">
                This thread is deleted.
            </div>
        </div>
    @endif
    <div class="col-10-12 push-1-12">
        <div class="col-8-12">
            @include('web.forum._header')
        </div>
    </div>
    <div class="col-10-12 push-1-12">
        <div class="forum-bar mb2 ellipsis">
            <div class="inline mt2">
                <a href="{{ route('forum.index') }}">Forum</a>
                <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
                <a href="{{ route('forum.topic', $thread->topic->id) }}">{{ $thread->topic->name }}</a>
                <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
                <a href="{{ route('forum.thread', $thread->id) }}">
                    <span class="weight700 bold">{{ $thread->title }}</span>
                </a>
            </div>
            <div class="push-right">
                <a href="{{ route('forum.new', ['thread', $thread->topic->id]) }}" class="button small {{ $thread->topic->color() }}">CREATE</a>
            </div>
        </div>
        <div class="card">
            <div class="top {{ $thread->topic->color() }}">
                @if ($thread->is_pinned)
                    <span class="thread-label {{ $thread->topic->color() }}">Pinned</span>
                @endif

                @if ($thread->is_locked)
                    <span class="thread-label {{ $thread->topic->color() }}">Locked</span>
                @endif

                {{ $thread->title }}
                <div style="float:right">
                    <form method="POST" action="#" id="bookmark-submit">
                        @csrf
                        <input type="submit" id="bookmarkSubmit" style="display:none;">
                    </form>
                </div>
            </div>
            <div class="content">
                @if ($thread->replies()->currentPage() == 1)
                    @include('web.forum._reply', ['post' => $thread, 'isReply' => false])
                @endif

                @foreach ($thread->replies() as $reply)
                    @include('web.forum._reply', ['post' => $reply, 'isReply' => true])
                @endforeach
            </div>
        </div>
        <div class="center-text">
            <div class="pages mb2">{{ $thread->replies()->onEachSide(1) }}</div>
            @if (!Auth::check() || (!Auth::user()->isStaff() && $thread->is_locked))
                <a class="button no-click">REPLY</a>
            @else
                <a href="{{ route('forum.new', ['reply', $thread->id]) }}" class="button {{ $thread->topic->color() }}">REPLY</a>
            @endif
        </div>
    </div>
@endsection
